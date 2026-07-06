@extends('layouts.app')

@section('title', ($isEdit ? 'Edit' : 'Tambah') . ' Periode | SPK Atlet ESPA Team')
@section('page_heading', $isEdit ? 'Edit Periode' : 'Tambah Periode')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ $isEdit ? 'Edit Periode' : 'Tambah Periode' }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ $isEdit ? route('periods.update', $period) : route('periods.store') }}" method="POST">
                @csrf
                @if($isEdit)
                    @method('PUT')
                @endif

                <div class="form-group">
                    <label>Nama Periode</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $period->name) }}" required>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Tanggal Mulai</label>
                        <input type="date" name="start_date" class="form-control" value="{{ old('start_date', optional($period->start_date)->format('Y-m-d')) }}" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Tanggal Selesai</label>
                        <input type="date" name="end_date" class="form-control" value="{{ old('end_date', optional($period->end_date)->format('Y-m-d')) }}" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Status</label>
                        <select name="status" class="form-control" required>
                            <option value="draft" {{ old('status', $period->status ?: 'draft') === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="aktif" {{ old('status', $period->status) === 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="selesai" {{ old('status', $period->status) === 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('periods.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
