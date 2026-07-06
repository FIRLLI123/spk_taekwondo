<?php

namespace App\Http\Controllers;

use App\Models\Athlete;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AthleteController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->get('search'));

        $athletes = Athlete::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('belt_level', 'like', "%{$search}%")
                    ->orWhere('competition_class', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('athletes.index', compact('athletes', 'search'));
    }

    public function create()
    {
        return view('athletes.form', [
            'athlete' => new Athlete(),
            'isEdit' => false,
        ]);
    }

    public function store(Request $request)
    {
        Athlete::create($this->validateRequest($request));

        return redirect()
            ->route('athletes.index')
            ->with('status', 'Data atlet berhasil ditambahkan.');
    }

    public function edit(Athlete $athlete)
    {
        return view('athletes.form', [
            'athlete' => $athlete,
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, Athlete $athlete)
    {
        $athlete->update($this->validateRequest($request, $athlete));

        return redirect()
            ->route('athletes.index')
            ->with('status', 'Data atlet berhasil diperbarui.');
    }

    public function destroy(Athlete $athlete)
    {
        $athlete->delete();

        return redirect()
            ->route('athletes.index')
            ->with('status', 'Data atlet berhasil dihapus.');
    }

    protected function validateRequest(Request $request, ?Athlete $athlete = null)
    {
        return $request->validate([
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('athletes', 'code')->ignore(optional($athlete)->id),
            ],
            'name' => ['required', 'string', 'max:255'],
            'gender' => ['required', Rule::in(['laki-laki', 'perempuan'])],
            'birth_date' => ['nullable', 'date'],
            'age' => ['nullable', 'integer', 'min:1', 'max:99'],
            'belt_level' => ['required', 'string', 'max:100'],
            'competition_class' => ['nullable', 'string', 'max:100'],
            'status' => ['required', Rule::in(['aktif', 'nonaktif'])],
        ]);
    }
}
