<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan SPK Atlet ESPA Team</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #111; font-size: 12px; }
        .header { text-align: center; margin-bottom: 8px; }
        .header h1 { font-size: 16px; margin: 0; }
        .header h2 { font-size: 14px; margin: 4px 0 0; }
        .header p { margin: 2px 0; font-size: 11px; }
        .line-strong { border-top: 2px solid #000; margin-top: 8px; }
        .line-soft { border-top: 1px solid #000; margin-top: 2px; margin-bottom: 16px; }
        .meta-table, .report-table { width: 100%; border-collapse: collapse; margin-bottom: 14px; }
        .meta-table td { padding: 3px 0; vertical-align: top; }
        .report-table th, .report-table td { border: 1px solid #444; padding: 6px; }
        .report-table th { background: #e9eef5; text-align: center; }
        .section-title { font-size: 13px; font-weight: bold; margin: 18px 0 8px; }
        .summary-box { width: 100%; margin-bottom: 14px; }
        .summary-box td { width: 25%; border: 1px solid #777; padding: 8px; text-align: center; }
        .summary-label { font-size: 10px; text-transform: uppercase; color: #555; }
        .summary-value { font-size: 16px; font-weight: bold; margin-top: 4px; }
        .signature { width: 100%; margin-top: 30px; }
        .signature td { width: 50%; text-align: center; vertical-align: top; }
    </style>
</head>
<body>
    <div class="header">
        <h1>CLUB TAEKWONDO ESPA TEAM</h1>
        <p>Sistem Penunjang Keputusan Pemilihan Atlet Terbaik</p>
        <p>Laporan Hasil Penilaian dan Ranking Metode TOPSIS</p>
    </div>

    <div class="line-strong"></div>
    <div class="line-soft"></div>

    <table class="meta-table">
        <tr>
            <td width="120">Periode</td>
            <td width="10">:</td>
            <td>{{ optional($selectedPeriod)->name ?: '-' }}</td>
        </tr>
        <tr>
            <td>Rentang</td>
            <td>:</td>
            <td>{{ optional($selectedPeriod)->date_range ?: '-' }}</td>
        </tr>
        <tr>
            <td>Tanggal Cetak</td>
            <td>:</td>
            <td>{{ now()->format('d F Y H:i') }}</td>
        </tr>
    </table>

    <table class="summary-box" cellspacing="0" cellpadding="0">
        <tr>
            <td>
                <div class="summary-label">Atlet Dinilai</div>
                <div class="summary-value">{{ $scoreStats['athlete_count'] }}</div>
            </td>
            <td>
                <div class="summary-label">Jumlah Penilai</div>
                <div class="summary-value">{{ $scoreStats['coach_count'] }}</div>
            </td>
            <td>
                <div class="summary-label">Jumlah Kriteria</div>
                <div class="summary-value">{{ $scoreStats['criteria_count'] }}</div>
            </td>
            <td>
                <div class="summary-label">Entri Nilai</div>
                <div class="summary-value">{{ $scoreStats['score_entries'] }}</div>
            </td>
        </tr>
    </table>

    <div class="section-title">A. Hasil Ranking Atlet</div>
    <table class="report-table">
        <thead>
            <tr>
                <th width="55">Ranking</th>
                <th width="80">Kode</th>
                <th>Nama Atlet</th>
                <th width="90">Preferensi</th>
                <th width="90">Jarak +</th>
                <th width="90">Jarak -</th>
            </tr>
        </thead>
        <tbody>
            @forelse($results as $result)
                <tr>
                    <td style="text-align: center;">{{ $result->rank }}</td>
                    <td>{{ optional($result->athlete)->code }}</td>
                    <td>{{ optional($result->athlete)->name }}</td>
                    <td style="text-align: right;">{{ number_format($result->preference_value, 6) }}</td>
                    <td style="text-align: right;">{{ number_format($result->positive_distance, 6) }}</td>
                    <td style="text-align: right;">{{ number_format($result->negative_distance, 6) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Belum ada hasil ranking.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="section-title">B. Rekap Rata-rata Penilaian</div>
    <table class="report-table">
        <thead>
            <tr>
                <th width="80">Kode</th>
                <th>Nama Atlet</th>
                @foreach($criteria as $criterion)
                    <th width="60">{{ $criterion->code }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse($scoreMatrix as $row)
                <tr>
                    <td>{{ $row['athlete_code'] }}</td>
                    <td>{{ $row['athlete_name'] }}</td>
                    @foreach($criteria as $criterion)
                        <td style="text-align: right;">{{ number_format($row['scores'][$criterion->id] ?? 0, 4) }}</td>
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td colspan="{{ 2 + $criteria->count() }}" style="text-align: center;">Belum ada data penilaian.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <table class="signature">
        <tr>
            <td></td>
            <td>
                Mengetahui,<br>
                Admin ESPA Team
                <br><br><br><br>
                (____________________)
            </td>
        </tr>
    </table>
</body>
</html>
