<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanKunjunganPerPersonExport implements FromView
{
    private $query;
    private $type;
    private $filter;
    private $store;

    public function __construct(string $query, string $type, string $filter, string $store)
    {
        $this->query = $query;
        $this->type = $type;
        $this->filter = $filter;
        $this->store = $store;
    }

    public function view(): View
    {
        return view('laporan.exports.kunjungan_per_person', [
            'data' => DB::select($this->query),
            'type' => $this->type,
            'filter' => $this->filter,
            'store' => $this->store,
        ]);
    }
}
