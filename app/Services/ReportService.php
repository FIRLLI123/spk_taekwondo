<?php

namespace App\Services;

use App\Models\Criterion;
use App\Models\Period;
use App\Models\Score;
use App\Models\TopsisResult;

class ReportService
{
    public function build($periodId = null)
    {
        $periods = Period::orderByDesc('start_date')->get();
        $selectedPeriodId = $periodId ?: optional($periods->first())->id;
        $selectedPeriod = $selectedPeriodId ? $periods->firstWhere('id', (int) $selectedPeriodId) : null;
        $criteria = Criterion::orderBy('code')->get();
        $results = collect();
        $scoreMatrix = collect();
        $scoreStats = [
            'coach_count' => 0,
            'score_entries' => 0,
            'athlete_count' => 0,
            'criteria_count' => $criteria->count(),
        ];

        if ($selectedPeriod) {
            $results = TopsisResult::with('athlete')
                ->where('period_id', $selectedPeriod->id)
                ->orderBy('rank')
                ->get();

            $averages = Score::query()
                ->selectRaw('athlete_id, criterion_id, AVG(score) as average_score')
                ->with('athlete')
                ->where('period_id', $selectedPeriod->id)
                ->groupBy('athlete_id', 'criterion_id')
                ->get();

            $scoreMatrix = $averages
                ->groupBy('athlete_id')
                ->map(function ($items) {
                    $first = $items->first();
                    $scores = [];

                    foreach ($items as $item) {
                        $scores[$item->criterion_id] = (float) $item->average_score;
                    }

                    return [
                        'athlete_code' => optional($first->athlete)->code,
                        'athlete_name' => optional($first->athlete)->name,
                        'scores' => $scores,
                    ];
                })
                ->sortBy('athlete_name')
                ->values();

            $scoreStats = [
                'coach_count' => Score::where('period_id', $selectedPeriod->id)->distinct('user_id')->count('user_id'),
                'score_entries' => Score::where('period_id', $selectedPeriod->id)->count(),
                'athlete_count' => $scoreMatrix->count(),
                'criteria_count' => $criteria->count(),
            ];
        }

        return compact(
            'periods',
            'selectedPeriod',
            'criteria',
            'results',
            'scoreMatrix',
            'scoreStats'
        );
    }
}
