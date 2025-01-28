<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanPenjualanAllStoreExport;
use App\Exports\LaporanPenjualanPerStoreExport;
use App\Exports\LaporanPenjualanPerPersonExport;

class LaporanController extends Controller
{
    function __construct()
    {
        $this->middleware(['permission:laporan penjualan per person'])->only(['laporanPenjualanPerPerson']);
        $this->middleware(['permission:laporan penjualan per store'])->only(['laporanPenjualanPerStore']);
        $this->middleware(['permission:laporan penjualan all store'])->only(['laporanPenjualanAllStore']);
    }

    public function laporanPenjualanPerPerson(Request $request)
    {
        $req = $request->f;
        $type = '';
        $filter = '';

        switch ($req) {
            case 'all':
                // $where = 'YEAR(customer_visit.tgl_visit) = ' . activePeriod();
                $where = 'customer_visit.tahun = ' . activePeriod();
                $type = 'ALL';
                $filter = 'Tahun ' . activePeriod();
                break;

            case 'daily':
                $where = 'customer_visit.tgl_visit = "' . $request->efd . '"';
                $type = 'DAILY';
                $filter = 'Tanggal ' . $request->efd;
                break;

            case 'weekly':
                // $where = 'WEEK(customer_visit.tgl_visit) = ' . $request->efw .
                //     ' AND YEAR(customer_visit . tgl_visit) = ' . activePeriod();
                $where = 'customer_visit.week = ' . $request->efw .
                    ' AND customer_visit.tahun = ' . activePeriod();
                $type = 'WEEKLY';
                $filter = 'Week ' . $request->efw . ', Tahun ' . activePeriod();
                break;

            case 'monthly':
                // $where = 'MONTH(customer_visit.tgl_visit) = ' . $request->efm .
                //     ' AND YEAR(customer_visit . tgl_visit) = ' . activePeriod();
                $where = 'customer_visit.bulan = ' . $request->efm .
                    ' AND customer_visit.tahun = ' . activePeriod();
                $type = 'MONTHLY';
                $filter = 'Bulan ' . Str::upper(formatMonth($request->efm)) . ', Tahun ' . activePeriod();
                break;

            case 'quarterly':
                // $where = 'QUARTER(customer_visit.tgl_visit) = ' . $request->efq .
                //     ' AND YEAR(customer_visit . tgl_visit) = ' . activePeriod();
                $where = 'customer_visit.quarter = ' . $request->efq .
                    ' AND customer_visit.tahun = ' . activePeriod();
                $type = 'QUARTERLY';
                $filter = 'Quarter ' . $request->efq . ', Tahun ' . activePeriod();
                break;

            case 'yearly':
                // $where = 'YEAR(customer_visit.tgl_visit) = ' . $request->efy;
                $where = 'customer_visit.tahun = ' . $request->efy;
                $type = 'YEARLY';
                $filter = 'Tahun ' . $request->efy;
                break;

            default:
                // $where = 'YEAR(customer_visit.tgl_visit) = ' . activePeriod();
                $where = 'customer_visit.tahun = ' . activePeriod();
                $type = '';
                $filter = 'Tahun ' . activePeriod();
                break;
        }

        $sql = "SELECT
                    sales_person.kode AS kode_sales_person,
                    sales_person.nama AS nama_sales_person,
                    sales_person.kode_store,
                    sales_person.nama_store,
                    sales_person.kota_store,
                    SUM(COALESCE(customer_visit.qty, 0)) AS total_qty,
                    SUM(COALESCE(customer_visit.nominal, 0)) AS total_nominal
                FROM
                    sales_person
                    LEFT OUTER JOIN (
                        SELECT
                            customer_visit.id_sales_person,
                            SUM(customer_visit_detail.qty) AS qty,
                            SUM(customer_visit_detail.nominal) AS nominal
                        FROM
                            customer_visit
                            LEFT OUTER JOIN customer_visit_detail ON customer_visit.id = customer_visit_detail.id_visit
                        WHERE
                            customer_visit_detail.parameter_main = 'Beli'
                            AND " . $where . "
                        GROUP BY id_sales_person
                    ) customer_visit ON sales_person.id = customer_visit.id_sales_person
                GROUP BY
                    sales_person.kode,
                    sales_person.nama,
                    sales_person.kode_store,
                    sales_person.nama_store,
                    sales_person.kota_store
                ORDER BY
                    sales_person.nama";

        // Untuk data yg tampil di tabel
        $data_table = DB::select($sql);

        // Untuk data di grafik
        $data_sales_graph = array();
        foreach ($data_table as $key) {
            $data_sales_graph[] = $key->nama_sales_person;
        }

        $data_qty_graph = array();
        foreach ($data_table as $key) {
            $data_qty_graph[] = $key->total_qty;
        }
        $data_qty_graph = array_map('intval', $data_qty_graph);

        $data_nominal_graph = array();
        foreach ($data_table as $key) {
            $data_nominal_graph[] = $key->total_nominal;
        }
        $data_nominal_graph = array_map('intval', $data_nominal_graph);

        if (empty($request->submit) || $request->submit == 'search') {
            return view('laporan.penjualan_per_person', compact(
                'data_table',
                'data_sales_graph',
                'data_qty_graph',
                'data_nominal_graph',
            ));
        } elseif ($request->submit == 'export') {
            return Excel::download(new LaporanPenjualanPerPersonExport($sql, $type, $filter), 'laporan_penjualan_per_person.xlsx');
        }
    }

