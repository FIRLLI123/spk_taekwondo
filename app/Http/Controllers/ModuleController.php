<?php

namespace App\Http\Controllers;

class ModuleController extends Controller
{
    public function users()
    {
        return $this->render('Manajemen User', 'Kelola akun admin dan pelatih.');
    }

    public function athletes()
    {
        return $this->render('Data Atlet', 'Kelola data master atlet yang akan dinilai.');
    }

    public function criteria()
    {
        return $this->render('Data Kriteria', 'Kelola kriteria, bobot, dan atribut benefit/cost.');
    }

    public function periods()
    {
        return $this->render('Periode Penilaian', 'Kelola periode aktif untuk siklus penilaian.');
    }

    public function scores()
    {
        return $this->render('Penilaian Atlet', 'Input dan pantau penilaian atlet per periode.');
    }

    public function rankings()
    {
        return $this->render('Hasil Ranking', 'Lihat peringkat atlet berdasarkan proses TOPSIS.');
    }

    public function topsis()
    {
        return $this->render('Proses TOPSIS', 'Halaman ini akan digunakan untuk menjalankan perhitungan TOPSIS.');
    }

    public function reports()
    {
        return $this->render('Laporan', 'Cetak PDF dan export Excel hasil penilaian serta ranking.');
    }

    protected function render($title, $description)
    {
        return view('modules.index', compact('title', 'description'));
    }
}
