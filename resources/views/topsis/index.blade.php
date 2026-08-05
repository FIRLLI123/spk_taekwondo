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

    <div class="card shadow mb-4 topsis-filter-card">
        <div class="card-body">
            <form method="GET" class="form-row align-items-end">
                <div class="form-group col-md-5">
                    <label>Pilih Periode</label>
                    <select name="period_id" class="form-control topsis-period-select" onchange="this.form.submit()">
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
                <div class="card shadow h-100 topsis-data-card">
                    <div class="card-header py-3 topsis-data-card-header">
                        <h6 class="m-0 font-weight-bold text-primary">Kesiapan Data</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="topsis-metric-box">
                                    <span class="topsis-metric-label">Periode</span>
                                    <span class="topsis-metric-value topsis-metric-value-text">{{ $selectedPeriod->name }}</span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="topsis-metric-box">
                                    <span class="topsis-metric-label">Atlet Aktif</span>
                                    <span class="topsis-metric-value">{{ $summary['athlete_count'] }}</span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="topsis-metric-box">
                                    <span class="topsis-metric-label">Kriteria</span>
                                    <span class="topsis-metric-value">{{ $summary['criterion_count'] }}</span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="topsis-metric-box">
                                    <span class="topsis-metric-label">Sel Wajib</span>
                                    <span class="topsis-metric-value">{{ $summary['expected_cells'] }}</span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3 mb-md-0">
                                <div class="topsis-metric-box topsis-metric-box-success">
                                    <span class="topsis-metric-label">Sel Terisi</span>
                                    <span class="topsis-metric-value">{{ $summary['filled_cells'] }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="topsis-metric-box topsis-metric-box-accent">
                                    <span class="topsis-metric-label">Jumlah Penilai</span>
                                    <span class="topsis-metric-value">{{ $summary['coach_count'] }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="topsis-total-entry mt-3">
                            <span class="topsis-metric-label d-block mb-1">Total Entri Nilai</span>
                            <strong>{{ $summary['score_entries'] }}</strong>
                            <small>nilai tersimpan siap diproses ke ranking akhir</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <div class="card shadow h-100 topsis-run-card">
                    <div class="card-header py-3 topsis-run-card-header">
                        <h6 class="m-0 font-weight-bold text-primary">Eksekusi</h6>
                    </div>
                    <div class="card-body">
                        <div class="topsis-run-status mb-3">
                            <p class="mb-2"><strong>Status Periode:</strong> <span class="topsis-run-badge">{{ ucfirst($selectedPeriod->status) }}</span></p>
                            <p class="mb-0"><strong>Proses terakhir:</strong> {{ optional(optional($summary['last_run'])->updated_at)->format('d M Y H:i') ?: 'Belum pernah' }}</p>
                        </div>
                        <div class="topsis-run-steps mb-3">
                            <div class="topsis-run-step"><span>1</span> Normalisasi matriks penilaian</div>
                            <div class="topsis-run-step"><span>2</span> Pembobotan setiap kriteria</div>
                            <div class="topsis-run-step"><span>3</span> Hitung solusi ideal dan ranking</div>
                        </div>
                        <form method="POST" action="{{ route('topsis.run') }}" class="topsis-run-form">
                            @csrf
                            <input type="hidden" name="period_id" value="{{ $selectedPeriod->id }}">
                            <button type="submit" class="btn btn-primary btn-block topsis-run-button">
                                <span class="topsis-run-button-label"><i class="fas fa-play-circle mr-2"></i>Jalankan TOPSIS</span>
                                <span class="topsis-run-button-loading d-none"><i class="fas fa-spinner fa-spin mr-2"></i>Memproses...</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="topsis-processing-overlay" id="topsisProcessingOverlay" aria-hidden="true">
        <div class="topsis-processing-dialog">
            <div class="topsis-orbit">
                <div class="topsis-orbit-core">T</div>
                <span class="topsis-orbit-dot dot-1"></span>
                <span class="topsis-orbit-dot dot-2"></span>
                <span class="topsis-orbit-dot dot-3"></span>
                <span class="topsis-orbit-ring ring-1"></span>
                <span class="topsis-orbit-ring ring-2"></span>
            </div>
            <div class="topsis-processing-copy">
                <h5 class="mb-2">Memproses Perhitungan TOPSIS</h5>
                <p class="mb-3">Sistem sedang menghitung normalisasi, pembobotan, solusi ideal, dan nilai preferensi atlet.</p>
                <div class="topsis-processing-steps">
                    <div class="topsis-processing-step is-active">Menyusun matriks keputusan</div>
                    <div class="topsis-processing-step">Menghitung bobot ternormalisasi</div>
                    <div class="topsis-processing-step">Menentukan solusi ideal positif dan negatif</div>
                    <div class="topsis-processing-step">Menyusun ranking akhir atlet</div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('.topsis-run-form');
        const overlay = document.getElementById('topsisProcessingOverlay');
        const submitDelay = 1800;

        if (!form || !overlay) {
            return;
        }

        const button = form.querySelector('.topsis-run-button');
        const defaultLabel = button.querySelector('.topsis-run-button-label');
        const loadingLabel = button.querySelector('.topsis-run-button-loading');
        const steps = Array.from(overlay.querySelectorAll('.topsis-processing-step'));
        let stepTimer = null;
        let hasSubmitted = false;

        form.addEventListener('submit', function (event) {
            if (hasSubmitted) {
                return;
            }

            event.preventDefault();
            overlay.classList.add('is-visible');
            overlay.setAttribute('aria-hidden', 'false');
            document.body.classList.add('topsis-processing-active');

            if (button) {
                button.disabled = true;
                button.classList.add('is-loading');
            }

            if (defaultLabel) {
                defaultLabel.classList.add('d-none');
            }

            if (loadingLabel) {
                loadingLabel.classList.remove('d-none');
            }

            steps.forEach(function (step, index) {
                step.classList.toggle('is-active', index === 0);
            });

            let activeIndex = 0;
            stepTimer = window.setInterval(function () {
                steps[activeIndex].classList.remove('is-active');
                activeIndex = (activeIndex + 1) % steps.length;
                steps[activeIndex].classList.add('is-active');
            }, 850);

            window.setTimeout(function () {
                hasSubmitted = true;
                form.submit();
            }, submitDelay);
        });

        window.addEventListener('pageshow', function () {
            if (stepTimer) {
                window.clearInterval(stepTimer);
            }

            overlay.classList.remove('is-visible');
            overlay.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('topsis-processing-active');

            if (button) {
                button.disabled = false;
                button.classList.remove('is-loading');
            }

            if (defaultLabel) {
                defaultLabel.classList.remove('d-none');
            }

            if (loadingLabel) {
                loadingLabel.classList.add('d-none');
            }
        });
    });
</script>
@endpush
