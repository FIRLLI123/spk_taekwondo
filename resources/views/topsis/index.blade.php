@extends('layouts.app')

@section('title', 'Proses TOPSIS | SPK Atlet ESPA Team')
@section('page_heading', 'Proses TOPSIS')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-header-title mb-1">Proses TOPSIS</h1>
            <p class="page-header-subtitle mb-0">Jalankan perhitungan ranking berdasarkan nilai yang sudah diinput pelatih.</p>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="GET" class="form-row align-items-end">
                <div class="form-group col-md-5">
                    <label>Pilih Periode</label>
                    <select name="period_id" class="form-control" onchange="this.form.submit()">
                        <option value="">Pilih periode</option>
                        @foreach($periods as $period)
                            <option value="{{ $period->id }}" {{ optional($selectedPeriod)->id === $period->id ? 'selected' : '' }}>
                                {{ $period->name }} ({{ $period->date_range }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
    </div>

    @if(! $selectedPeriod)
        <div class="alert alert-info">Pilih periode untuk melihat kesiapan data TOPSIS.</div>
    @else
        <div class="row">
            <div class="col-lg-8 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Kesiapan Data</h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-2"><strong>Periode:</strong> {{ $selectedPeriod->name }}</p>
                        <p class="mb-2"><strong>Atlet aktif:</strong> {{ $summary['athlete_count'] }}</p>
                        <p class="mb-2"><strong>Kriteria:</strong> {{ $summary['criterion_count'] }}</p>
                        <p class="mb-2"><strong>Sel wajib:</strong> {{ $summary['expected_cells'] }}</p>
                        <p class="mb-2"><strong>Sel terisi:</strong> {{ $summary['filled_cells'] }}</p>
                        <p class="mb-2"><strong>Total entri nilai:</strong> {{ $summary['score_entries'] }}</p>
                        <p class="mb-0"><strong>Jumlah penilai:</strong> {{ $summary['coach_count'] }}</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Eksekusi</h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-2"><strong>Status Periode:</strong> {{ ucfirst($selectedPeriod->status) }}</p>
                        <p class="mb-3"><strong>Proses terakhir:</strong> {{ optional(optional($summary['last_run'])->updated_at)->format('d M Y H:i') ?: 'Belum pernah' }}</p>
                        <form method="POST" action="{{ route('topsis.run') }}">
                            @csrf
                            <input type="hidden" name="period_id" value="{{ $selectedPeriod->id }}">
                            <button type="submit" class="btn btn-primary btn-block">Jalankan TOPSIS</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
