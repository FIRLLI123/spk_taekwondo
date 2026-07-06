@extends('layouts.app')

@section('title', 'Penilaian Atlet | SPK Atlet ESPA Team')
@section('page_heading', 'Penilaian Atlet')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Penilaian Atlet</h1>
            <p class="mb-0 text-gray-600">Input nilai per atlet dan kriteria untuk periode yang dipilih.</p>
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
        <div class="alert alert-info">Belum ada periode yang dipilih atau tersedia.</div>
    @elseif($criteria->isEmpty() || $athletes->isEmpty())
        <div class="alert alert-warning">Data atlet aktif atau kriteria belum tersedia, jadi penilaian belum bisa diinput.</div>
    @else
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Ringkasan Periode</h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-2"><strong>Periode:</strong> {{ $selectedPeriod->name }}</p>
                        <p class="mb-2"><strong>Rentang:</strong> {{ $selectedPeriod->date_range }}</p>
                        <p class="mb-2"><strong>Total Atlet Aktif:</strong> {{ $athletes->count() }}</p>
                        <p class="mb-2"><strong>Total Kriteria:</strong> {{ $criteria->count() }}</p>
                        <p class="mb-0"><strong>Status:</strong> {{ ucfirst($selectedPeriod->status) }}</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-8 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Progress Penilaian</h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-2"><strong>Sel pribadi:</strong> {{ $progress['user_cells'] }} / {{ $progress['expected_cells'] }}</p>
                        <p class="mb-2"><strong>Sel terisi semua penilai:</strong> {{ $progress['all_cells'] }} / {{ $progress['expected_cells'] }}</p>
                        <p class="mb-0 text-muted">Input akan menggantikan seluruh penilaian Anda pada periode ini agar data tetap konsisten.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Matriks Penilaian</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('scores.store') }}">
                    @csrf
                    <input type="hidden" name="period_id" value="{{ $selectedPeriod->id }}">

                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th style="min-width: 220px;">Atlet</th>
                                    @foreach($criteria as $criterion)
                                        <th style="min-width: 160px;">
                                            <div>{{ $criterion->code }}</div>
                                            <small class="text-muted">{{ $criterion->name }} | {{ ucfirst($criterion->attribute) }} | Bobot {{ $criterion->formatted_weight }}</small>
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($athletes as $athlete)
                                    <tr>
                                        <td>
                                            <strong>{{ $athlete->display_name }}</strong><br>
                                            <small class="text-muted">{{ $athlete->belt_level }}{{ $athlete->competition_class ? ' | ' . $athlete->competition_class : '' }}</small>
                                        </td>
                                        @foreach($criteria as $criterion)
                                            @php
                                                $fieldName = 'scores.' . $athlete->id . '.' . $criterion->id;
                                                $fieldKey = $athlete->id . '-' . $criterion->id;
                                            @endphp
                                            <td>
                                                <input
                                                    type="number"
                                                    step="0.01"
                                                    min="0"
                                                    max="100"
                                                    name="scores[{{ $athlete->id }}][{{ $criterion->id }}]"
                                                    class="form-control form-control-sm"
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
