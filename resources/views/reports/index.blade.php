@extends('layouts.app')

@section('title', 'Laporan | SPK Atlet ESPA Team')
@section('page_heading', 'Laporan')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Laporan</h1>
            <p class="mb-0 text-gray-600">Ringkasan penilaian dan hasil ranking per periode.</p>
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
                @if($selectedPeriod)
                    <div class="form-group col-md-7 text-md-right">
                        <a href="{{ route('reports.print', ['period_id' => $selectedPeriod->id]) }}" target="_blank" class="btn btn-outline-secondary mb-2">
                            Preview Print
                        </a>
                        <a href="{{ route('reports.export.pdf', ['period_id' => $selectedPeriod->id]) }}" class="btn btn-danger mb-2">
                            Download PDF
                        </a>
                        <a href="{{ route('reports.export.xlsx', ['period_id' => $selectedPeriod->id]) }}" class="btn btn-success mb-2">
                            Download XLSX
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </div>

    @if(! $selectedPeriod)
        <div class="alert alert-info">Pilih periode untuk melihat laporan.</div>
    @else
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Periode</div>
                        <div class="h6 mb-0 font-weight-bold text-gray-800">{{ $selectedPeriod->name }}</div>
                        <div class="small text-muted mt-1">{{ $selectedPeriod->date_range }}</div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Atlet Dinilai</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $scoreStats['athlete_count'] }}</div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Jumlah Penilai</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $scoreStats['coach_count'] }}</div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Entri Nilai</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $scoreStats['score_entries'] }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Laporan Ranking</h6>
            </div>
            <div class="card-body">
                @if($results->isEmpty())
                    <div class="alert alert-warning mb-0">Belum ada hasil ranking pada periode ini.</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered">
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
                                        <td>#{{ $result->rank }}</td>
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

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Rekap Rata-rata Penilaian</h6>
            </div>
            <div class="card-body">
                @if($scoreMatrix->isEmpty())
                    <div class="alert alert-warning mb-0">Belum ada data penilaian pada periode ini.</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
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
