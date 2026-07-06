<?php

namespace App\Http\Controllers;

use App\Models\Period;
use App\Models\TopsisResult;
use Illuminate\Http\Request;

class RankingController extends Controller
{
    public function index(Request $request)
    {
        $periods = Period::orderByDesc('start_date')->get();
        $selectedPeriodId = $request->get('period_id') ?: optional($periods->first())->id;
        $selectedPeriod = $selectedPeriodId ? $periods->firstWhere('id', (int) $selectedPeriodId) : null;
        $results = collect();
        $detailResult = null;

        if ($selectedPeriod) {
            $results = TopsisResult::with('athlete')
                ->where('period_id', $selectedPeriod->id)
                ->orderBy('rank')
                ->get();

            $detailResultId = $request->get('result_id');
            $detailResult = $detailResultId
                ? $results->firstWhere('id', (int) $detailResultId)
                : $results->first();
        }

        return view('rankings.index', compact('periods', 'selectedPeriod', 'results', 'detailResult'));
    }
}
