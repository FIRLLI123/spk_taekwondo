@extends('layouts.app')

@section('title', 'Data Atlet | SPK Atlet ESPA Team')
@section('page_heading', 'Data Atlet')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Data Atlet</h1>
            <p class="mb-0 text-gray-600">Kelola data atlet yang menjadi alternatif dalam proses TOPSIS.</p>
        </div>
        @if(auth()->user()->isAdmin())
            <a href="{{ route('athletes.create') }}" class="btn btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50 mr-1"></i> Tambah Atlet
            </a>
        @endif
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="GET" class="form-inline mb-3">
                <input type="text" name="search" class="form-control mr-2 mb-2" placeholder="Cari nama, kode, sabuk, kelas..." value="{{ $search }}">
                <button type="submit" class="btn btn-outline-primary mb-2 mr-2">Cari</button>
                <a href="{{ route('athletes.index') }}" class="btn btn-outline-secondary mb-2">Reset</a>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Gender</th>
                            <th>Umur</th>
                            <th>Sabuk</th>
                            <th>Kelas</th>
                            <th>Status</th>
                            @if(auth()->user()->isAdmin())
                                <th width="160">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($athletes as $athlete)
                            <tr>
                                <td>{{ $athlete->code }}</td>
                                <td>{{ $athlete->name }}</td>
                                <td>{{ ucfirst($athlete->gender) }}</td>
                                <td>{{ $athlete->age ?: '-' }}</td>
                                <td>{{ $athlete->belt_level }}</td>
                                <td>{{ $athlete->competition_class ?: '-' }}</td>
                                <td><span class="badge badge-{{ $athlete->status === 'aktif' ? 'success' : 'secondary' }}">{{ ucfirst($athlete->status) }}</span></td>
                                @if(auth()->user()->isAdmin())
                                    <td>
                                        <a href="{{ route('athletes.edit', $athlete) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('athletes.destroy', $athlete) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data atlet ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ auth()->user()->isAdmin() ? 8 : 7 }}" class="text-center text-muted">Belum ada data atlet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $athletes->links() }}
        </div>
    </div>
@endsection
