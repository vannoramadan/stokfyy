<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockTransaction;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Models\Category;
use Spatie\Activitylog\Models\Activity;
use App\Exports\TransactionExport;
use Maatwebsite\Excel\Facades\Excel;


class ReportController extends Controller
{
    public function stockReport(Request $request)
    {
        $query = Product::query()
            ->with('category')
            ->withSum(['stockTransactions as total_in' => function($q) {
                $q->where('type', 'in');
            }], 'quantity')
            ->withSum(['stockTransactions as total_out' => function($q) {
                $q->where('type', 'out');
            }], 'quantity');

        // Filter berdasarkan request
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('stock_status')) {
            if ($request->stock_status == 'low') {
                $query->whereColumn('stock', '<', 'min_stock');
            } elseif ($request->stock_status == 'out') {
                $query->where('stock', 0);
            }
        }

        $products = $query->orderBy('stock')->get();
        $categories = Category::all();

        return view('public.reports.stocks', [
            'products' => $products,
            'categories' => $categories,
            'isEmpty' => $products->isEmpty()
        ]);
    }

    public function transactionReport(Request $request)
    {
        $query = StockTransaction::query()
            ->with(['product', 'user'])
            ->latest();

        // Inisialisasi default tanggal
        $startDate = $request->start_date ?? now()->startOfMonth()->toDateString();
        $endDate = $request->end_date ?? now()->toDateString();

        // Filter tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                $request->start_date,
                $request->end_date
            ]);
        } else {
            $query->whereDate('created_at', today());
        }

        // Filter tipe transaksi
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $transactions = $query->paginate(20);

        return view('public.reports.transations', [
            'transactions' => $transactions,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'isEmpty' => $transactions->isEmpty()
        ]);
    }

    public function userActivityReport(Request $request)
    {
        $query = Activity::query()->with(['causer' => function ($q) {
            $q->withTrashed();
        }])->latest();

        // Filter user
        if ($request->filled('user_id')) {
            $query->where('causer_id', $request->user_id);
        }

        // Filter tanggal
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $activities = $query->paginate(20);
        $users = User::all();

        return view('public.reports.activities', [
            'activities' => $activities,
            'users' => $users,
            'isEmpty' => $activities->isEmpty()
        ]);
    }

    public function downloadReport(Request $request, $type)
    {
        $data = [];
        $fileName = 'report_'.now()->format('Ymd_His').'.pdf';
        $view = '';

        switch ($type) {
            case 'stocks':
                $query = Product::with('category');
                if ($request->category) {
                    $query->where('category_id', $request->category);
                }
                $data['products'] = $query->orderBy('stock')->get();
                $data['title'] = 'Laporan Stok Barang';
                $view = 'public.reports.pdf.stocks';
                break;

            case 'transactions':
                $startDate = $request->start_date ?? now()->subMonth()->format('Y-m-d');
                $endDate = $request->end_date ?? now()->format('Y-m-d');
                
                $data['transactions'] = StockTransaction::with(['product', 'user'])
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->orderBy('created_at', 'desc')
                    ->get();
                $data['title'] = 'Laporan Transaksi Stok';
                $data['period'] = Carbon::parse($startDate)->format('d/m/Y').' - '.Carbon::parse($endDate)->format('d/m/Y');
                $view = 'public.reports.pdf.transactions';
                break;

            case 'activities':
                $data['activities'] = ActivityLog::with('causer')
                    ->orderBy('created_at', 'desc')
                    ->limit(100)
                    ->get();
                $data['title'] = 'Laporan Aktivitas Pengguna';
                $view = 'public.reports.pdf.activities';
                break;
        }

        $pdf = Pdf::loadView($view, $data);
        return $pdf->download($fileName);
    }

    public function export(Request $request, $type)
{
    if (!in_array($request->type, ['excel', 'csv'])) {
        return abort(400, 'Invalid export type.');
    }

    $export = new TransactionExport($request);
    $format = $request->type;
    $filename = 'laporan_transaksi_' . now()->format('Ymd_His') . '.' . ($format == 'excel' ? 'xlsx' : 'csv');

    return Excel::download($export, $filename);
}

}
