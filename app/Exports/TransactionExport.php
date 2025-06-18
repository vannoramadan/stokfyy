<?php

namespace App\Exports;

use App\Models\StockTransaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TransactionExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $startDate = $this->request->start_date ?? now()->subMonth()->format('Y-m-d');
        $endDate = $this->request->end_date ?? now()->format('Y-m-d');

        return StockTransaction::with(['product', 'user'])
            ->when($this->request->type, function ($q) {
                $q->where('type', $this->request->type);
            })
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'Tanggal'    => Carbon::parse($item->created_at)->format('d/m/Y H:i'),
                    'Produk'     => $item->product->name,
                    'Tipe'       => $item->type == 'in' ? 'Masuk' : 'Keluar',
                    'Jumlah'     => $item->quantity,
                    'Keterangan' => $item->description ?? '-',
                    'User'       => $item->user->name,
                ];
            });
    }

    public function headings(): array
    {
        return ['Tanggal/Waktu', 'Produk', 'Tipe', 'Jumlah', 'Keterangan', 'User'];
    }
}
