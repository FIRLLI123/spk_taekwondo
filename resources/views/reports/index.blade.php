@extends('layouts.app')

@section('title', 'Laporan | SPK Atlet ESPA Team')
@section('page_heading', 'Laporan')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-header-title mb-1">Laporan</h1>
            <p class="page-header-subtitle mb-0">Ringkasan penilaian dan hasil ranking per periode.</p>
        </div>
    </div>

    <div class="card shadow mb-4 reports-filter-card">
        <div class="card-body">
            <form method="GET" class="form-row align-items-end">
                <div class="form-group col-md-5">
                    <label>Pilih Periode</label>
                    <select name="period_id" class="form-control reports-period-select" onchange="this.form.submit()">
                        <option value="">Pilih periode</option>
                        @foreach($periods as $period)
                            <option value="{{ $period->id }}" {{ optional($selectedPeriod)->id === $period->id ? 'selected' : '' }}>
                                {{ $period->name }} ({{ $period->date_range }})
                            </option>
                        @endforeach
                    </select>
                </div>
                @if($selectedPeriod)
                    <div class="form-group col-md-7">
                        <div class="reports-action-group justify-content-md-end">
                            <a href="{{ route('reports.export.pdf', ['period_id' => $selectedPeriod->id]) }}" target="_blank" class="btn btn-danger mb-2 reports-action-btn reports-action-btn-pdf">
                                <i class="fas fa-file-pdf mr-2"></i>Download PDF
                            </a>
                            <a href="{{ route('reports.export.xlsx', ['period_id' => $selectedPeriod->id]) }}" class="btn btn-success mb-2 reports-action-btn reports-action-btn-excel">
                                <i class="fas fa-file-excel mr-2"></i>Download Excel
                            </a>
                        </div>
                    </div>
                @endif
            </form>
        </div>
    </div>

    @if(! $selectedPeriod)
        <div class="alert alert-info">Pilih periode untuk melihat laporan.</div>
    @else
        <div class="card shadow mb-4 reports-hero-card">
            <div class="card-body">
                <div class="reports-hero-content">
                    <div>
                        <span class="reports-hero-badge">Laporan TOPSIS</span>
                        <h2 class="reports-hero-title mb-2">{{ $selectedPeriod->name }}</h2>
                        <p class="reports-hero-subtitle mb-0">Pantau ringkasan penilaian, hasil ranking akhir, dan rekap nilai setiap atlet dalam satu tampilan yang lebih rapi dan formal.</p>
                    </div>
                    <div class="reports-hero-highlight">
                        <span class="reports-hero-highlight-label">Atlet Ranking #1</span>
                        <strong>{{ optional(optional($results->first())->athlete)->display_name ?: 'Belum ada hasil' }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card shadow h-100 py-2 reports-stat-card reports-stat-card-primary">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-uppercase mb-1 reports-stat-label">Periode</div>
                        <div class="h6 mb-0 font-weight-bold reports-stat-text">{{ $selectedPeriod->name }}</div>
                        <div class="small reports-stat-subtext mt-1">{{ $selectedPeriod->date_range }}</div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card shadow h-100 py-2 reports-stat-card reports-stat-card-success">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-uppercase mb-1 reports-stat-label">Atlet Dinilai</div>
                        <div class="h5 mb-0 font-weight-bold reports-stat-number">{{ $scoreStats['athlete_count'] }}</div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card shadow h-100 py-2 reports-stat-card reports-stat-card-info">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-uppercase mb-1 reports-stat-label">Jumlah Penilai</div>
                        <div class="h5 mb-0 font-weight-bold reports-stat-number">{{ $scoreStats['coach_count'] }}</div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card shadow h-100 py-2 reports-stat-card reports-stat-card-warning">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-uppercase mb-1 reports-stat-label">Entri Nilai</div>
                        <div class="h5 mb-0 font-weight-bold reports-stat-number">{{ $scoreStats['score_entries'] }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4 app-table-card reports-table-card">
            <div class="card-header py-3 reports-table-card-header">
                <h6 class="m-0 font-weight-bold text-primary">Laporan Ranking</h6>
            </div>
            <div class="card-body">
                @if($results->isEmpty())
                    <div class="alert alert-warning mb-0">Belum ada hasil ranking pada periode ini.</div>
                @else
                    <div class="table-responsive reports-table-wrap">
                        <table class="table table-bordered table-hover align-middle mb-0 reports-ranking-table">
                            <thead class="thead-light">
                                <tr>
                                    <th>Ranking</th>
                                    <th>Kode Atlet</th>
                                    <th>Nama Atlet</th>
                                    <th>Nilai Preferensi</th>
                                    <th>Jarak Positif</th>
                                    <th>Jarak Negatif</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($results as $result)
                                    <tr>
                                        <td><span class="reports-rank-badge reports-rank-{{ $result->rank <= 3 ? $result->rank : 'other' }}">#{{ $result->rank }}</span></td>
                                        <td>{{ optional($result->athlete)->code }}</td>
                                        <td>{{ optional($result->athlete)->name }}</td>
                                        <td>{{ number_format($result->preference_value, 6) }}</td>
                                        <td>{{ number_format($result->positive_distance, 6) }}</td>
                                        <td>{{ number_format($result->negative_distance, 6) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        <div class="card shadow mb-4 app-table-card reports-table-card">
            <div class="card-header py-3 reports-table-card-header">
                <h6 class="m-0 font-weight-bold text-primary">Rekap Rata-rata Penilaian</h6>
            </div>
            <div class="card-body">
                @if($scoreMatrix->isEmpty())
                    <div class="alert alert-warning mb-0">Belum ada data penilaian pada periode ini.</div>
                @else
                    <div class="table-responsive reports-table-wrap">
                        <table class="table table-bordered table-hover align-middle table-sm mb-0 reports-score-table">
                            <thead class="thead-light">
                                <tr>
                                    <th>Kode Atlet</th>
                                    <th>Nama Atlet</th>
                                    @foreach($criteria as $criterion)
                                        <th>{{ $criterion->code }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($scoreMatrix as $row)
                                    <tr>
                                        <td>{{ $row['athlete_code'] }}</td>
                                        <td>{{ $row['athlete_name'] }}</td>
                                        @foreach($criteria as $criterion)
                                            <td>{{ number_format($row['scores'][$criterion->id] ?? 0, 4) }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    @endif
@endsection
