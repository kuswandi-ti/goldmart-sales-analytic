<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanPenjualanAllStoreExport implements FromView
{
    private $query;
    private $type;
    private $filter;

    public function __construct(string $query, string $type, string $filter)
    {
        $this->query = $query;
        $this->type = $type;
        $this->filter = $filter;
    }

    public function view(): View
    {
        return view('laporan.exports.penjualan_all_store', [
            'data' => DB::select($this->query),
            'type' => $this->type,
            'filter' => $this->filter,
        ]);
    }
}
