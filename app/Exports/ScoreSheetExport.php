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

class ScoreSheetExport implements FromArray, ShouldAutoSize, WithEvents, WithTitle
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        $header = ['Kode Atlet', 'Nama Atlet'];

        foreach ($this->data['criteria'] as $criterion) {
            $header[] = $criterion->code . ' - ' . $criterion->name;
        }

        $rows = [
            ['REKAP RATA-RATA PENILAIAN ATLET'],
            ['Club Taekwondo ESPA Team'],
            ['Periode', optional($this->data['selectedPeriod'])->name ?: '-'],
            ['Tanggal Cetak', now()->format('d M Y H:i')],
            [],
            $header,
        ];

        foreach ($this->data['scoreMatrix'] as $row) {
            $line = [$row['athlete_code'], $row['athlete_name']];

            foreach ($this->data['criteria'] as $criterion) {
                $line[] = (float) ($row['scores'][$criterion->id] ?? 0);
            }

            $rows[] = $line;
        }

        return $rows;
    }

    public function title(): string
    {
        return 'Penilaian';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $columnCount = 2 + $this->data['criteria']->count();
                $lastColumn = Coordinate::stringFromColumnIndex($columnCount);
                $lastRow = 6 + $this->data['scoreMatrix']->count();

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
