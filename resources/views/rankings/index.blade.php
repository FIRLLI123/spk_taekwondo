@extends('layouts.app')

@section('title', 'Hasil Ranking | SPK Atlet ESPA Team')
@section('page_heading', 'Hasil Ranking')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-header-title mb-1">Hasil Ranking</h1>
            <p class="page-header-subtitle mb-0">Lihat hasil preferensi dan detail perhitungan TOPSIS per periode.</p>
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
        <div class="alert alert-info">Pilih periode untuk melihat ranking.</div>
    @elseif($results->isEmpty())
        <div class="alert alert-warning">Belum ada hasil TOPSIS pada periode ini. Jalankan proses TOPSIS terlebih dahulu.</div>
    @else
        <div class="row">
            <div class="col-lg-7 mb-4">
                <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Ranking</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Ranking</th>
                                        <th>Atlet</th>
                                        <th>Nilai Preferensi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($results as $result)
                                        <tr class="{{ optional($detailResult)->id === $result->id ? 'table-primary' : '' }}">
                                            <td>#{{ $result->rank }}</td>
                                            <td>{{ optional($result->athlete)->display_name ?: '-' }}</td>
                                            <td>{{ number_format($result->preference_value, 6) }}</td>
                                            <td>
                                                <a href="{{ route('rankings.index', ['period_id' => $selectedPeriod->id, 'result_id' => $result->id]) }}" class="btn btn-sm btn-outline-primary">
                                                    Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5 mb-4">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Atlet Terpilih</h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-2"><strong>Atlet:</strong> {{ optional(optional($detailResult)->athlete)->display_name ?: '-' }}</p>
                        <p class="mb-2"><strong>Ranking:</strong> #{{ optional($detailResult)->rank }}</p>
                        <p class="mb-2"><strong>Nilai Preferensi:</strong> {{ number_format(optional($detailResult)->preference_value ?: 0, 6) }}</p>
                        <p class="mb-2"><strong>Jarak Positif:</strong> {{ number_format(optional($detailResult)->positive_distance ?: 0, 6) }}</p>
                        <p class="mb-0"><strong>Jarak Negatif:</strong> {{ number_format(optional($detailResult)->negative_distance ?: 0, 6) }}</p>
                    </div>
                </div>
            </div>
        </div>

        @php
            $detail = optional($detailResult)->calculation_detail ?: [];
            $criteria = collect($detail['criteria'] ?? []);
        @endphp

        @if($detailResult && $criteria->isNotEmpty())
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Detail Perhitungan</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered table-hover align-middle table-sm mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Kriteria</th>
                                    <th>Nilai Awal</th>
                                    <th>Normalisasi</th>
                                    <th>Terbobot</th>
                                    <th>Ideal Positif</th>
                                    <th>Ideal Negatif</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($criteria as $criterion)
                                    @php
                                        $criterionId = $criterion['id'];
                                    @endphp
                                    <tr>
                                        <td>{{ $criterion['code'] }} - {{ $criterion['name'] }}</td>
                                        <td>{{ number_format($detail['decision_matrix'][$criterionId] ?? 0, 6) }}</td>
                                        <td>{{ number_format($detail['normalized_matrix'][$criterionId] ?? 0, 6) }}</td>
                                        <td>{{ number_format($detail['weighted_matrix'][$criterionId] ?? 0, 6) }}</td>
                                        <td>{{ number_format($detail['positive_ideal'][$criterionId] ?? 0, 6) }}</td>
                                        <td>{{ number_format($detail['negative_ideal'][$criterionId] ?? 0, 6) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    @endif
@endsection
