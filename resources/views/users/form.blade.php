@extends('layouts.app')

@section('title', ($isEdit ? 'Edit' : 'Tambah') . ' User | SPK Atlet ESPA Team')
@section('page_heading', $isEdit ? 'Edit User' : 'Tambah User')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ $isEdit ? 'Edit User' : 'Tambah User' }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ $isEdit ? route('users.update', $user) : route('users.store') }}" method="POST">
                @csrf
                @if($isEdit)
                    @method('PUT')
                @endif

                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                </div>

                <div class="form-group">
                    <label>Role</label>
                    <select name="role" class="form-control" required>
                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="pelatih" {{ old('role', $user->role) === 'pelatih' ? 'selected' : '' }}>Pelatih</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>{{ $isEdit ? 'Password Baru' : 'Password' }}</label>
                    <input type="password" name="password" class="form-control" {{ $isEdit ? '' : 'required' }}>
                    @if($isEdit)
                        <small class="form-text text-muted">Kosongkan bila password tidak ingin diubah.</small>
                    @endif
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
