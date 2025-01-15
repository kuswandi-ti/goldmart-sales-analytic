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
        $penjualan_hari_ini = DB::table('customer_visit')
            ->select(DB::raw('customer_visit_detail.parameter_1,
                customer_visit_detail.parameter_2,
                SUM(customer_visit_detail.qty) AS qty,
                SUM(customer_visit_detail.nominal) AS nominal'))
            ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
            ->where('customer_visit.tgl_visit', saveDateNow())
            ->where('customer_visit.parameter_1', 'Beli')
            ->where('customer_visit.id_sales_person', getSession(0))
            ->groupBy(['customer_visit_detail.parameter_1', 'customer_visit_detail.parameter_2'])
            ->get();

        $penjualan_bulan_ini = DB::table('customer_visit')
            ->select(DB::raw('customer_visit_detail.parameter_1,
                customer_visit_detail.parameter_2,
                SUM(customer_visit_detail.qty) AS qty,
                SUM(customer_visit_detail.nominal) AS nominal'))
            ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
            ->whereYear('customer_visit.tgl_visit', activePeriod())
            ->whereMonth('customer_visit.tgl_visit', date('m'))
            ->where('customer_visit.parameter_1', 'Beli')
            ->where('customer_visit.id_sales_person', getSession(0))
            ->groupBy(['customer_visit_detail.parameter_1', 'customer_visit_detail.parameter_2'])
            ->get();

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
        foreach ($gramasis as $key) {
            $total_emas_graph[] = DB::table('kredit_detail')
                ->select(DB::raw('COUNT(kredit_detail.gramasi) AS count_gramasi'))
                ->join('kredit_nasabah', function ($join) {
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
                'penjualan_hari_ini',
                'penjualan_bulan_ini',
                'total_nilai_kredit_graph',
                'total_nilai_pelunasan_graph',
                'total_emas_graph'
            )
        );
    }
}
