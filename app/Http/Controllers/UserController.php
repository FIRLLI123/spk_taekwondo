<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        return view('users.index', [
            'users' => User::orderBy('name')->paginate(10),
        ]);
    }

    public function create()
    {
        return view('users.form', [
            'user' => new User(),
            'isEdit' => false,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);
        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()
            ->route('users.index')
            ->with('status', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('users.form', [
            'user' => $user,
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, User $user)
    {
        $validated = $this->validateRequest($request, $user);

        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        return redirect()
            ->route('users.index')
            ->with('status', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return redirect()
                ->route('users.index')
                ->with('status', 'Akun yang sedang dipakai login tidak bisa dihapus.');
        }

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('status', 'User berhasil dihapus.');
    }

    protected function validateRequest(Request $request, ?User $user = null)
    {
        $passwordRules = $user
            ? ['nullable', 'string', 'min:6']
            : ['required', 'string', 'min:6'];

        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore(optional($user)->id),
            ],
            'role' => ['required', Rule::in(['admin', 'pelatih'])],
            'password' => $passwordRules,
        ]);
    }
}
