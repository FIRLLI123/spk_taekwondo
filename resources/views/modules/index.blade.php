@extends('layouts.app')

@section('title', $title . ' | SPK Atlet ESPA Team')
@section('page_heading', $title)

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ $title }}</h6>
        </div>
        <div class="card-body">
            <p class="mb-3">{{ $description }}</p>
            <div class="alert alert-info mb-0">
                Fondasi modul sudah terhubung ke navigasi. Implementasi CRUD dan proses bisnis detail akan dilanjutkan pada fase berikutnya.
            </div>
        </div>
    </div>
@endsection
