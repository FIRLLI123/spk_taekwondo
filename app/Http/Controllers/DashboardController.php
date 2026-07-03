<?php

namespace App\Http\Controllers;

use App\Models\Athlete;
use App\Models\Criterion;
use App\Models\Period;
use App\Models\Score;
use App\Models\TopsisResult;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $latestPeriod = Period::latest('end_date')->first();
        $bestAthlete = null;

        if ($latestPeriod) {
            $bestAthlete = TopsisResult::with('athlete')
                ->where('period_id', $latestPeriod->id)
                ->orderBy('rank')
                ->first();
        }

        return view('dashboard.index', [
            'stats' => [
                'athletes' => Athlete::count(),
                'criteria' => Criterion::count(),
                'scores' => Score::count(),
                'users' => User::count(),
            ],
            'latestPeriod' => $latestPeriod,
            'bestAthlete' => $bestAthlete,
        ]);
    }
}
