<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KreditNasabah;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $total_nasabah = DB::table('nasabah')
            ->select(DB::raw('COUNT(DISTINCT id) as total_nasabah'))
            ->first();
        $total_nilai_kredit = DB::table('kredit_nasabah')
            ->select(DB::raw('SUM(total_nilai_kredit) AS total_nilai_kredit'))
            ->where('tahun', activePeriod())
            ->first();
        $total_margin_keuntungan = DB::table('kredit_nasabah')
            ->select(DB::raw('SUM(margin_keuntungan) AS total_margin_keuntungan'))
            ->where('tahun', activePeriod())
            ->first();
        $total_sudah_lunas = DB::table('kredit_nasabah')
            ->select(DB::raw('SUM(total_nilai_kredit) AS total_pelunasan'))
            ->where('status_kredit', '=', 'Lunas')
            ->where('tahun', activePeriod())
            ->first();
        $total_belum_lunas = DB::table('kredit_nasabah')
            ->select(DB::raw('SUM(total_nilai_kredit) AS total_belum_lunas'))
            ->where('status_kredit', '=', 'Berjalan')
            ->where('tahun', activePeriod())
            ->first();

        $total_nilai_kredit_graph = array();
        for ($i = 0; $i < 12; $i++) {
            $total_nilai_kredit_graph[] = DB::table('kredit_nasabah')
                ->select(DB::raw('SUM(total_nilai_kredit) AS total_nilai_kredit'))
                ->whereYear('tgl_pencairan', activePeriod())
                ->whereMonth('tgl_pencairan', $i + 1)
                ->where('tahun', activePeriod())
                ->groupBy(DB::raw('MONTH(tgl_pencairan)'))
                ->orderBy(DB::raw('MONTH(tgl_pencairan)'))
                ->pluck('total_nilai_kredit')
                ->first();
        }
        $total_nilai_kredit_graph = array_map('intval', $total_nilai_kredit_graph);

        $total_nilai_pelunasan_graph = array();
        for ($i = 0; $i < 12; $i++) {
            $total_nilai_pelunasan_graph[] = DB::table('kredit_nasabah')
                ->select(DB::raw('SUM(total_nilai_kredit) AS total_nilai_kredit'))
                ->whereYear('tgl_lunas', activePeriod())
                ->where('status_kredit', 'Lunas')
                ->whereMonth('tgl_lunas', $i + 1)
                ->where('tahun', activePeriod())
                ->groupBy(DB::raw('MONTH(tgl_lunas)'))
                ->orderBy(DB::raw('MONTH(tgl_lunas)'))
                ->pluck('total_nilai_kredit')
                ->first();
        }
        $total_nilai_pelunasan_graph = array_map('intval', $total_nilai_pelunasan_graph);

        $total_emas_graph = array();
        $gramasis = DB::table('gramasi')
            ->orderBy('gramasi')
            ->get();
        foreach($gramasis as $key) {
            $total_emas_graph[] = DB::table('kredit_detail')
                ->select(DB::raw('COUNT(kredit_detail.gramasi) AS count_gramasi'))
                ->join('kredit_nasabah', function($join) {
			        $join->on('kredit_detail.id_kredit_nasabah', '=', 'kredit_nasabah.id');
			    })
                ->where('kredit_detail.gramasi', $key->gramasi)
                ->where('kredit_nasabah.status_kredit', 'Berjalan')
                ->where('kredit_nasabah.tahun', activePeriod())
                ->groupBy(DB::raw('kredit_detail.gramasi'))
                ->pluck('count_gramasi')
                ->first();
        }
        $total_emas_graph = array_map('intval', $total_emas_graph);

        // dd($total_nilai_pelunasan_graph);

        return view(
            'dashboard.index',
            compact(
                'total_nasabah',
                'total_nilai_kredit',
                'total_margin_keuntungan',
                'total_sudah_lunas',
                'total_belum_lunas',
                'total_nilai_kredit_graph',
                'total_nilai_pelunasan_graph',
                'total_emas_graph'
            )
        );
    }
}
