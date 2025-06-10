<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Services\ReportService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    protected $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }
    public function index()
    {
        return view('manager.report.index'); // Pastikan file Blade-nya juga ada
    }

    public function stockReport(Request $request)
    {
        $start = $request->input('start_date') ?? '2000-01-01';
        $end = $request->input('end_date') ?? now()->toDateString();

        $reports = $this->reportService->getStockReport($start, $end);


        return view('manager.report.stock', compact('reports', 'start', 'end'));
    }


    public function transactionReport(Request $request)
    {
        $data = $this->reportService->getTransactionReport($request->all());
        return view('manager.report.transaction', compact('data'));
    }
}
