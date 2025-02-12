<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanKunjunganDetailTanyaExport implements FromView
{
    private $query;

    public function __construct(string $query)
    {
        $this->query = $query;
    }

    public function view(): View
    {
        return view('laporan.exports.kunjungan_detail_tanya', [
            'data' => DB::select($this->query),
        ]);
    }
}
