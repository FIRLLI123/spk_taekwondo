@extends('layouts.app')

@section('title', ($isEdit ? 'Edit' : 'Tambah') . ' Atlet | SPK Atlet ESPA Team')
@section('page_heading', $isEdit ? 'Edit Atlet' : 'Tambah Atlet')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ $isEdit ? 'Edit Atlet' : 'Tambah Atlet' }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ $isEdit ? route('athletes.update', $athlete) : route('athletes.store') }}" method="POST">
                @csrf
                @if($isEdit)
                    @method('PUT')
                @endif

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Kode Atlet</label>
                        <input type="text" name="code" class="form-control" value="{{ old('code', $athlete->code) }}" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Nama Atlet</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $athlete->name) }}" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Jenis Kelamin</label>
                        <select name="gender" class="form-control" required>
                            <option value="laki-laki" {{ old('gender', $athlete->gender) === 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="perempuan" {{ old('gender', $athlete->gender) === 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="birth_date" class="form-control" value="{{ old('birth_date', optional($athlete->birth_date)->format('Y-m-d')) }}">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Umur</label>
                        <input type="number" name="age" class="form-control" value="{{ old('age', $athlete->age) }}" min="1" max="99">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Tingkat Sabuk</label>
                        <input type="text" name="belt_level" class="form-control" value="{{ old('belt_level', $athlete->belt_level) }}" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Kelas Pertandingan</label>
                        <input type="text" name="competition_class" class="form-control" value="{{ old('competition_class', $athlete->competition_class) }}">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Status</label>
                        <select name="status" class="form-control" required>
                            <option value="aktif" {{ old('status', $athlete->status ?: 'aktif') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ old('status', $athlete->status) === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('athletes.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