    public function laporanPenjualanPerStore(Request $request)
    {
        $req = $request->f;
        $type = '';
        $filter = '';

        switch ($req) {
            case 'all':
                // $where = 'YEAR(customer_visit.tgl_visit) = ' . activePeriod();
                $where = 'customer_visit.tahun = ' . activePeriod();
                $type = 'ALL';
                $filter = 'Tahun ' . activePeriod();
                break;

            case 'daily':
                $where = 'customer_visit.tgl_visit = "' . $request->efd . '"';
                $type = 'DAILY';
                $filter = 'Tanggal ' . $request->efd;
                break;

            case 'weekly':
                // $where = 'WEEK(customer_visit.tgl_visit) = ' . $request->efw .
                //     ' AND YEAR(customer_visit . tgl_visit) = ' . activePeriod();
                $where = 'customer_visit.week = ' . $request->efw .
                    ' AND customer_visit.tahun = ' . activePeriod();
                $type = 'WEEKLY';
                $filter = 'Week ' . $request->efw . ', Tahun ' . activePeriod();
                break;

            case 'monthly':
                // $where = 'MONTH(customer_visit.tgl_visit) = ' . $request->efm .
                //     ' AND YEAR(customer_visit . tgl_visit) = ' . activePeriod();
                $where = 'customer_visit.bulan = ' . $request->efm .
                    ' AND customer_visit.tahun = ' . activePeriod();
                $type = 'MONTHLY';
                $filter = 'Bulan ' . Str::upper(formatMonth($request->efm)) . ', Tahun ' . activePeriod();
                break;

            case 'quarterly':
                // $where = 'QUARTER(customer_visit.tgl_visit) = ' . $request->efq .
                //     ' AND YEAR(customer_visit . tgl_visit) = ' . activePeriod();
                $where = 'customer_visit.quarter = ' . $request->efq .
                    ' AND customer_visit.tahun = ' . activePeriod();
                $type = 'QUARTERLY';
                $filter = 'Quarter ' . $request->efq . ', Tahun ' . activePeriod();
                break;

            case 'yearly':
                // $where = 'YEAR(customer_visit.tgl_visit) = ' . $request->efy;
                $where = 'customer_visit.tahun = ' . $request->efy;
                $type = 'YEARLY';
                $filter = 'Tahun ' . $request->efy;
                break;

            default:
                // $where = 'YEAR(customer_visit.tgl_visit) = ' . activePeriod();
                $where = 'customer_visit.tahun = ' . activePeriod();
                $type = '';
                $filter = 'Tahun ' . activePeriod();
                break;
        }

        $sql = "SELECT
                    store.id AS id_store,
                    store.kode AS kode_store,
                    store.nama AS nama_store,
                    store.kota AS kota_store,
                    SUM(COALESCE(customer_visit.qty, 0)) AS total_qty,
                    SUM(COALESCE(customer_visit.nominal, 0)) AS total_nominal
                FROM
                    store
                    LEFT OUTER JOIN (
                        SELECT
                            customer_visit.id_store,
                            SUM(customer_visit_detail.qty) AS qty,
                            SUM(customer_visit_detail.nominal) AS nominal
                        FROM
                            customer_visit
                            LEFT OUTER JOIN customer_visit_detail ON customer_visit.id = customer_visit_detail.id_visit
                        WHERE
                            customer_visit_detail.parameter_main = 'Beli'
                            AND " . $where . "
                        GROUP BY id_store
                    ) customer_visit ON store.id = customer_visit.id_store
                GROUP BY
                    store.id,
                    store.kode,
                    store.nama,
                    store.kota
                ORDER BY
                    store.nama";

        // Untuk data yg tampil di tabel
        $data_table = DB::select($sql);

        // Untuk data di grafik
        $data_store_graph = array();
        foreach ($data_table as $key) {
            $data_store_graph[] = $key->nama_store;
        }

        $data_qty_graph = array();
        foreach ($data_table as $key) {
            $data_qty_graph[] = $key->total_qty;
        }
        $data_qty_graph = array_map('intval', $data_qty_graph);

        $data_nominal_graph = array();
        foreach ($data_table as $key) {
            $data_nominal_graph[] = $key->total_nominal;
        }
        $data_nominal_graph = array_map('intval', $data_nominal_graph);

        if (empty($request->submit) || $request->submit == 'search') {
            return view('laporan.penjualan_per_store', compact(
                'data_table',
                'data_store_graph',
                'data_qty_graph',
                'data_nominal_graph',
            ));
        } elseif ($request->submit == 'export') {
            return Excel::download(new LaporanPenjualanPerStoreExport($sql, $type, $filter), 'laporan_penjualan_per_store.xlsx');
        }
    }

