<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class RankingSheetExport implements FromArray, ShouldAutoSize, WithEvents, WithTitle
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        $rows = [
            ['LAPORAN HASIL RANKING ATLET TERBAIK'],
            ['Club Taekwondo ESPA Team'],
            ['Periode', optional($this->data['selectedPeriod'])->name ?: '-'],
            ['Tanggal Cetak', now()->format('d M Y H:i')],
            [],
            ['Ranking', 'Kode Atlet', 'Nama Atlet', 'Nilai Preferensi', 'Jarak Positif', 'Jarak Negatif'],
        ];

        foreach ($this->data['results'] as $result) {
            $rows[] = [
                $result->rank,
                optional($result->athlete)->code,
                optional($result->athlete)->name,
                (float) $result->preference_value,
                (float) $result->positive_distance,
                (float) $result->negative_distance,
            ];
        }

        return $rows;
    }

    public function title(): string
    {
        return 'Ranking';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $lastRow = 6 + $this->data['results']->count();
                $lastColumn = 'F';

                $event->sheet->mergeCells('A1:' . $lastColumn . '1');
                $event->sheet->mergeCells('A2:' . $lastColumn . '2');
                $event->sheet->getStyle('A1:' . $lastColumn . '2')->getFont()->setBold(true);
                $event->sheet->getStyle('A1')->getFont()->setSize(14);
                $event->sheet->getStyle('A1:' . $lastColumn . '2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getStyle('A6:' . $lastColumn . '6')->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'D9EAF7'],
                    ],
                ]);
                $event->sheet->getStyle('A6:' . $lastColumn . $lastRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => ['borderStyle' => Border::BORDER_THIN],
                    ],
                ]);
            },
        ];
    }
}
