<?php

namespace App\Http\Controllers;

use App\Exports\ReportWorkbookExport;
use App\Services\ReportService;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    protected $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function index(Request $request)
    {
        return view('reports.index', $this->reportService->build($request->get('period_id')));
    }

    public function print(Request $request)
    {
        return view('reports.print', $this->reportService->build($request->get('period_id')));
    }

    public function exportXlsx(Request $request)
    {
        $data = $this->reportService->build($request->get('period_id'));
        $selectedPeriod = $data['selectedPeriod'];
        $filename = 'laporan-espa-team-' . ($selectedPeriod ? $selectedPeriod->id : 'periode') . '.xlsx';

        return Excel::download(new ReportWorkbookExport($data), $filename);
    }

    public function exportPdf(Request $request)
    {
        $data = $this->reportService->build($request->get('period_id'));
        $selectedPeriod = $data['selectedPeriod'];
        $filename = 'laporan-espa-team-' . ($selectedPeriod ? $selectedPeriod->id : 'periode') . '.pdf';

        $pdf = PDF::loadView('reports.pdf', $data)
            ->setPaper('a4', 'portrait');

        return $pdf->download($filename);
    }
}