    public function laporanPenjualanAllStore(Request $request)
    {
        $req = $request->f;
        $type = '';
        $filter = '';

        switch ($req) {
            case 'all':
                // $where = 'YEAR(customer_visit.tgl_visit) = ' . activePeriod();
                $where = 'customer_visit.tahun = ' . activePeriod();
                $type = 'ALL';
                $filter = 'Tahun ' . activePeriod();
                break;

            case 'daily':
                $where = 'customer_visit.tgl_visit = "' . $request->efd . '"';
                $type = 'DAILY';
                $filter = 'Tanggal ' . $request->efd;
                break;

            case 'weekly':
                // $where = 'WEEK(customer_visit.tgl_visit) = ' . $request->efw .
                //     ' AND YEAR(customer_visit . tgl_visit) = ' . activePeriod();
                $where = 'customer_visit.week = ' . $request->efw .
                    ' AND customer_visit.tahun = ' . activePeriod();
                $type = 'WEEKLY';
                $filter = 'Week ' . $request->efw . ', Tahun ' . activePeriod();
                break;

            case 'monthly':
                // $where = 'MONTH(customer_visit.tgl_visit) = ' . $request->efm .
                //     ' AND YEAR(customer_visit . tgl_visit) = ' . activePeriod();
                $where = 'customer_visit.bulan = ' . $request->efm .
                    ' AND customer_visit.tahun = ' . activePeriod();
                $type = 'MONTHLY';
                $filter = 'BULAN ' . Str::upper(formatMonth($request->efm)) . ', Tahun ' . activePeriod();
                break;

            case 'quarterly':
                // $where = 'QUARTER(customer_visit.tgl_visit) = ' . $request->efq .
                //     ' AND YEAR(customer_visit . tgl_visit) = ' . activePeriod();
                $where = 'customer_visit.quarter = ' . $request->efq .
                    ' AND customer_visit.tahun = ' . activePeriod();
                $type = 'QUARTERLY';
                $filter = 'Quarter ' . $request->efq . ', Tahun ' . activePeriod();
                break;

            case 'yearly':
                // $where = 'YEAR(customer_visit.tgl_visit) = ' . $request->efy;
                $where = 'customer_visit.tahun = ' . $request->efy;
                $type = 'YEARLY';
                $filter = 'Tahun ' . $request->efy;
                break;

            default:
                // $where = 'YEAR(customer_visit.tgl_visit) = ' . activePeriod();
                $where = 'customer_visit.tahun = ' . activePeriod();
                $type = '';
                $filter = 'Tahun ' . activePeriod();
                break;
        }

        $sql = "SELECT
                    SUM(COALESCE(customer_visit_detail.qty, 0)) AS total_qty,
                    SUM(COALESCE(customer_visit_detail.nominal, 0)) AS total_nominal
                FROM
                    customer_visit
                    LEFT OUTER JOIN customer_visit_detail ON customer_visit.id = customer_visit_detail.id_visit
                WHERE
                    customer_visit_detail.parameter_main = 'Beli' AND " . $where;

        // Untuk data yg tampil di tabel
        $data_table = DB::select($sql);
        // $data_table = DB::table('customer_visit')
        //     ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
        //     ->select(DB::raw('SUM(COALESCE(customer_visit_detail.qty, 0)) AS total_qty,
        //         SUM(COALESCE(customer_visit_detail.nominal, 0)) AS total_nominal'))
        //     ->whereRaw('customer_visit_detail.parameter_main = "Beli"
        //         AND ' . $where)
        //     ->get();

        // Untuk data di grafik
        $data_store_graph = array();
        foreach ($data_table as $key) {
            $data_store_graph[] = 'All Store';
        }

        $data_qty_graph = array();
        foreach ($data_table as $key) {
            $data_qty_graph[] = $key->total_qty;
        }
        $data_qty_graph = array_map('intval', $data_qty_graph);

        $data_nominal_graph = array();
        foreach ($data_table as $key) {
            $data_nominal_graph[] = $key->total_nominal;
        }
        $data_nominal_graph = array_map('intval', $data_nominal_graph);

        if (empty($request->submit) || $request->submit == 'search') {
            return view('laporan.penjualan_all_store', compact(
                'data_table',
                'data_store_graph',
                'data_qty_graph',
                'data_nominal_graph',
            ));
        } elseif ($request->submit == 'export') {
            return Excel::download(new LaporanPenjualanAllStoreExport($sql, $type, $filter), 'laporan_penjualan_all_store.xlsx');
        }
    }
}
