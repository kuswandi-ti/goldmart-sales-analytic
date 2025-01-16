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
        if (auth()->user()->can('dashboard gsa')) {
            $total_sales_value = DB::table('customer_visit')
                ->select(DB::raw('SUM(nominal) as total_sales_value'))
                ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
                ->whereYear('customer_visit.tgl_visit', activePeriod())
                ->where('customer_visit.parameter_1', 'Beli')
                ->first();

            $total_sales_pcs = DB::table('customer_visit')
                ->select(DB::raw('SUM(qty) as total_sales_pcs'))
                ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
                ->whereYear('customer_visit.tgl_visit', activePeriod())
                ->where('customer_visit.parameter_1', 'Beli')
                ->first();

            $total_customer_visit = DB::table('customer_visit')
                ->select(DB::raw('COUNT(no_dokumen) as total_customer_visit'))
                ->whereYear('customer_visit.tgl_visit', activePeriod())
                ->first();

            $penjualan_hari_ini = DB::table('customer_visit')
                ->select(DB::raw('customer_visit_detail.parameter_1,
                    customer_visit_detail.parameter_2,
                    SUM(customer_visit_detail.qty) AS qty,
                    SUM(customer_visit_detail.nominal) AS nominal'))
                ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
                ->where('customer_visit.tgl_visit', saveDateNow())
                ->where('customer_visit.parameter_1', 'Beli')
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
                ->groupBy(['customer_visit_detail.parameter_1', 'customer_visit_detail.parameter_2'])
                ->get();
        } else {
            $total_sales_value = 0;
            $total_sales_pcs = 0;
            $total_customer_visit = '';
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
        }

        return view(
            'dashboard.index',
            compact(
                'total_sales_value',
                'total_sales_pcs',
                'total_customer_visit',
                'penjualan_hari_ini',
                'penjualan_bulan_ini',
            )
        );
    }
}
