<?php

namespace App\Services;

use App\Models\Criterion;
use App\Models\Period;
use App\Models\Score;
use App\Models\TopsisResult;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class TopsisService
{
    public function calculateForPeriod(Period $period)
    {
        $criteria = Criterion::orderBy('code')->get();

        if ($criteria->isEmpty()) {
            throw new RuntimeException('Belum ada data kriteria untuk diproses.');
        }

        $aggregates = Score::query()
            ->selectRaw('athlete_id, criterion_id, AVG(score) as average_score')
            ->where('period_id', $period->id)
            ->groupBy('athlete_id', 'criterion_id')
            ->get();

        if ($aggregates->isEmpty()) {
            throw new RuntimeException('Belum ada data penilaian pada periode yang dipilih.');
        }

        $athleteIds = $aggregates->pluck('athlete_id')->unique()->values();
        $criterionIds = $criteria->pluck('id');
        $expectedCellCount = $athleteIds->count() * $criterionIds->count();

        if ($aggregates->count() !== $expectedCellCount) {
            throw new RuntimeException('Data penilaian belum lengkap untuk semua atlet dan kriteria.');
        }

        $athletes = $period->scores()
            ->with('athlete')
            ->get()
            ->pluck('athlete')
            ->filter()
            ->unique('id')
            ->sortBy('name')
            ->values()
            ->keyBy('id');

        $decisionMatrix = [];

        foreach ($aggregates as $aggregate) {
            $decisionMatrix[$aggregate->athlete_id][$aggregate->criterion_id] = (float) $aggregate->average_score;
        }

        $divisors = [];
        foreach ($criteria as $criterion) {
            $sumSquares = 0;
            foreach ($athleteIds as $athleteId) {
                $sumSquares += pow($decisionMatrix[$athleteId][$criterion->id], 2);
            }

            $divisors[$criterion->id] = $sumSquares > 0 ? sqrt($sumSquares) : 0;
        }

        $normalizedMatrix = [];
        $weightedMatrix = [];

        foreach ($athleteIds as $athleteId) {
            foreach ($criteria as $criterion) {
                $rawValue = $decisionMatrix[$athleteId][$criterion->id];
                $normalizedValue = $divisors[$criterion->id] > 0
                    ? $rawValue / $divisors[$criterion->id]
                    : 0;

                $weightedValue = $normalizedValue * (float) $criterion->weight;

                $normalizedMatrix[$athleteId][$criterion->id] = $normalizedValue;
                $weightedMatrix[$athleteId][$criterion->id] = $weightedValue;
            }
        }

        $positiveIdeal = [];
        $negativeIdeal = [];

        foreach ($criteria as $criterion) {
            $values = array_map(function ($row) use ($criterion) {
                return $row[$criterion->id];
            }, $weightedMatrix);

            $positiveIdeal[$criterion->id] = $criterion->attribute === 'benefit'
                ? max($values)
                : min($values);
            $negativeIdeal[$criterion->id] = $criterion->attribute === 'benefit'
                ? min($values)
                : max($values);
        }

        $results = [];

        foreach ($athleteIds as $athleteId) {
            $positiveDistanceSquares = 0;
            $negativeDistanceSquares = 0;

            foreach ($criteria as $criterion) {
                $weightedValue = $weightedMatrix[$athleteId][$criterion->id];
                $positiveDistanceSquares += pow($weightedValue - $positiveIdeal[$criterion->id], 2);
                $negativeDistanceSquares += pow($weightedValue - $negativeIdeal[$criterion->id], 2);
            }

            $positiveDistance = sqrt($positiveDistanceSquares);
            $negativeDistance = sqrt($negativeDistanceSquares);
            $preference = ($positiveDistance + $negativeDistance) > 0
                ? $negativeDistance / ($positiveDistance + $negativeDistance)
                : 0;

            $results[] = [
                'athlete_id' => $athleteId,
                'athlete_name' => optional($athletes->get($athleteId))->name,
                'positive_distance' => $positiveDistance,
                'negative_distance' => $negativeDistance,
                'preference_value' => $preference,
                'decision_matrix' => $decisionMatrix[$athleteId],
                'normalized_matrix' => $normalizedMatrix[$athleteId],
                'weighted_matrix' => $weightedMatrix[$athleteId],
            ];
        }

        usort($results, function ($left, $right) {
            if ($left['preference_value'] === $right['preference_value']) {
                return strcmp((string) $left['athlete_name'], (string) $right['athlete_name']);
            }

            return $right['preference_value'] <=> $left['preference_value'];
        });

        DB::transaction(function () use ($period, $results, $criteria, $positiveIdeal, $negativeIdeal) {
            TopsisResult::where('period_id', $period->id)->delete();

            foreach ($results as $index => $result) {
                TopsisResult::create([
                    'period_id' => $period->id,
                    'athlete_id' => $result['athlete_id'],
                    'preference_value' => $result['preference_value'],
                    'positive_distance' => $result['positive_distance'],
                    'negative_distance' => $result['negative_distance'],
                    'rank' => $index + 1,
                    'calculation_detail' => [
                        'criteria' => $criteria->map(function ($criterion) {
                            return [
                                'id' => $criterion->id,
                                'code' => $criterion->code,
                                'name' => $criterion->name,
                                'weight' => (float) $criterion->weight,
                                'attribute' => $criterion->attribute,
                            ];
                        })->values()->all(),
                        'decision_matrix' => $result['decision_matrix'],
                        'normalized_matrix' => $result['normalized_matrix'],
                        'weighted_matrix' => $result['weighted_matrix'],
                        'positive_ideal' => $positiveIdeal,
                        'negative_ideal' => $negativeIdeal,
                    ],
                ]);
            }
        });

        return collect($results);
    }
}
