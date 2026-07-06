@extends('layouts.app')

@section('title', ($isEdit ? 'Edit' : 'Tambah') . ' Kriteria | SPK Atlet ESPA Team')
@section('page_heading', $isEdit ? 'Edit Kriteria' : 'Tambah Kriteria')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ $isEdit ? 'Edit Kriteria' : 'Tambah Kriteria' }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ $isEdit ? route('criteria.update', $criterion) : route('criteria.store') }}" method="POST">
                @csrf
                @if($isEdit)
                    @method('PUT')
                @endif

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Kode</label>
                        <input type="text" name="code" class="form-control" value="{{ old('code', $criterion->code) }}" required>
                    </div>
                    <div class="form-group col-md-5">
                        <label>Nama Kriteria</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $criterion->name) }}" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Bobot</label>
                        <input type="number" step="0.0001" name="weight" class="form-control" value="{{ old('weight', $criterion->weight) }}" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Atribut</label>
                        <select name="attribute" class="form-control" required>
                            <option value="benefit" {{ old('attribute', $criterion->attribute ?: 'benefit') === 'benefit' ? 'selected' : '' }}>Benefit</option>
                            <option value="cost" {{ old('attribute', $criterion->attribute) === 'cost' ? 'selected' : '' }}>Cost</option>
                        </select>
                    </div>
                    <div class="form-group col-md-8">
                        <label>Deskripsi</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description', $criterion->description) }}</textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('criteria.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
