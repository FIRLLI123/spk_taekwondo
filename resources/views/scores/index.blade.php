@extends('layouts.app')

@section('title', 'Penilaian Atlet | SPK Atlet ESPA Team')
@section('page_heading', 'Penilaian Atlet')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-header-title mb-1">Penilaian Atlet</h1>
            <p class="page-header-subtitle mb-0">Input nilai per atlet dan kriteria untuk periode yang dipilih.</p>
        </div>
    </div>

    <div class="card shadow mb-4 scores-filter-card">
        <div class="card-body">
            <form method="GET" class="form-row align-items-end">
                <div class="form-group col-md-5">
                    <label>Pilih Periode</label>
                    <select name="period_id" class="form-control scores-period-select" onchange="this.form.submit()">
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
        <div class="alert alert-info">Belum ada periode yang dipilih atau tersedia.</div>
    @elseif($criteria->isEmpty() || $athletes->isEmpty())
        <div class="alert alert-warning">Data atlet aktif atau kriteria belum tersedia, jadi penilaian belum bisa diinput.</div>
    @else
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="card shadow h-100 scores-summary-card scores-summary-card-primary">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Ringkasan Periode</h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-2"><strong>Periode:</strong> <span class="scores-inline-value">{{ $selectedPeriod->name }}</span></p>
                        <p class="mb-2"><strong>Rentang:</strong> <span class="scores-inline-value">{{ $selectedPeriod->date_range }}</span></p>
                        <p class="mb-2"><strong>Total Atlet Aktif:</strong> <span class="scores-inline-badge">{{ $athletes->count() }}</span></p>
                        <p class="mb-2"><strong>Total Kriteria:</strong> <span class="scores-inline-badge">{{ $criteria->count() }}</span></p>
                        <p class="mb-0"><strong>Status:</strong> <span class="scores-status-badge">{{ ucfirst($selectedPeriod->status) }}</span></p>
                    </div>
                </div>
            </div>

            <div class="col-lg-8 mb-4">
                <div class="card shadow h-100 scores-summary-card scores-summary-card-accent">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Progress Penilaian</h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-2"><strong>Sel pribadi:</strong> <span class="scores-inline-badge scores-inline-badge-success">{{ $progress['user_cells'] }} / {{ $progress['expected_cells'] }}</span></p>
                        <p class="mb-2"><strong>Sel terisi semua penilai:</strong> <span class="scores-inline-badge scores-inline-badge-info">{{ $progress['all_cells'] }} / {{ $progress['expected_cells'] }}</span></p>
                        <p class="mb-0 text-muted">Input akan menggantikan seluruh penilaian Anda pada periode ini agar data tetap konsisten.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4 score-matrix-card">
            <div class="card-header py-3 score-matrix-header">
                <h6 class="m-0 font-weight-bold text-primary">Matriks Penilaian</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('scores.store') }}">
                    @csrf
                    <input type="hidden" name="period_id" value="{{ $selectedPeriod->id }}">

                    <div class="table-responsive score-matrix-table-wrap">
                        <table class="table table-bordered table-hover align-middle table-sm mb-0 score-matrix-table">
                            <thead class="thead-light">
                                <tr>
                                    <th class="score-athlete-heading" style="min-width: 220px;">Atlet</th>
                                    @foreach($criteria as $criterion)
                                        <th class="score-criterion-head score-criterion-{{ $criterion->attribute }}" style="min-width: 160px;">
                                            <div class="score-criterion-code">{{ $criterion->code }}</div>
                                            <small class="score-criterion-meta">{{ $criterion->name }} | {{ ucfirst($criterion->attribute) }} | Bobot {{ $criterion->formatted_weight }}</small>
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($athletes as $athlete)
                                    <tr>
                                        <td class="score-athlete-cell">
                                            <strong class="score-athlete-name">{{ $athlete->display_name }}</strong><br>
                                            <small class="score-athlete-meta">{{ $athlete->belt_level }}{{ $athlete->competition_class ? ' | ' . $athlete->competition_class : '' }}</small>
                                        </td>
                                        @foreach($criteria as $criterion)
                                            @php
                                                $fieldName = 'scores.' . $athlete->id . '.' . $criterion->id;
                                                $fieldKey = $athlete->id . '-' . $criterion->id;
                                            @endphp
                                            <td class="score-input-cell">
                                                <input
                                                    type="number"
                                                    step="0.01"
                                                    min="0"
                                                    max="100"
                                                    name="scores[{{ $athlete->id }}][{{ $criterion->id }}]"
                                                    class="form-control form-control-sm score-input"
                                                    value="{{ old($fieldName, $scoreValues->get($fieldKey)) }}"
                                                    placeholder="0-100"
                                                >
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Simpan Penilaian</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
@endsection
