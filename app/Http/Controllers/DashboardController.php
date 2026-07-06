<?php

namespace App\Http\Controllers;

use App\Models\Athlete;
use App\Models\Criterion;
use App\Models\Period;
use App\Models\Score;
use App\Models\TopsisResult;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $latestPeriod = Period::latest('end_date')->first();
        $bestAthlete = null;
        $topRankings = collect();
        $chartData = [
            'ranking_labels' => [],
            'ranking_values' => [],
            'criteria_labels' => [],
            'criteria_weights' => [],
        ];

        if ($latestPeriod) {
            $topRankings = TopsisResult::with('athlete')
                ->where('period_id', $latestPeriod->id)
                ->orderBy('rank')
                ->take(5)
                ->get();

            $bestAthlete = $topRankings->first();
        }

        $criteria = Criterion::orderBy('code')->get();
        $averageScoresByCriterion = collect();

        if ($latestPeriod) {
            $averageScoresByCriterion = Score::query()
                ->selectRaw('criterion_id, AVG(score) as average_score')
                ->where('period_id', $latestPeriod->id)
                ->groupBy('criterion_id')
                ->pluck('average_score', 'criterion_id');
        }

        $chartData = [
            'ranking_labels' => $topRankings->map(function ($result) {
                return optional($result->athlete)->name ?: 'Atlet';
            })->values()->all(),
            'ranking_values' => $topRankings->map(function ($result) {
                return round((float) $result->preference_value, 4);
            })->values()->all(),
            'criteria_labels' => $criteria->map(function ($criterion) {
                return $criterion->code . ' - ' . $criterion->name;
            })->values()->all(),
            'criteria_weights' => $criteria->map(function ($criterion) {
                return round((float) $criterion->weight, 4);
            })->values()->all(),
            'criteria_averages' => $criteria->map(function ($criterion) use ($averageScoresByCriterion) {
                return round((float) ($averageScoresByCriterion[$criterion->id] ?? 0), 2);
            })->values()->all(),
        ];

        return view('dashboard.index', [
            'stats' => [
                'athletes' => Athlete::count(),
                'criteria' => Criterion::count(),
                'scores' => Score::count(),
                'users' => User::count(),
            ],
            'latestPeriod' => $latestPeriod,
            'bestAthlete' => $bestAthlete,
            'topRankings' => $topRankings,
            'chartData' => $chartData,
        ]);
    }
}
