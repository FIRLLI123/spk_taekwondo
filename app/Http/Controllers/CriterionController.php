<?php

namespace App\Http\Controllers;

use App\Models\Criterion;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CriterionController extends Controller
{
    public function index()
    {
        return view('criteria.index', [
            'criteria' => Criterion::orderBy('code')->paginate(10),
        ]);
    }

    public function create()
    {
        return view('criteria.form', [
            'criterion' => new Criterion(),
            'isEdit' => false,
        ]);
    }

    public function store(Request $request)
    {
        Criterion::create($this->validateRequest($request));

        return redirect()
            ->route('criteria.index')
            ->with('status', 'Kriteria berhasil ditambahkan.');
    }

    public function edit(Criterion $criterion)
    {
        return view('criteria.form', [
            'criterion' => $criterion,
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, Criterion $criterion)
    {
        $criterion->update($this->validateRequest($request, $criterion));

        return redirect()
            ->route('criteria.index')
            ->with('status', 'Kriteria berhasil diperbarui.');
    }

    public function destroy(Criterion $criterion)
    {
        $criterion->delete();

        return redirect()
            ->route('criteria.index')
            ->with('status', 'Kriteria berhasil dihapus.');
    }

    protected function validateRequest(Request $request, ?Criterion $criterion = null)
    {
        return $request->validate([
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('criteria', 'code')->ignore(optional($criterion)->id),
            ],
            'name' => ['required', 'string', 'max:255'],
            'weight' => ['required', 'numeric', 'min:0', 'max:999.9999'],
            'attribute' => ['required', Rule::in(['benefit', 'cost'])],
            'description' => ['nullable', 'string'],
        ]);
    }
}
