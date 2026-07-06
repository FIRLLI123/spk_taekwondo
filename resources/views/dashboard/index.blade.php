@extends('layouts.app')

@section('title', 'Dashboard | SPK Atlet ESPA Team')
@section('page_heading', 'Dashboard')

@section('content')
    <div class="page-header">
        <div class="app-hero card mb-4 dashboard-reveal reveal-hero">
            <div class="card-body d-lg-flex align-items-center justify-content-between">
                <div class="pr-lg-4">
                    <div class="app-hero-badge mb-3">Dashboard Utama</div>
                    <h1 class="app-hero-title">SPK Pemilihan Atlet Terbaik</h1>
                    <p class="app-hero-subtitle">Pantau data master, progres penilaian, dan hasil TOPSIS dalam tampilan yang lebih ringkas, informatif, dan hidup.</p>
                    @if($bestAthlete && $bestAthlete->athlete)
                        <div class="app-hero-winner mt-4">
                            <div class="app-hero-winner-label">Atlet Terbaik Periode Terakhir</div>
                            <div class="app-hero-winner-name">{{ $bestAthlete->athlete->name }}</div>
                            <div class="app-hero-winner-meta">
                                <span>Nilai {{ number_format($bestAthlete->preference_value, 4) }}</span>
                                <span class="app-hero-divider">|</span>
                                <span>{{ optional($latestPeriod)->name }}</span>
                                <span class="app-hero-divider">|</span>
                                <span>Ranking #{{ $bestAthlete->rank }}</span>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="mt-3 mt-lg-0 text-lg-right">
                    <div class="badge badge-light px-3 py-2 text-primary">Periode Aktif: {{ optional($latestPeriod)->name ?: 'Belum tersedia' }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card app-stat-card app-stat-gradient primary h-100 py-2 dashboard-reveal reveal-stat delay-1">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1 text-white-50">Total Atlet</div>
                            <div class="h5 mb-0 font-weight-bold text-white js-counter" data-target="{{ $stats['athletes'] }}">0</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-running fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card app-stat-card app-stat-gradient success h-100 py-2 dashboard-reveal reveal-stat delay-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1 text-white-50">Total Kriteria</div>
                            <div class="h5 mb-0 font-weight-bold text-white js-counter" data-target="{{ $stats['criteria'] }}">0</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-balance-scale fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card app-stat-card app-stat-gradient info h-100 py-2 dashboard-reveal reveal-stat delay-3">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1 text-white-50">Total Penilaian</div>
                            <div class="h5 mb-0 font-weight-bold text-white js-counter" data-target="{{ $stats['scores'] }}">0</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-edit fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card app-stat-card app-stat-gradient warning h-100 py-2 dashboard-reveal reveal-stat delay-4">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1 text-white-50">Total User</div>
                            <div class="h5 mb-0 font-weight-bold text-white js-counter" data-target="{{ $stats['users'] }}">0</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8 mb-4">
            <div class="card shadow h-100 dashboard-chart-card dashboard-reveal reveal-card delay-5">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Grafik Performa Ranking TOPSIS</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area compact-chart">
                        <canvas id="rankingBarChart"></canvas>
                    </div>
                    <div class="dashboard-chart-caption mt-3">
                        Perbandingan nilai preferensi TOPSIS untuk atlet dengan ranking tertinggi pada periode terakhir.
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 mb-4">
            <div class="card shadow h-100 dashboard-chart-card dashboard-reveal reveal-card delay-6">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Komposisi Bobot Kriteria</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie compact-chart compact-chart-pie">
                        <canvas id="criteriaPieChart"></canvas>
                    </div>
                    <div class="dashboard-chart-caption mt-3">
                        Distribusi bobot penilaian yang dipakai dalam perhitungan TOPSIS.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-5 mb-4">
            <div class="card shadow h-100 dashboard-ranking-card dashboard-reveal reveal-card delay-7">
                <div class="card-header py-3 d-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Ranking Teratas</h6>
                    <span class="badge badge-light text-primary px-3 py-2">{{ optional($latestPeriod)->name ?: 'Belum ada periode' }}</span>
                </div>
                <div class="card-body">
                    @if($topRankings->isEmpty())
                        <div class="alert alert-info mb-0">Belum ada hasil ranking untuk ditampilkan di dashboard.</div>
                    @else
                        @foreach($topRankings as $result)
                            <div class="dashboard-rank-item dashboard-reveal reveal-rank" style="animation-delay: {{ 0.55 + ($loop->iteration * 0.08) }}s;">
                                <div class="dashboard-rank-topline">
                                    <div class="dashboard-rank-left">
                                        <span class="dashboard-rank-badge">#{{ $result->rank }}</span>
                                        <div>
                                            <div class="dashboard-rank-name">{{ optional($result->athlete)->name }}</div>
                                            <div class="dashboard-rank-subtitle">{{ optional($result->athlete)->code }} • Nilai {{ number_format($result->preference_value, 4) }}</div>
                                        </div>
                                    </div>
                                    <div class="dashboard-rank-score">{{ round($result->preference_value * 100, 2) }}%</div>
                                </div>
                                <div class="progress dashboard-rank-progress">
                                    <div class="progress-bar" role="progressbar" style="width: {{ min(100, round($result->preference_value * 100, 2)) }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <div class="col-xl-7 mb-4">
            <div class="card shadow h-100 dashboard-chart-card dashboard-reveal reveal-card delay-8">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Rata-rata Nilai per Kriteria</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area compact-chart">
                        <canvas id="criteriaAverageChart"></canvas>
                    </div>
                    <div class="dashboard-chart-caption mt-3">
                        Gambaran rata-rata penilaian tiap kriteria pada periode terakhir untuk membantu membaca kekuatan umum atlet.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('sbadmin2/vendor/chart.js/Chart.min.js') }}"></script>
    <script>
        (function () {
            Chart.plugins.register({
                afterDatasetsDraw: function(chart) {
                    if (chart.config.type !== 'bar' || chart.canvas.id !== 'rankingBarChart') {
                        return;
                    }

                    const ctx = chart.ctx;
                    const dataset = chart.data.datasets[0];
                    const meta = chart.getDatasetMeta(0);

                    meta.data.forEach(function(bar, index) {
                        const value = dataset.data[index];
                        const model = bar._model || {};
                        if (typeof model.x === 'undefined' || typeof model.y === 'undefined') {
                            return;
                        }

                        ctx.save();
                        ctx.font = '700 11px Nunito';
                        ctx.fillStyle = '#1e3a8a';
                        ctx.textAlign = 'center';
                        ctx.fillText(Number(value).toFixed(4), model.x, model.y - 10);
                        ctx.restore();
                    });
                }
            });

            const counters = document.querySelectorAll('.js-counter');
            counters.forEach((counter) => {
                const target = Number(counter.dataset.target || 0);
                const duration = 700;
                const startTime = performance.now();

                const tick = (now) => {
                    const progress = Math.min((now - startTime) / duration, 1);
                    const eased = 1 - Math.pow(1 - progress, 3);
                    counter.textContent = Math.round(target * eased).toLocaleString('id-ID');

                    if (progress < 1) {
                        requestAnimationFrame(tick);
                    }
                };

                requestAnimationFrame(tick);
            });

            const chartData = @json($chartData);
            const sharedGridColor = 'rgba(148, 163, 184, 0.16)';
            const sharedTickColor = '#64748b';
            const sharedTooltip = {
                enabled: true,
                backgroundColor: 'rgba(15, 23, 42, 0.96)',
                titleFontColor: '#ffffff',
                bodyFontColor: '#e2e8f0',
                borderColor: 'rgba(96, 165, 250, 0.45)',
                borderWidth: 1,
                cornerRadius: 12,
                xPadding: 14,
                yPadding: 12,
                displayColors: false,
                titleFontFamily: 'Nunito',
                bodyFontFamily: 'Nunito',
                titleFontStyle: '800',
                bodyFontStyle: '700'
            };

            if (document.getElementById('rankingBarChart')) {
                new Chart(document.getElementById('rankingBarChart'), {
                    type: 'bar',
                    data: {
                        labels: chartData.ranking_labels,
                        datasets: [{
                            label: 'Nilai Preferensi',
                            data: chartData.ranking_values,
                            backgroundColor: ['#2563eb', '#3b82f6', '#0ea5e9', '#22c55e', '#f59e0b'],
                            borderRadius: 10,
                            maxBarThickness: 40
                        }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        legend: { display: false },
                        tooltips: Object.assign({}, sharedTooltip, {
                            callbacks: {
                                title: function(items, data) {
                                    return data.labels[items[0].index];
                                },
                                label: function(item) {
                                    return 'Nilai preferensi: ' + Number(item.yLabel).toFixed(4);
                                }
                            }
                        }),
                        scales: {
                            xAxes: [{
                                gridLines: { display: false, drawBorder: false },
                                ticks: { fontColor: sharedTickColor, fontSize: 11, fontStyle: '700' }
                            }],
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    max: 1,
                                    fontColor: sharedTickColor,
                                    callback: function(value) { return Number(value).toFixed(1); }
                                },
                                gridLines: { color: sharedGridColor, drawBorder: false }
                            }]
                        }
                    }
                });
            }

            if (document.getElementById('criteriaPieChart')) {
                new Chart(document.getElementById('criteriaPieChart'), {
                    type: 'doughnut',
                    data: {
                        labels: chartData.criteria_labels,
                        datasets: [{
                            data: chartData.criteria_weights,
                            backgroundColor: ['#2563eb', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#06b6d4'],
                            borderColor: '#ffffff',
                            borderWidth: 4
                        }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        cutoutPercentage: 58,
                        legend: {
                            position: 'bottom',
                            labels: {
                                fontColor: sharedTickColor,
                                boxWidth: 12,
                                padding: 14,
                                fontSize: 11
                            }
                        },
                        tooltips: Object.assign({}, sharedTooltip, {
                            callbacks: {
                                label: function(item, data) {
                                    const dataset = data.datasets[item.datasetIndex];
                                    const total = dataset.data.reduce(function(sum, value) {
                                        return sum + value;
                                    }, 0);
                                    const value = dataset.data[item.index];
                                    const percent = total ? ((value / total) * 100).toFixed(1) : '0.0';
                                    return data.labels[item.index] + ': ' + value + ' (' + percent + '%)';
                                }
                            }
                        })
                    }
                });
            }

            if (document.getElementById('criteriaAverageChart')) {
                new Chart(document.getElementById('criteriaAverageChart'), {
                    type: 'line',
                    data: {
                        labels: chartData.criteria_labels,
                        datasets: [{
                            label: 'Rata-rata Nilai',
                            data: chartData.criteria_averages,
                            borderColor: '#1d4ed8',
                            backgroundColor: 'rgba(37, 99, 235, 0.14)',
                            fill: true,
                            lineTension: 0.35,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            pointBackgroundColor: '#ffffff',
                            pointBorderColor: '#1d4ed8',
                            pointBorderWidth: 2
                        }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        legend: { display: false },
                        tooltips: Object.assign({}, sharedTooltip, {
                            callbacks: {
                                label: function(item) {
                                    return 'Rata-rata nilai: ' + Number(item.yLabel).toFixed(2);
                                }
                            }
                        }),
                        scales: {
                            xAxes: [{
                                gridLines: { display: false, drawBorder: false },
                                ticks: { fontColor: sharedTickColor, fontSize: 11, fontStyle: '700' }
                            }],
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    suggestedMax: 100,
                                    fontColor: sharedTickColor
                                },
                                gridLines: { color: sharedGridColor, drawBorder: false }
                            }]
                        }
                    }
                });
            }
        })();
    </script>
@endpush
