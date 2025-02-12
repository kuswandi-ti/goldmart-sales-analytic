<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanKunjunganDetailBeliExport implements FromView
{
    private $query1;
    private $query2;

    public function __construct(string $query1, string $query2)
    {
        $this->query1 = $query1;
        $this->query2 = $query2;
    }

    public function view(): View
    {
        return view('laporan.exports.kunjungan_detail_beli', [
            'data1' => DB::select($this->query1),
            'data2' => DB::select($this->query2),
        ]);
    }
}
