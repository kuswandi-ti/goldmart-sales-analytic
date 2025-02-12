<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanKunjunganPerStoreExport implements FromView
{
    private $query;
    private $type;
    private $filter;
    private $kota;

    public function __construct(string $query, string $type, string $filter, string $kota)
    {
        $this->query = $query;
        $this->type = $type;
        $this->filter = $filter;
        $this->kota = $kota;
    }

    public function view(): View
    {
        return view('laporan.exports.kunjungan_per_store', [
            'data' => DB::select($this->query),
            'type' => $this->type,
            'filter' => $this->filter,
            'kota' => $this->kota,
        ]);
    }
}
