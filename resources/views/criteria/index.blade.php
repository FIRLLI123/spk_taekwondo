@extends('layouts.app')

@section('title', 'Data Kriteria | SPK Atlet ESPA Team')
@section('page_heading', 'Data Kriteria')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Data Kriteria</h1>
            <p class="mb-0 text-gray-600">Kelola kriteria penilaian, bobot, dan tipe atribut TOPSIS.</p>
        </div>
        <a href="{{ route('criteria.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50 mr-1"></i> Tambah Kriteria
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
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
                                    <a href="{{ route('criteria.edit', $criterion) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('criteria.destroy', $criterion) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus kriteria ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
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
