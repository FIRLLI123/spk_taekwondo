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

    <div class="card shadow mb-4 ranking-filter-card">
        <div class="card-body">
            <form method="GET" class="form-row align-items-end">
                <div class="form-group col-md-5">
                    <label>Pilih Periode</label>
                    <select name="period_id" class="form-control ranking-period-select" onchange="this.form.submit()">
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
        <div class="card shadow mb-4 ranking-hero-card">
            <div class="card-body">
                <div class="ranking-hero-content">
                    <div>
                        <span class="ranking-hero-badge">Ranking Terbaik</span>
                        <h2 class="ranking-hero-title mb-2">{{ optional($results->first()->athlete)->display_name ?: '-' }}</h2>
                        <p class="ranking-hero-subtitle mb-0">Periode {{ $selectedPeriod->name }} menghasilkan atlet dengan nilai preferensi tertinggi sebagai rekomendasi utama sistem.</p>
                    </div>
                    <div class="ranking-hero-stats">
                        <div class="ranking-hero-stat">
                            <span class="ranking-hero-stat-label">Nilai Preferensi</span>
                            <strong>{{ number_format(optional($results->first())->preference_value ?: 0, 6) }}</strong>
                        </div>
                        <div class="ranking-hero-stat">
                            <span class="ranking-hero-stat-label">Total Atlet</span>
                            <strong>{{ $results->count() }}</strong>
                        </div>
                        <div class="ranking-hero-stat">
                            <span class="ranking-hero-stat-label">Atlet Dipilih</span>
                            <strong>#{{ optional($results->first())->rank }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row align-items-stretch">
            <div class="col-lg-7 mb-4">
                <div class="card shadow h-100 ranking-list-card">
                    <div class="card-header py-3 ranking-list-card-header">
                        <h6 class="m-0 font-weight-bold text-primary">Daftar Ranking</h6>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <div class="table-responsive ranking-table-wrap">
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
                                        <tr class="ranking-row {{ optional($detailResult)->id === $result->id ? 'ranking-row-active' : '' }}">
                                            <td>
                                                <span class="ranking-rank-badge ranking-rank-{{ $result->rank <= 3 ? $result->rank : 'other' }}">#{{ $result->rank }}</span>
                                            </td>
                                            <td>
                                                <div class="ranking-athlete-name">{{ optional($result->athlete)->display_name ?: '-' }}</div>
                                                <div class="ranking-athlete-caption">Kandidat atlet terbaik periode ini</div>
                                            </td>
                                            <td>
                                                <div class="ranking-score-value">{{ number_format($result->preference_value, 6) }}</div>
                                                <div class="progress ranking-score-progress">
                                                    <div class="progress-bar" role="progressbar" style="width: {{ max(6, min(100, ($result->preference_value ?? 0) * 100)) }}%"></div>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="{{ route('rankings.index', ['period_id' => $selectedPeriod->id, 'result_id' => $result->id]) }}" class="btn btn-sm btn-outline-primary ranking-detail-btn">
                                                    <i class="fas fa-arrow-right mr-1"></i>Detail
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
                <div class="card shadow h-100 ranking-detail-card">
                    <div class="card-header py-3 ranking-detail-card-header">
                        <h6 class="m-0 font-weight-bold text-primary">Atlet Terpilih</h6>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <div class="ranking-detail-hero">
                            <div class="ranking-detail-medal"><i class="fas fa-trophy"></i></div>
                            <div>
                                <div class="ranking-detail-name">{{ optional(optional($detailResult)->athlete)->display_name ?: '-' }}</div>
                                <div class="ranking-detail-rank">Ranking #{{ optional($detailResult)->rank }}</div>
                            </div>
                        </div>
                        <div class="ranking-detail-metrics">
                            <div class="ranking-detail-metric">
                                <span class="ranking-detail-label">Nilai Preferensi</span>
                                <strong>{{ number_format(optional($detailResult)->preference_value ?: 0, 6) }}</strong>
                            </div>
                            <div class="ranking-detail-metric">
                                <span class="ranking-detail-label">Jarak Positif</span>
                                <strong>{{ number_format(optional($detailResult)->positive_distance ?: 0, 6) }}</strong>
                            </div>
                            <div class="ranking-detail-metric">
                                <span class="ranking-detail-label">Jarak Negatif</span>
                                <strong>{{ number_format(optional($detailResult)->negative_distance ?: 0, 6) }}</strong>
                            </div>
                        </div>
                        <div class="ranking-detail-note mt-auto">
                            Atlet ini menjadi fokus utama hasil seleksi TOPSIS berdasarkan kedekatan terhadap solusi ideal positif dan jarak dari solusi ideal negatif.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @php
            $detail = optional($detailResult)->calculation_detail ?: [];
            $criteria = collect($detail['criteria'] ?? []);
        @endphp

        @if($detailResult && $criteria->isNotEmpty())
            <div class="card shadow mb-4 ranking-calculation-card">
                <div class="card-header py-3 ranking-calculation-card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Detail Perhitungan</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive mb-4 ranking-calculation-table-wrap">
                        <table class="table table-bordered table-hover align-middle table-sm mb-0 ranking-calculation-table">
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
                                        <td>
                                            <div class="ranking-criterion-name">{{ $criterion['code'] }} - {{ $criterion['name'] }}</div>
                                        </td>
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
