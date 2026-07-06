@extends('layouts.app')

@section('title', 'Data Kriteria | SPK Atlet ESPA Team')
@section('page_heading', 'Data Kriteria')

@section('content')
    <div class="app-toolbar page-header">
        <div>
            <h1 class="page-header-title mb-1">Data Kriteria</h1>
            <p class="page-header-subtitle mb-0">Kelola kriteria penilaian, bobot, dan tipe atribut TOPSIS.</p>
        </div>
        <a href="{{ route('criteria.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50 mr-1"></i> Tambah Kriteria
        </a>
    </div>

    <div class="card shadow mb-4 app-table-card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Kode</th>
                            <th>Nama Kriteria</th>
                            <th>Bobot</th>
                            <th>Atribut</th>
                            <th>Deskripsi</th>
                            <th width="160">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($criteria as $criterion)
                            <tr>
                                <td>{{ $criterion->code }}</td>
                                <td>{{ $criterion->name }}</td>
                                <td>{{ rtrim(rtrim(number_format($criterion->weight, 4, '.', ''), '0'), '.') }}</td>
                                <td><span class="badge badge-{{ $criterion->attribute === 'benefit' ? 'success' : 'danger' }}">{{ ucfirst($criterion->attribute) }}</span></td>
                                <td>{{ $criterion->description ?: '-' }}</td>
                                <td>
                                    <div class="table-action-group">
                                        <a href="{{ route('criteria.edit', $criterion) }}" class="btn btn-sm btn-warning table-action-btn" title="Edit kriteria" aria-label="Edit kriteria">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <form action="{{ route('criteria.destroy', $criterion) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus kriteria ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger table-action-btn" title="Hapus kriteria" aria-label="Hapus kriteria">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada data kriteria.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $criteria->links() }}
        </div>
    </div>
@endsection
