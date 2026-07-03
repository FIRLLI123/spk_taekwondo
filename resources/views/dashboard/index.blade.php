@extends('layouts.app')

@section('title', 'Dashboard | SPK Atlet ESPA Team')
@section('page_heading', 'Dashboard')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <p class="mb-0 text-gray-600">Ringkasan data utama sistem penunjang keputusan atlet terbaik.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Atlet</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['athletes'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-running fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Kriteria</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['criteria'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-balance-scale fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Penilaian</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['scores'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-edit fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total User</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['users'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-7 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Status Pengembangan MVP</h6>
                </div>
                <div class="card-body">
                    <p>Fondasi aplikasi sudah disiapkan dengan autentikasi, role, layout SB Admin 2, dan struktur database inti.</p>
                    <p class="mb-0">Tahap berikutnya paling natural adalah implementasi CRUD master data, form penilaian, lalu service perhitungan TOPSIS.</p>
                </div>
            </div>
        </div>

        <div class="col-lg-5 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Atlet Terbaik Periode Terakhir</h6>
                </div>
                <div class="card-body">
                    @if($bestAthlete && $bestAthlete->athlete)
                        <h4 class="small font-weight-bold">
                            {{ $bestAthlete->athlete->name }}
                            <span class="float-right">Nilai {{ number_format($bestAthlete->preference_value, 4) }}</span>
                        </h4>
                        <div class="progress mb-4">
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ min(100, round($bestAthlete->preference_value * 100, 2)) }}%" aria-valuenow="{{ round($bestAthlete->preference_value * 100, 2) }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <p class="mb-1"><strong>Periode:</strong> {{ optional($latestPeriod)->name }}</p>
                        <p class="mb-0"><strong>Ranking:</strong> #{{ $bestAthlete->rank }}</p>
                    @else
                        <p class="mb-0 text-gray-600">Belum ada hasil ranking. Jalankan proses TOPSIS setelah data penilaian tersedia.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
