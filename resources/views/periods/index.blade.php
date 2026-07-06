@extends('layouts.app')

@section('title', 'Periode Penilaian | SPK Atlet ESPA Team')
@section('page_heading', 'Periode Penilaian')

@section('content')
    <div class="app-toolbar page-header">
        <div>
            <h1 class="page-header-title mb-1">Periode Penilaian</h1>
            <p class="page-header-subtitle mb-0">Kelola periode aktif untuk proses penilaian dan ranking atlet.</p>
        </div>
        <a href="{{ route('periods.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50 mr-1"></i> Tambah Periode
        </a>
    </div>

    <div class="card shadow mb-4 app-table-card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Nama Periode</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Status</th>
                            <th width="160">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($periods as $period)
                            <tr>
                                <td>{{ $period->name }}</td>
                                <td>{{ optional($period->start_date)->format('d M Y') }}</td>
                                <td>{{ optional($period->end_date)->format('d M Y') }}</td>
                                <td>
                                    <span class="badge badge-{{ $period->status === 'aktif' ? 'success' : ($period->status === 'selesai' ? 'secondary' : 'warning') }}">
                                        {{ ucfirst($period->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="table-action-group">
                                        <a href="{{ route('periods.edit', $period) }}" class="btn btn-sm btn-warning table-action-btn" title="Edit periode" aria-label="Edit periode">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <form action="{{ route('periods.destroy', $period) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus periode ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger table-action-btn" title="Hapus periode" aria-label="Hapus periode">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada data periode.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $periods->links() }}
        </div>
    </div>
@endsection
