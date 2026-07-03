Product Requirements Document (PRD)
Sistem Penunjang Keputusan Pemilihan Atlet Terbaik Club Taekwondo ESPA Team dengan Metode TOPSIS
1. Informasi Umum

Nama Aplikasi : SPK Pemilihan Atlet Terbaik ESPA Team
Platform : Web Application
Framework : Laravel
Metode : TOPSIS (Technique for Order Preference by Similarity to Ideal Solution)
Pengguna :

Admin
Pelatih/Penilai
2. Latar Belakang

Club Taekwondo ESPA Team membutuhkan sistem yang dapat membantu proses pemilihan atlet terbaik secara objektif berdasarkan beberapa kriteria penilaian. Selama ini proses penilaian dilakukan secara manual sehingga memerlukan waktu yang cukup lama dan berpotensi menimbulkan subjektivitas.

Sistem ini dibangun untuk membantu proses pengambilan keputusan menggunakan metode TOPSIS sehingga menghasilkan peringkat atlet terbaik berdasarkan nilai yang diberikan.

3. Tujuan Sistem
Mengelola data atlet.
Mengelola data kriteria dan bobot penilaian.
Memudahkan pelatih dalam memberikan penilaian.
Menghitung peringkat atlet secara otomatis menggunakan metode TOPSIS.
Menyediakan laporan hasil penilaian dan ranking atlet.
4. Ruang Lingkup Sistem
Data Master
User
Atlet
Kriteria
Periode Penilaian
Transaksi
Penilaian Atlet
Proses
Perhitungan TOPSIS
Ranking Atlet
Laporan
Hasil Ranking
Detail Perhitungan
Cetak PDF
Export Excel
5. Role dan Hak Akses
5.1 Admin
Hak Akses:
Login
Dashboard
Kelola User
Kelola Atlet
Kelola Kriteria
Kelola Periode
Melihat seluruh penilaian
Menjalankan proses TOPSIS
Melihat hasil ranking
Cetak laporan
5.2 Pelatih/Penilai
Hak Akses:
Login
Dashboard
Melihat data atlet
Menginput penilaian atlet
Melihat hasil ranking
6. Flow Sistem
Login
↓
Dashboard
↓
Master Data
    ↓
    Data Atlet
    Data Kriteria
    Data User
    Data Periode
↓
Penilaian Atlet
↓
Proses TOPSIS
↓
Hasil Ranking
↓
Laporan
7. Modul Sistem
7.1 Login
Fitur:
Login menggunakan email dan password.
Logout.
Ganti password.
7.2 Dashboard
Informasi:
Jumlah Atlet
Jumlah Kriteria
Jumlah Penilaian
Jumlah User
Atlet Terbaik Periode Terakhir
Grafik Hasil Penilaian (Opsional)
7.3 Master Atlet
Field
Field	Tipe
id	bigint
kode_atlet	string
nama_atlet	string
jenis_kelamin	enum
tanggal_lahir	date
umur	integer
tingkat_sabuk	string
kelas_pertandingan	string
status	enum
Fitur
Tambah Atlet
Edit Atlet
Hapus Atlet
Detail Atlet
Pencarian Atlet
7.4 Master Kriteria
Field
Field	Tipe
id	bigint
kode	string
nama_kriteria	string
bobot	decimal
atribut	enum
Atribut:
Benefit
Cost
Fitur:
Tambah Kriteria
Edit Kriteria
Hapus Kriteria
Pengaturan Bobot
7.5 Master User
Field
Field	Tipe
id	bigint
nama	string
email	string
password	string
role	enum
Role:
Admin
Pelatih
7.6 Master Periode
Field
Field	Tipe
id	bigint
nama_periode	string
tanggal_mulai	date
tanggal_selesai	date
status	enum
Contoh:
Januari 2026
Semester 1 2026
Tahun 2026
7.7 Penilaian Atlet
Alur

Pilih Periode → Pilih Atlet → Input Nilai → Simpan.

Field Penilaian
Field	Tipe
id	bigint
periode_id	bigint
atlet_id	bigint
kriteria_id	bigint
user_id	bigint
nilai	decimal
Fitur:
Input nilai per atlet.
Edit nilai.
Hapus nilai.
Filter berdasarkan periode.
Riwayat penilaian.
7.8 Proses TOPSIS
Langkah Perhitungan:
Membentuk matriks keputusan.
Normalisasi matriks.
Matriks ternormalisasi terbobot.
Menentukan solusi ideal positif.
Menentukan solusi ideal negatif.
Menghitung jarak positif.
Menghitung jarak negatif.
Menghitung nilai preferensi.
Menentukan ranking atlet.
Output:
Nilai Preferensi.
Ranking Atlet.
7.9 Hasil Ranking
Informasi
Ranking	Atlet	Nilai
1	Ahmad	0.92
2	Budi	0.86
3	Citra	0.81
Fitur:
Filter berdasarkan periode.
Detail perhitungan.
Cetak PDF.
Export Excel.
7.10 Laporan
Laporan Data Atlet
Laporan Penilaian
Laporan Ranking
Laporan Detail Perhitungan TOPSIS

Output:

PDF
Excel
8. Struktur Database
users
atlet
kriteria
periode
penilaian
hasil_topsis
9. Relasi Database
users
 └── penilaian

periode
 ├── penilaian
 └── hasil_topsis

atlet
 ├── penilaian
 └── hasil_topsis

kriteria
 └── penilaian
10. Kebutuhan Non-Fungsional
Sistem
Web Based.
Responsive.
Multi User.
Authentication & Authorization.
Menggunakan Database MySQL.

11. Flow Penggunaan
Admin
↓
Tambah Atlet
↓
Tambah Kriteria
↓
Tambah Periode
↓
Tambah User Pelatih
↓
Pelatih Memberikan Penilaian
↓
Admin Menjalankan TOPSIS
↓
Sistem Menghasilkan Ranking
↓
Cetak Laporan
12. MVP (Versi Skripsi)
Wajib:

✅ Login
✅ Master Atlet
✅ Master Kriteria
✅ Master User
✅ Master Periode
✅ Penilaian Atlet
✅ Proses TOPSIS
✅ Hasil Ranking
✅ Cetak PDF

Opsional:
Export Excel
Grafik Dashboard
Riwayat Ranking
Multi Penilai dengan rata-rata otomatis

Menurut saya, PRD ini sudah cukup lengkap untuk langsung dijadikan acuan membuat:

ERD database.
Migration Laravel.
Use Case Diagram.
Activity Diagram.
Sprint development aplikasi.