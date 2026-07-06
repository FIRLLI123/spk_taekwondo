@extends('layouts.app')

@section('title', 'Manajemen User | SPK Atlet ESPA Team')
@section('page_heading', 'Manajemen User')

@section('content')
    <div class="app-toolbar page-header">
        <div>
            <h1 class="page-header-title mb-1">Manajemen User</h1>
            <p class="page-header-subtitle mb-0">Kelola akun admin dan pelatih yang dapat mengakses sistem.</p>
        </div>
        <a href="{{ route('users.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50 mr-1"></i> Tambah User
        </a>
    </div>

    <div class="card shadow mb-4 app-table-card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Dibuat</th>
                            <th width="160">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td><span class="badge badge-{{ $user->role === 'admin' ? 'primary' : 'info' }}">{{ ucfirst($user->role) }}</span></td>
                                <td>{{ optional($user->created_at)->format('d M Y H:i') }}</td>
                                <td>
                                    <div class="table-action-group">
                                        <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning table-action-btn" title="Edit user" aria-label="Edit user">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus user ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger table-action-btn" title="Hapus user" aria-label="Hapus user">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada data user.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $users->links() }}
        </div>
    </div>
@endsection
