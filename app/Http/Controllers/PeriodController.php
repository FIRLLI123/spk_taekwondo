<?php

namespace App\Http\Controllers;

use App\Models\Period;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PeriodController extends Controller
{
    public function index()
    {
        return view('periods.index', [
            'periods' => Period::orderByDesc('start_date')->paginate(10),
        ]);
    }

    public function create()
    {
        return view('periods.form', [
            'period' => new Period(),
            'isEdit' => false,
        ]);
    }

    public function store(Request $request)
    {
        Period::create($this->validateRequest($request));

        return redirect()
            ->route('periods.index')
            ->with('status', 'Periode berhasil ditambahkan.');
    }

    public function edit(Period $period)
    {
        return view('periods.form', [
            'period' => $period,
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, Period $period)
    {
        $period->update($this->validateRequest($request));

        return redirect()
            ->route('periods.index')
            ->with('status', 'Periode berhasil diperbarui.');
    }

    public function destroy(Period $period)
    {
        $period->delete();

        return redirect()
            ->route('periods.index')
            ->with('status', 'Periode berhasil dihapus.');
    }

    protected function validateRequest(Request $request)
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'status' => ['required', Rule::in(['draft', 'aktif', 'selesai'])],
        ]);
    }
}
