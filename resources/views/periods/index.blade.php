@extends('layouts.app')

@section('title', 'Periode Penilaian | SPK Atlet ESPA Team')
@section('page_heading', 'Periode Penilaian')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Periode Penilaian</h1>
            <p class="mb-0 text-gray-600">Kelola periode aktif untuk proses penilaian dan ranking atlet.</p>
        </div>
        <a href="{{ route('periods.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50 mr-1"></i> Tambah Periode
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
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
                                    <a href="{{ route('periods.edit', $period) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('periods.destroy', $period) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus periode ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
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
