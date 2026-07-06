<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cetak Laporan</title>
    <style>
        body { font-family: Arial, sans-serif; color: #222; margin: 24px; }
        h1, h2 { margin-bottom: 8px; }
        .meta { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
        th, td { border: 1px solid #999; padding: 8px; font-size: 12px; }
        th { background: #f2f2f2; text-align: left; }
        .summary { display: flex; gap: 20px; margin-bottom: 20px; }
        .summary-item { border: 1px solid #ccc; padding: 10px 12px; min-width: 140px; }
        @media print {
            .no-print { display: none; }
            body { margin: 0; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 16px;">
        <button onclick="window.print()">Print Sekarang</button>
    </div>

    <h1>Laporan SPK Atlet ESPA Team</h1>
    <div class="meta">
        <div><strong>Periode:</strong> {{ optional($selectedPeriod)->name ?: '-' }}</div>
        <div><strong>Tanggal Cetak:</strong> {{ now()->format('d M Y H:i') }}</div>
    </div>

    <div class="summary">
        <div class="summary-item">
            <strong>Atlet Dinilai</strong><br>
            {{ $scoreStats['athlete_count'] }}
        </div>
        <div class="summary-item">
            <strong>Jumlah Penilai</strong><br>
            {{ $scoreStats['coach_count'] }}
        </div>
        <div class="summary-item">
            <strong>Jumlah Kriteria</strong><br>
            {{ $scoreStats['criteria_count'] }}
        </div>
        <div class="summary-item">
            <strong>Entri Nilai</strong><br>
            {{ $scoreStats['score_entries'] }}
        </div>
    </div>

    <h2>Hasil Ranking</h2>
    <table>
        <thead>
            <tr>
                <th>Ranking</th>
                <th>Kode Atlet</th>
                <th>Nama Atlet</th>
                <th>Nilai Preferensi</th>
                <th>Jarak Positif</th>
                <th>Jarak Negatif</th>
            </tr>
        </thead>
        <tbody>
            @forelse($results as $result)
                <tr>
                    <td>#{{ $result->rank }}</td>
                    <td>{{ optional($result->athlete)->code }}</td>
                    <td>{{ optional($result->athlete)->name }}</td>
                    <td>{{ number_format($result->preference_value, 6) }}</td>
                    <td>{{ number_format($result->positive_distance, 6) }}</td>
                    <td>{{ number_format($result->negative_distance, 6) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Belum ada hasil ranking.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <h2>Rekap Rata-rata Penilaian</h2>
    <table>
        <thead>
            <tr>
                <th>Kode Atlet</th>
                <th>Nama Atlet</th>
                @foreach($criteria as $criterion)
                    <th>{{ $criterion->code }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse($scoreMatrix as $row)
                <tr>
                    <td>{{ $row['athlete_code'] }}</td>
                    <td>{{ $row['athlete_name'] }}</td>
                    @foreach($criteria as $criterion)
                        <td>{{ number_format($row['scores'][$criterion->id] ?? 0, 4) }}</td>
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td colspan="{{ 2 + $criteria->count() }}">Belum ada data penilaian.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
