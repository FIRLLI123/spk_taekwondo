<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="SPK Pemilihan Atlet Terbaik ESPA Team">
    <meta name="author" content="Codex">

    <title>@yield('title', 'SPK Atlet ESPA Team')</title>

    <link href="{{ asset('sbadmin2/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
    <link href="{{ asset('sbadmin2/css/sb-admin-2.min.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body id="page-top">
    <div id="wrapper">
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-medal"></i>
                </div>
                <div class="sidebar-brand-text mx-3">SPK ESPA</div>
            </a>

            <hr class="sidebar-divider my-0">

            <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            <div class="sidebar-heading">Master Data</div>

            @if(auth()->user()->isAdmin())
                <li class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('users.index') }}">
                        <i class="fas fa-fw fa-users-cog"></i>
                        <span>User</span>
                    </a>
                </li>
            @endif

            <li class="nav-item {{ request()->routeIs('athletes.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('athletes.index') }}">
                    <i class="fas fa-fw fa-running"></i>
                    <span>Atlet</span>
                </a>
            </li>

            @if(auth()->user()->isAdmin())
                <li class="nav-item {{ request()->routeIs('criteria.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('criteria.index') }}">
                        <i class="fas fa-fw fa-balance-scale"></i>
                        <span>Kriteria</span>
                    </a>
                </li>

                <li class="nav-item {{ request()->routeIs('periods.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('periods.index') }}">
                        <i class="fas fa-fw fa-calendar"></i>
                        <span>Periode</span>
                    </a>
                </li>
            @endif

            <hr class="sidebar-divider">

            <div class="sidebar-heading">Proses</div>

            <li class="nav-item {{ request()->routeIs('scores.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('scores.index') }}">
                    <i class="fas fa-fw fa-edit"></i>
                    <span>Penilaian</span>
                </a>
            </li>

            @if(auth()->user()->isAdmin())
                <li class="nav-item {{ request()->routeIs('topsis.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('topsis.process') }}">
                        <i class="fas fa-fw fa-cogs"></i>
                        <span>Proses TOPSIS</span>
                    </a>
                </li>
            @endif

            <li class="nav-item {{ request()->routeIs('rankings.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('rankings.index') }}">
                    <i class="fas fa-fw fa-trophy"></i>
                    <span>Ranking</span>
                </a>
            </li>

            @if(auth()->user()->isAdmin())
                <li class="nav-item {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('reports.index') }}">
                        <i class="fas fa-fw fa-file-pdf"></i>
                        <span>Laporan</span>
                    </a>
                </li>
            @endif

            <hr class="sidebar-divider d-none d-md-block">

            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <h1 class="h5 mb-0 text-gray-800">@yield('page_heading', 'Dashboard')</h1>

                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    {{ auth()->user()->name }} ({{ strtoupper(auth()->user()->role) }})
                                </span>
                                <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary text-white font-weight-bold" style="width: 2rem; height: 2rem;">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </li>
                    </ul>
                </nav>

                <div class="container-fluid">
                    @if(session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>

            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>SPK Pemilihan Atlet Terbaik ESPA Team</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <script src="{{ asset('sbadmin2/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('sbadmin2/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('sbadmin2/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('sbadmin2/js/sb-admin-2.min.js') }}"></script>
    @stack('scripts')
</body>
</html>
