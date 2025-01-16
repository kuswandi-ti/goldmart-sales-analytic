<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    function __construct()
    {
        $this->middleware(['permission:report sales per person'])->only(['reportSalesPerPerson', 'reportSalesPerStore', 'reportSalesAllStore']);
    }

    public function reportSalesPerPerson(Request $request)
    {
        // Untuk data yg tampil di tabel
        $data_table = DB::table('sales_person')
            ->leftJoin('customer_visit', 'sales_person.id', '=', 'customer_visit.id_sales_person')
            ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
            ->select(DB::raw('sales_person.kode AS kode_sales_person,
                sales_person.nama AS nama_sales_person,
                sales_person.kode_store,
                sales_person.nama_store,
                sales_person.kota_store,
                SUM(COALESCE(customer_visit_detail.qty, 0)) AS total_qty,
                SUM(COALESCE(customer_visit_detail.nominal, 0)) AS total_nominal'))
            ->whereRaw('customer_visit.parameter_1 = "Beli"
                AND YEAR(customer_visit.tgl_visit) = ' . activePeriod() .
                ' OR customer_visit.tgl_visit IS NULL')
            ->groupBy([
                'sales_person.kode',
                'sales_person.nama',
                'sales_person.kode_store',
                'sales_person.nama_store',
                'sales_person.kota_store',
            ])
            ->orderByRaw('sales_person.nama')
            ->get();

        // Untuk data di grafik
        $data_sales = DB::table('sales_person')
            ->leftJoin('customer_visit', 'sales_person.id', '=', 'customer_visit.id_sales_person')
            ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
            ->select(DB::raw('sales_person.nama AS nama_sales_person,
                SUM(COALESCE(customer_visit_detail.qty, 0)) AS total_qty,
                SUM(COALESCE(customer_visit_detail.nominal, 0)) AS total_nominal'))
            ->whereRaw('customer_visit.parameter_1 = "Beli"
                AND YEAR(customer_visit.tgl_visit) = ' . activePeriod() .
                ' OR customer_visit.tgl_visit IS NULL')
            ->groupBy([
                'sales_person.nama',
            ])
            ->orderByRaw('sales_person.nama')
            ->get();
        // dd($data_sales);

        $data_sales_graph = array();
        foreach ($data_sales as $key) {
            $data_sales_graph[] = $key->nama_sales_person;
        }
        // dd($data_sales_graph);

        $data_qty_graph = array();
        foreach ($data_sales as $key) {
            $data_qty_graph[] = $key->total_qty;
        }
        $data_qty_graph = array_map('intval', $data_qty_graph);
        // dd($data_qty_graph);

        $data_nominal_graph = array();
        foreach ($data_sales as $key) {
            $data_nominal_graph[] = $key->total_nominal;
        }
        $data_nominal_graph = array_map('intval', $data_nominal_graph);
        // dd($data_nominal_graph);

        return view('report.sales_per_person', compact(
            'data_table',
            'data_sales_graph',
            'data_qty_graph',
            'data_nominal_graph',
        ));
    }

    public function reportSalesPerStore(Request $request)
    {
        // Untuk data yg tampil di tabel
        $data_table = DB::table('store')
            ->leftJoin('customer_visit', 'store.id', '=', 'customer_visit.id_store')
            ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
            ->select(DB::raw('store.kode AS kode_store,
                store.nama AS nama_store,
                store.kota AS kota_store,
                SUM(COALESCE(customer_visit_detail.qty, 0)) AS total_qty,
                SUM(COALESCE(customer_visit_detail.nominal, 0)) AS total_nominal'))
            ->whereRaw('customer_visit.parameter_1 = "Beli"
                AND YEAR(customer_visit.tgl_visit) = ' . activePeriod() .
                ' OR customer_visit.tgl_visit IS NULL')
            ->groupBy([
                'store.kode',
                'store.nama',
                'store.kota',
            ])
            ->orderByRaw('store.nama')
            ->get();

        // Untuk data di grafik
        $data_store = DB::table('store')
            ->leftJoin('customer_visit', 'store.id', '=', 'customer_visit.id_store')
            ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
            ->select(DB::raw('store.nama AS nama_store,
                SUM(COALESCE(customer_visit_detail.qty, 0)) AS total_qty,
                SUM(COALESCE(customer_visit_detail.nominal, 0)) AS total_nominal'))
            ->whereRaw('customer_visit.parameter_1 = "Beli"
                AND YEAR(customer_visit.tgl_visit) = ' . activePeriod() .
                ' OR customer_visit.tgl_visit IS NULL')
            ->groupBy([
                'store.nama',
            ])
            ->orderByRaw('store.nama')
            ->get();
        // dd($data_store);

        $data_store_graph = array();
        foreach ($data_store as $key) {
            $data_store_graph[] = $key->nama_store;
        }
        // dd($data_store_graph);

        $data_qty_graph = array();
        foreach ($data_store as $key) {
            $data_qty_graph[] = $key->total_qty;
        }
        $data_qty_graph = array_map('intval', $data_qty_graph);
        // dd($data_qty_graph);

        $data_nominal_graph = array();
        foreach ($data_store as $key) {
            $data_nominal_graph[] = $key->total_nominal;
        }
        $data_nominal_graph = array_map('intval', $data_nominal_graph);
        // dd($data_nominal_graph);

        return view('report.sales_per_store', compact(
            'data_table',
            'data_store_graph',
            'data_qty_graph',
            'data_nominal_graph',
        ));
    }

    public function reportSalesAllStore(Request $request)
    {
        // Untuk data yg tampil di tabel
        $data_table = DB::table('store')
            ->leftJoin('customer_visit', 'store.id', '=', 'customer_visit.id_store')
            ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
            ->select(DB::raw('SUM(COALESCE(customer_visit_detail.qty, 0)) AS total_qty,
                SUM(COALESCE(customer_visit_detail.nominal, 0)) AS total_nominal'))
            ->whereRaw('customer_visit.parameter_1 = "Beli"
                AND YEAR(customer_visit.tgl_visit) = ' . activePeriod() .
                ' OR customer_visit.tgl_visit IS NULL')
            ->get();

        return view('report.sales_all_store', compact(
            'data_table',
        ));
    }
}
