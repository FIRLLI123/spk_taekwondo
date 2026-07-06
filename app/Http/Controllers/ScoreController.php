<?php

namespace App\Http\Controllers;

use App\Models\Athlete;
use App\Models\Criterion;
use App\Models\Period;
use App\Models\Score;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScoreController extends Controller
{
    public function index(Request $request)
    {
        $periods = Period::orderByDesc('start_date')->get();
        $selectedPeriodId = $request->get('period_id') ?: optional($periods->firstWhere('status', 'aktif'))->id;
        $selectedPeriod = $selectedPeriodId ? $periods->firstWhere('id', (int) $selectedPeriodId) : null;
        $criteria = Criterion::orderBy('code')->get();
        $athletes = Athlete::where('status', 'aktif')->orderBy('name')->get();
        $scoreValues = collect();
        $progress = null;

        if ($selectedPeriod) {
            $scoreValues = Score::where('period_id', $selectedPeriod->id)
                ->where('user_id', auth()->id())
                ->get()
                ->mapWithKeys(function ($score) {
                    return [$score->athlete_id . '-' . $score->criterion_id => $score->score];
                });

            $distinctCellsCount = Score::query()
                ->selectRaw('COUNT(DISTINCT CONCAT(athlete_id, "-", criterion_id)) AS total')
                ->where('period_id', $selectedPeriod->id)
                ->value('total');

            $expectedCells = $athletes->count() * $criteria->count();
            $progress = [
                'expected_cells' => $expectedCells,
                'user_cells' => (int) Score::query()
                    ->selectRaw('COUNT(DISTINCT CONCAT(athlete_id, "-", criterion_id)) AS total')
                    ->where('period_id', $selectedPeriod->id)
                    ->where('user_id', auth()->id())
                    ->value('total'),
                'all_cells' => (int) $distinctCellsCount,
            ];
        }

        return view('scores.index', compact(
            'periods',
            'selectedPeriod',
            'criteria',
            'athletes',
            'scoreValues',
            'progress'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'period_id' => ['required', 'exists:periods,id'],
            'scores' => ['required', 'array'],
            'scores.*' => ['array'],
            'scores.*.*' => ['nullable', 'numeric', 'min:0', 'max:100'],
        ]);

        $period = Period::findOrFail($validated['period_id']);
        $allowedAthleteIds = Athlete::where('status', 'aktif')->pluck('id')->all();
        $criterionIds = Criterion::pluck('id')->all();
        $rows = [];

        foreach ($validated['scores'] as $athleteId => $criterionScores) {
            if (! in_array((int) $athleteId, $allowedAthleteIds, true)) {
                continue;
            }

            foreach ($criterionScores as $criterionId => $value) {
                if (! in_array((int) $criterionId, $criterionIds, true) || $value === null || $value === '') {
                    continue;
                }

                $rows[] = [
                    'period_id' => $period->id,
                    'athlete_id' => (int) $athleteId,
                    'criterion_id' => (int) $criterionId,
                    'user_id' => auth()->id(),
                    'score' => $value,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::transaction(function () use ($period, $rows) {
            Score::where('period_id', $period->id)
                ->where('user_id', auth()->id())
                ->delete();

            if (! empty($rows)) {
                Score::insert($rows);
            }
        });

        return redirect()
            ->route('scores.index', ['period_id' => $period->id])
            ->with('status', 'Penilaian berhasil disimpan.');
    }
}
