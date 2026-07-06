<?php

namespace App\Http\Controllers;

use App\Models\Athlete;
use App\Models\Criterion;
use App\Models\Period;
use App\Models\Score;
use App\Services\TopsisService;
use Illuminate\Http\Request;
use RuntimeException;

class TopsisController extends Controller
{
    protected $topsisService;

    public function __construct(TopsisService $topsisService)
    {
        $this->topsisService = $topsisService;
    }

    public function index(Request $request)
    {
        $periods = Period::orderByDesc('start_date')->get();
        $selectedPeriodId = $request->get('period_id') ?: optional($periods->firstWhere('status', 'aktif'))->id;
        $selectedPeriod = $selectedPeriodId ? $periods->firstWhere('id', (int) $selectedPeriodId) : null;
        $summary = null;

        if ($selectedPeriod) {
            $athleteCount = Athlete::where('status', 'aktif')->count();
            $criterionCount = Criterion::count();
            $expectedCells = $athleteCount * $criterionCount;
            $filledCells = (int) Score::query()
                ->selectRaw('COUNT(DISTINCT CONCAT(athlete_id, "-", criterion_id)) AS total')
                ->where('period_id', $selectedPeriod->id)
                ->value('total');

            $summary = [
                'athlete_count' => $athleteCount,
                'criterion_count' => $criterionCount,
                'expected_cells' => $expectedCells,
                'filled_cells' => $filledCells,
                'score_entries' => Score::where('period_id', $selectedPeriod->id)->count(),
                'coach_count' => Score::where('period_id', $selectedPeriod->id)->distinct('user_id')->count('user_id'),
                'last_run' => $selectedPeriod->topsisResults()->latest()->first(),
            ];
        }

        return view('topsis.index', compact('periods', 'selectedPeriod', 'summary'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'period_id' => ['required', 'exists:periods,id'],
        ]);

        $period = Period::findOrFail($validated['period_id']);

        try {
            $results = $this->topsisService->calculateForPeriod($period);
        } catch (RuntimeException $exception) {
            return redirect()
                ->route('topsis.process', ['period_id' => $period->id])
                ->withErrors(['period_id' => $exception->getMessage()]);
        }

        return redirect()
            ->route('rankings.index', ['period_id' => $period->id])
            ->with('status', 'Proses TOPSIS berhasil dijalankan untuk ' . $results->count() . ' atlet.');
    }
}
