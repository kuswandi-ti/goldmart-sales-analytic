<?php

namespace App\Http\Controllers;

use App\Models\Kota;
use App\Models\Store;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanKunjunganPerStoreExport;
use App\Exports\LaporanPenjualanAllStoreExport;
use App\Exports\LaporanPenjualanPerStoreExport;
use App\Exports\LaporanKunjunganPerPersonExport;
use App\Exports\LaporanPenjualanPerPersonExport;
use App\Exports\LaporanKunjunganDetailBeliExport;
use App\Exports\LaporanKunjunganDetailCobaExport;
use App\Exports\LaporanKunjunganDetailTanyaExport;
use App\Exports\LaporanKunjunganDetailDatangExport;

class LaporanController extends Controller
{
    function __construct()
    {
        $this->middleware(['permission:laporan penjualan per person'])->only(['laporanPenjualanPerPerson']);
        $this->middleware(['permission:laporan penjualan per store'])->only(['laporanPenjualanPerStore']);
        $this->middleware(['permission:laporan penjualan all store'])->only(['laporanPenjualanAllStore']);
        $this->middleware(['permission:laporan kunjungan per person'])->only(['laporanKunjunganPerPerson']);
        $this->middleware(['permission:laporan kunjungan per store'])->only(['laporanKunjunganPerStore']);
        $this->middleware(['permission:laporan kunjungan detail'])->only(['laporanKunjunganDetail']);
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

        $penjualan_hari_ini_per_person = DB::table('customer_visit')
            ->select(DB::raw('customer_visit.id_sales_person, customer_visit.kode_sales, customer_visit.nama_sales,
                    customer_visit.id_store, customer_visit.kode_store, customer_visit.nama_store, customer_visit.kota_store,
                    SUM(customer_visit_detail.qty) AS qty,
                    SUM(customer_visit_detail.nominal) AS nominal'))
            ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
            ->where('customer_visit.tgl_visit', saveDateNow())
            ->where('customer_visit_detail.parameter_main', 'Beli')
            ->groupBy([
                'customer_visit.id_sales_person',
                'customer_visit.kode_sales',
                'customer_visit.nama_sales',
                'customer_visit.id_store',
                'customer_visit.kode_store',
                'customer_visit.nama_store',
                'customer_visit.kota_store',
            ])
            ->get();

        $penjualan_bulan_ini_per_person = DB::table('customer_visit')
            ->select(DB::raw('customer_visit.id_sales_person, customer_visit.kode_sales, customer_visit.nama_sales,
                    customer_visit.id_store, customer_visit.kode_store, customer_visit.nama_store, customer_visit.kota_store,
                    SUM(customer_visit_detail.qty) AS qty,
                    SUM(customer_visit_detail.nominal) AS nominal'))
            ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
            ->whereYear('customer_visit.tgl_visit', activePeriod())
            ->whereMonth('customer_visit.tgl_visit', date('m'))
            ->where('customer_visit_detail.parameter_main', 'Beli')
            ->groupBy([
                'customer_visit.id_sales_person',
                'customer_visit.kode_sales',
                'customer_visit.nama_sales',
                'customer_visit.id_store',
                'customer_visit.kode_store',
                'customer_visit.nama_store',
                'customer_visit.kota_store',
            ])
            ->get();

        $penjualan_tahun_ini_per_person = DB::table('customer_visit')
            ->select(DB::raw('customer_visit.id_sales_person, customer_visit.kode_sales, customer_visit.nama_sales,
                    customer_visit.id_store, customer_visit.kode_store, customer_visit.nama_store, customer_visit.kota_store,
                    SUM(customer_visit_detail.qty) AS qty,
                    SUM(customer_visit_detail.nominal) AS nominal'))
            ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
            ->whereYear('customer_visit.tgl_visit', activePeriod())
            ->where('customer_visit_detail.parameter_main', 'Beli')
            ->groupBy([
                'customer_visit.id_sales_person',
                'customer_visit.kode_sales',
                'customer_visit.nama_sales',
                'customer_visit.id_store',
                'customer_visit.kode_store',
                'customer_visit.nama_store',
                'customer_visit.kota_store',
            ])
            ->get();

        if (empty($request->submit) || $request->submit == 'search') {
            return view('laporan.penjualan_per_person', compact(
                'data_table',
                'data_sales_graph',
                'data_qty_graph',
                'data_nominal_graph',
                'penjualan_hari_ini_per_person',
                'penjualan_bulan_ini_per_person',
                'penjualan_tahun_ini_per_person',
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
                WHERE
                    store.status_aktif = 1
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

        $penjualan_hari_ini_per_store = DB::table('customer_visit')
            ->select(DB::raw('customer_visit.id_store, customer_visit.kode_store, customer_visit.nama_store, customer_visit.kota_store,
                    SUM(customer_visit_detail.qty) AS qty,
                    SUM(customer_visit_detail.nominal) AS nominal'))
            ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
            ->where('customer_visit.tgl_visit', saveDateNow())
            ->where('customer_visit_detail.parameter_main', 'Beli')
            ->groupBy([
                'customer_visit.id_store',
                'customer_visit.kode_store',
                'customer_visit.nama_store',
                'customer_visit.kota_store',
            ])
            ->get();

        $penjualan_bulan_ini_per_store = DB::table('customer_visit')
            ->select(DB::raw('customer_visit.id_store, customer_visit.kode_store, customer_visit.nama_store, customer_visit.kota_store,
                    SUM(customer_visit_detail.qty) AS qty,
                    SUM(customer_visit_detail.nominal) AS nominal'))
            ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
            ->whereYear('customer_visit.tgl_visit', activePeriod())
            ->whereMonth('customer_visit.tgl_visit', date('m'))
            ->where('customer_visit_detail.parameter_main', 'Beli')
            ->groupBy([
                'customer_visit.id_store',
                'customer_visit.kode_store',
                'customer_visit.nama_store',
                'customer_visit.kota_store',
            ])
            ->get();

        $penjualan_tahun_ini_per_store = DB::table('customer_visit')
            ->select(DB::raw('customer_visit.id_store, customer_visit.kode_store, customer_visit.nama_store, customer_visit.kota_store,
                    SUM(customer_visit_detail.qty) AS qty,
                    SUM(customer_visit_detail.nominal) AS nominal'))
            ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
            ->whereYear('customer_visit.tgl_visit', activePeriod())
            ->where('customer_visit_detail.parameter_main', 'Beli')
            ->groupBy([
                'customer_visit.id_store',
                'customer_visit.kode_store',
                'customer_visit.nama_store',
                'customer_visit.kota_store',
            ])
            ->get();

        if (empty($request->submit) || $request->submit == 'search') {
            return view('laporan.penjualan_per_store', compact(
                'data_table',
                'data_store_graph',
                'data_qty_graph',
                'data_nominal_graph',
                'penjualan_hari_ini_per_store',
                'penjualan_bulan_ini_per_store',
                'penjualan_tahun_ini_per_store',
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

    public function laporanKunjunganPerPerson(Request $request)
    {
        $req = $request->f;
        $type = '';
        $filter = '';
        switch ($req) {
            case 'all':
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
                $where = 'customer_visit.week = ' . $request->efw .
                    ' AND customer_visit.tahun = ' . activePeriod();
                $type = 'WEEKLY';
                $filter = 'Week ' . $request->efw . ', Tahun ' . activePeriod();
                break;

            case 'monthly':
                $where = 'customer_visit.bulan = ' . $request->efm .
                    ' AND customer_visit.tahun = ' . activePeriod();
                $type = 'MONTHLY';
                $filter = 'Bulan ' . Str::upper(formatMonth($request->efm)) . ', Tahun ' . activePeriod();
                break;

            case 'quarterly':
                $where = 'customer_visit.quarter = ' . $request->efq .
                    ' AND customer_visit.tahun = ' . activePeriod();
                $type = 'QUARTERLY';
                $filter = 'Quarter ' . $request->efq . ', Tahun ' . activePeriod();
                break;

            case 'yearly':
                $where = 'customer_visit.tahun = ' . $request->efy;
                $type = 'YEARLY';
                $filter = 'Tahun ' . $request->efy;
                break;

            default:
                $where = 'customer_visit.tahun = ' . activePeriod();
                $type = '';
                $filter = 'Tahun ' . activePeriod();
                break;
        }

        $store = $request->store;
        if (!isset($store) || $store == 'all-store') {
            $where_store = 'sales_person.id_store IS NOT NULL';
            $nama_store = 'Semua Toko';
        } else {
            $where_store = 'sales_person.id_store = ' . $store;
            $query = Store::select('nama')
                ->where('id', $store)
                ->first();
            $nama_store =  $query['nama'];
        }

        $sql = "SELECT
                    sales_person.id AS id_sales_person,
                    sales_person.kode AS kode_sales_person,
                    sales_person.nama AS nama_sales_person,
                    sales_person.id_store,
                    store.nama AS nama_store,
                    store.kota AS kota_store,
                    SUM(COALESCE(query_2.datang, 0)) AS datang,
                    SUM(COALESCE(query_2.tanya, 0)) AS tanya,
                    SUM(COALESCE(query_2.coba, 0)) AS coba,
                    SUM(COALESCE(query_2.beli, 0)) AS beli,
	                COALESCE((SUM(COALESCE(query_2.beli, 0)) / SUM(COALESCE(query_2.coba, 0))), 0) * 100 AS persentase
                FROM
                    sales_person
                    LEFT OUTER JOIN
                    (
                    SELECT
                        query_1.id_sales_person,
                        query_1.id_store,
                        query_1.id,
                        CASE
                            WHEN query_1.parameter_main = 'Datang' THEN COUNT(query_1.parameter_main)
                            ELSE 0
                        END AS datang,
                        CASE
                            WHEN query_1.parameter_main = 'Tanya' THEN COUNT(query_1.parameter_main)
                            ELSE 0
                        END AS tanya,
                        CASE
                            WHEN query_1.parameter_main = 'Coba' THEN COUNT(query_1.parameter_main)
                            ELSE 0
                        END AS coba,
                        CASE
                            WHEN query_1.parameter_main = 'Beli' THEN COUNT(query_1.parameter_main)
                            ELSE 0
                        END AS beli
                    FROM
                        (SELECT
                            customer_visit.id_sales_person,
                            customer_visit.id_store,
                            customer_visit_detail.id,
                            customer_visit_detail.parameter_main
                        FROM
                            customer_visit
                            LEFT OUTER JOIN customer_visit_detail ON customer_visit.id = customer_visit_detail.id_visit
                        WHERE
                            " . $where . "
                            AND customer_visit_detail.parameter_main IN ('Datang', 'Tanya', 'Coba', 'Beli')
                        GROUP BY
                            customer_visit.id_sales_person,
                            customer_visit.id_store,
                            customer_visit_detail.id,
                            customer_visit_detail.parameter_main) AS query_1
                    GROUP BY
                        query_1.id_sales_person,
                        query_1.id_store,
                        query_1.id,
                        query_1.parameter_main) AS query_2 ON sales_person.id = query_2.id_sales_person
                    LEFT OUTER JOIN
                        store ON sales_person.id_store = store.id
                WHERE
                    " . $where_store . "
                GROUP BY
                    sales_person.id,
                    sales_person.kode,
                    sales_person.nama,
                    sales_person.id_store,
                    store.nama,
                    store.kota
                ORDER BY
                    store.nama,
                    sales_person.nama";

        // Untuk data yg tampil di tabel
        $data_table = DB::select($sql);

        // Untuk data di grafik
        $data_sales_graph = array();
        foreach ($data_table as $key) {
            $data_sales_graph[] = $key->nama_sales_person;
        }

        $data_datang_graph = array();
        foreach ($data_table as $key) {
            $data_datang_graph[] = $key->datang;
        }
        $data_datang_graph = array_map('intval', $data_datang_graph);

        $data_tanya_graph = array();
        foreach ($data_table as $key) {
            $data_tanya_graph[] = $key->tanya;
        }
        $data_tanya_graph = array_map('intval', $data_tanya_graph);

        $data_coba_graph = array();
        foreach ($data_table as $key) {
            $data_coba_graph[] = $key->coba;
        }
        $data_coba_graph = array_map('intval', $data_coba_graph);

        $data_beli_graph = array();
        foreach ($data_table as $key) {
            $data_beli_graph[] = $key->beli;
        }
        $data_beli_graph = array_map('intval', $data_beli_graph);

        $store = Store::active()
            ->orderBy('nama')
            ->get();

        if (empty($request->submit) || $request->submit == 'search') {
            return view('laporan.kunjungan_per_person', compact(
                'store',
                'nama_store',
                'data_table',
                'data_sales_graph',
                'data_datang_graph',
                'data_tanya_graph',
                'data_coba_graph',
                'data_beli_graph'
            ));
        } elseif ($request->submit == 'export') {
            return Excel::download(new LaporanKunjunganPerPersonExport($sql, $type, $filter, $nama_store), 'laporan_kunjungan_per_person.xlsx');
        }
    }

    public function laporanKunjunganPerStore(Request $request)
    {
        $req = $request->f;
        $type = '';
        $filter = '';
        switch ($req) {
            case 'all':
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
                $where = 'customer_visit.week = ' . $request->efw .
                    ' AND customer_visit.tahun = ' . activePeriod();
                $type = 'WEEKLY';
                $filter = 'Week ' . $request->efw . ', Tahun ' . activePeriod();
                break;

            case 'monthly':
                $where = 'customer_visit.bulan = ' . $request->efm .
                    ' AND customer_visit.tahun = ' . activePeriod();
                $type = 'MONTHLY';
                $filter = 'Bulan ' . Str::upper(formatMonth($request->efm)) . ', Tahun ' . activePeriod();
                break;

            case 'quarterly':
                $where = 'customer_visit.quarter = ' . $request->efq .
                    ' AND customer_visit.tahun = ' . activePeriod();
                $type = 'QUARTERLY';
                $filter = 'Quarter ' . $request->efq . ', Tahun ' . activePeriod();
                break;

            case 'yearly':
                $where = 'customer_visit.tahun = ' . $request->efy;
                $type = 'YEARLY';
                $filter = 'Tahun ' . $request->efy;
                break;

            default:
                $where = 'customer_visit.tahun = ' . activePeriod();
                $type = '';
                $filter = 'Tahun ' . activePeriod();
                break;
        }

        $kota = $request->kota;
        if (!isset($kota) || $kota == 'all-kota') {
            $where_kota = 'store.kota IS NOT NULL';
            $nama_kota = 'Semua Kota';
        } else {
            $where_kota = "store.kota = '" . $kota . "'";
            $nama_kota =  $kota;
        }

        $sql = "SELECT
                    store.id AS id_store,
                    store.nama AS nama_store,
                    store.kota AS kota_store,
                    SUM(COALESCE(query_2.datang, 0)) AS datang,
                    SUM(COALESCE(query_2.tanya, 0)) AS tanya,
                    SUM(COALESCE(query_2.coba, 0)) AS coba,
                    SUM(COALESCE(query_2.beli, 0)) AS beli,
                    COALESCE((SUM(COALESCE(query_2.beli, 0)) / SUM(COALESCE(query_2.coba, 0))), 0) * 100 AS persentase
                FROM
                    store
                    LEFT OUTER JOIN
                    (
                    SELECT
                        query_1.id_store,
                        query_1.id,
                        CASE
                            WHEN query_1.parameter_main = 'Datang' THEN COUNT(query_1.parameter_main)
                            ELSE 0
                        END AS datang,
                        CASE
                            WHEN query_1.parameter_main = 'Tanya' THEN COUNT(query_1.parameter_main)
                            ELSE 0
                        END AS tanya,
                        CASE
                            WHEN query_1.parameter_main = 'Coba' THEN COUNT(query_1.parameter_main)
                            ELSE 0
                        END AS coba,
                        CASE
                            WHEN query_1.parameter_main = 'Beli' THEN COUNT(query_1.parameter_main)
                            ELSE 0
                        END AS beli
                    FROM
                        (SELECT
                            customer_visit.id_store,
                            customer_visit_detail.id,
                            customer_visit_detail.parameter_main
                        FROM
                            customer_visit
                            LEFT OUTER JOIN customer_visit_detail ON customer_visit.id = customer_visit_detail.id_visit
                        WHERE
                            " . $where . "
                            AND customer_visit_detail.parameter_main IN ('Datang', 'Tanya', 'Coba', 'Beli')
                        GROUP BY
                            customer_visit.id_store,
                            customer_visit_detail.id,
                            customer_visit_detail.parameter_main) AS query_1
                    GROUP BY
                        query_1.id_store,
                        query_1.id,
                        query_1.parameter_main) AS query_2 ON store.id = query_2.id_store
                WHERE
                    " . $where_kota . "
                    AND store.status_aktif = 1
                GROUP BY
                    store.id,
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

        $data_datang_graph = array();
        foreach ($data_table as $key) {
            $data_datang_graph[] = $key->datang;
        }
        $data_datang_graph = array_map('intval', $data_datang_graph);

        $data_tanya_graph = array();
        foreach ($data_table as $key) {
            $data_tanya_graph[] = $key->tanya;
        }
        $data_tanya_graph = array_map('intval', $data_tanya_graph);

        $data_coba_graph = array();
        foreach ($data_table as $key) {
            $data_coba_graph[] = $key->coba;
        }
        $data_coba_graph = array_map('intval', $data_coba_graph);

        $data_beli_graph = array();
        foreach ($data_table as $key) {
            $data_beli_graph[] = $key->beli;
        }
        $data_beli_graph = array_map('intval', $data_beli_graph);

        $kota = Kota::orderBy('nama')->get();

        if (empty($request->submit) || $request->submit == 'search') {
            return view('laporan.kunjungan_per_store', compact(
                'kota',
                'nama_kota',
                'data_table',
                'data_store_graph',
                'data_datang_graph',
                'data_tanya_graph',
                'data_coba_graph',
                'data_beli_graph'
            ));
        } elseif ($request->submit == 'export') {
            return Excel::download(new LaporanKunjunganPerStoreExport($sql, $type, $filter, $nama_kota), 'laporan_kunjungan_per_store.xlsx');
        }
    }

    public function laporanKunjunganDetail(Request $request)
    {
        /* Datang - Start */
        $sql_datang = "SELECT
                            SUM(COALESCE(query_2.`By Buy Back`, 0)) AS By_Buy_Back,
                            SUM(COALESCE(query_2.`By Invitation`, 0)) AS By_Invitation,
                            SUM(COALESCE(query_2.`By Social Media Campaign`, 0)) AS By_Social_Media_Campaign,
                            SUM(COALESCE(query_2.`Others`, 0)) AS Others,
                            SUM(COALESCE(query_2.`Reparation`, 0)) AS Reparation,
                            SUM(COALESCE(query_2.`Walk In Customer`, 0)) AS Walk_In_Customer
                        FROM
                            (SELECT
                                CASE
                                    WHEN query_1.parameter_main = 'Datang' AND query_1.parameter_1 = 'By Buy Back' THEN COUNT(query_1.parameter_1)
                                    ELSE 0
                                END AS 'By Buy Back',
                                CASE
                                    WHEN query_1.parameter_main = 'Datang' AND query_1.parameter_1 = 'By Invitation' THEN COUNT(query_1.parameter_1)
                                    ELSE 0
                                END AS 'By Invitation',
                                CASE
                                    WHEN query_1.parameter_main = 'Datang' AND query_1.parameter_1 = 'By Social Media Campaign' THEN COUNT(query_1.parameter_1)
                                    ELSE 0
                                END AS 'By Social Media Campaign',
                                CASE
                                    WHEN query_1.parameter_main = 'Datang' AND query_1.parameter_1 = 'Others' THEN COUNT(query_1.parameter_1)
                                    ELSE 0
                                END AS 'Others',
                                CASE
                                    WHEN query_1.parameter_main = 'Datang' AND query_1.parameter_1 = 'Reparation' THEN COUNT(query_1.parameter_1)
                                    ELSE 0
                                END AS 'Reparation',
                                CASE
                                    WHEN query_1.parameter_main = 'Datang' AND query_1.parameter_1 = 'Walk In Customer' THEN COUNT(query_1.parameter_1)
                                    ELSE 0
                                END AS 'Walk In Customer'
                            FROM
                                (SELECT
                                    customer_visit_detail.id,
                                    customer_visit_detail.parameter_main,
                                    customer_visit_detail.parameter_1
                                FROM
                                    customer_visit
                                    LEFT OUTER JOIN customer_visit_detail ON customer_visit.id = customer_visit_detail.id_visit
                                WHERE
                                    customer_visit.tahun = " . activePeriod() . "
                                    AND customer_visit_detail.parameter_main IN ('Datang')
                                    AND customer_visit_detail.parameter_1 IN ('By Buy Back', 'By Invitation', 'By Social Media Campaign', 'Others', 'Reparation', 'Walk In Customer')
                                GROUP BY
                                    customer_visit_detail.id,
                                    customer_visit_detail.parameter_main,
                                    customer_visit_detail.parameter_1
                                ORDER BY
                                    customer_visit_detail.parameter_main,
                                    customer_visit_detail.parameter_1) AS query_1
                        GROUP BY
                            query_1.id,
                            query_1.parameter_main,
                            query_1.parameter_1) AS query_2";

        // Untuk data yg tampil di tabel
        $data_table_datang = DB::select($sql_datang);

        $data_datang_graph = array();
        foreach ($data_table_datang as $key) {
            $data_datang_graph[] = $key->By_Buy_Back;
            $data_datang_graph[] = $key->By_Invitation;
            $data_datang_graph[] = $key->By_Social_Media_Campaign;
            $data_datang_graph[] = $key->Others;
            $data_datang_graph[] = $key->Reparation;
            $data_datang_graph[] = $key->Walk_In_Customer;
        }
        $data_datang_graph = array_map('intval', $data_datang_graph);
        /* Datang - End */

        /* Tanya - Start */
        $sql_tanya = "SELECT
                        SUM(COALESCE(query_2.`Barang`, 0)) AS Barang,
                        SUM(COALESCE(query_2.`Buy Back`, 0)) AS Buy_Back,
                        SUM(COALESCE(query_2.`Others`, 0)) AS Others,
                        SUM(COALESCE(query_2.`Promo`, 0)) AS Promo,
                        SUM(COALESCE(query_2.`Range Harga`, 0)) AS Range_Harga,
                        SUM(COALESCE(query_2.`Reparasi`, 0)) AS Reparasi
                    FROM
                        (SELECT
                            CASE
                                WHEN query_1.parameter_main = 'Tanya' AND query_1.parameter_1 = 'Barang' THEN COUNT(query_1.parameter_1)
                                ELSE 0
                            END AS 'Barang',
                            CASE
                                WHEN query_1.parameter_main = 'Tanya' AND query_1.parameter_1 = 'Buy Back' THEN COUNT(query_1.parameter_1)
                                ELSE 0
                            END AS 'Buy Back',
                            CASE
                                WHEN query_1.parameter_main = 'Tanya' AND query_1.parameter_1 = 'Others' THEN COUNT(query_1.parameter_1)
                                ELSE 0
                            END AS 'Others',
                            CASE
                                WHEN query_1.parameter_main = 'Tanya' AND query_1.parameter_1 = 'Promo' THEN COUNT(query_1.parameter_1)
                                ELSE 0
                            END AS 'Promo',
                            CASE
                                WHEN query_1.parameter_main = 'Tanya' AND query_1.parameter_1 = 'Range Harga' THEN COUNT(query_1.parameter_1)
                                ELSE 0
                            END AS 'Range Harga',
                            CASE
                                WHEN query_1.parameter_main = 'Tanya' AND query_1.parameter_1 = 'Reparasi' THEN COUNT(query_1.parameter_1)
                                ELSE 0
                            END AS 'Reparasi'
                        FROM
                            (SELECT
                                customer_visit_detail.id,
                                customer_visit_detail.parameter_main,
                                customer_visit_detail.parameter_1
                            FROM
                                customer_visit
                                LEFT OUTER JOIN customer_visit_detail ON customer_visit.id = customer_visit_detail.id_visit
                            WHERE
                                customer_visit.tahun = " . activePeriod() . "
                                AND customer_visit_detail.parameter_main IN ('Tanya')
                                AND customer_visit_detail.parameter_1 IN ('Barang', 'Buy Back', 'Others', 'Promo', 'Range Harga', 'Reparasi')
                            GROUP BY
                                customer_visit_detail.id,
                                customer_visit_detail.parameter_main,
                                customer_visit_detail.parameter_1
                            ORDER BY
                                customer_visit_detail.parameter_main,
                                customer_visit_detail.parameter_1) AS query_1
                    GROUP BY
                        query_1.id,
                        query_1.parameter_main,
                        query_1.parameter_1) AS query_2";

        // Untuk data yg tampil di tabel
        $data_table_tanya = DB::select($sql_tanya);

        $data_tanya_graph = array();
        foreach ($data_table_tanya as $key) {
            $data_tanya_graph[] = $key->Barang;
            $data_tanya_graph[] = $key->Buy_Back;
            $data_tanya_graph[] = $key->Others;
            $data_tanya_graph[] = $key->Promo;
            $data_tanya_graph[] = $key->Range_Harga;
            $data_tanya_graph[] = $key->Reparasi;
        }
        $data_tanya_graph = array_map('intval', $data_tanya_graph);
        /* Tanya - End */

        /* Coba Goldmart - Start */
        $sql_coba_goldmart = "SELECT
                                SUM(COALESCE(query_2.`Bracelet`, 0)) AS Bracelet,
                                SUM(COALESCE(query_2.`Earring`, 0)) AS Earring,
                                SUM(COALESCE(query_2.`Necklace`, 0)) AS Necklace,
                                SUM(COALESCE(query_2.`Pendant`, 0)) AS Pendant,
                                SUM(COALESCE(query_2.`Ring`, 0)) AS Ring
                            FROM
                                (SELECT
                                    CASE
                                        WHEN query_1.parameter_main = 'Coba' AND query_1.parameter_1 = 'Goldmart' AND query_1.parameter_2 = 'Bracelet' THEN COUNT(query_1.parameter_2)
                                        ELSE 0
                                    END AS 'Bracelet',
                                    CASE
                                        WHEN query_1.parameter_main = 'Coba' AND query_1.parameter_1 = 'Goldmart' AND query_1.parameter_2 = 'Earring' THEN COUNT(query_1.parameter_2)
                                        ELSE 0
                                    END AS 'Earring',
                                    CASE
                                        WHEN query_1.parameter_main = 'Coba' AND query_1.parameter_1 = 'Goldmart' AND query_1.parameter_2 = 'Necklace' THEN COUNT(query_1.parameter_2)
                                        ELSE 0
                                    END AS 'Necklace',
                                    CASE
                                        WHEN query_1.parameter_main = 'Coba' AND query_1.parameter_1 = 'Goldmart' AND query_1.parameter_2 = 'Pendant' THEN COUNT(query_1.parameter_2)
                                        ELSE 0
                                    END AS 'Pendant',
                                    CASE
                                        WHEN query_1.parameter_main = 'Coba' AND query_1.parameter_1 = 'Goldmart' AND query_1.parameter_2 = 'Ring' THEN COUNT(query_1.parameter_2)
                                        ELSE 0
                                    END AS 'Ring'
                                FROM
                                    (SELECT
                                        customer_visit_detail.id,
                                        customer_visit_detail.parameter_main,
                                        customer_visit_detail.parameter_1,
                                        customer_visit_detail.parameter_2
                                    FROM
                                        customer_visit
                                        LEFT OUTER JOIN customer_visit_detail ON customer_visit.id = customer_visit_detail.id_visit
                                    WHERE
                                        customer_visit.tahun = " . activePeriod() . "
                                        AND customer_visit_detail.parameter_main IN ('Coba')
                                        AND customer_visit_detail.parameter_1 IN ('Goldmart')
                                        AND customer_visit_detail.parameter_2 IN ('Bracelet', 'Earring', 'Necklace', 'Pendant', 'Ring')
                                    GROUP BY
                                        customer_visit_detail.id,
                                        customer_visit_detail.parameter_main,
                                        customer_visit_detail.parameter_1,
                                        customer_visit_detail.parameter_2
                                    ORDER BY
                                        customer_visit_detail.parameter_main,
                                        customer_visit_detail.parameter_1,
                                        customer_visit_detail.parameter_2) AS query_1
                            GROUP BY
                                query_1.id,
                                query_1.parameter_main,
                                query_1.parameter_1,
                                query_1.parameter_2) AS query_2";

        // Untuk data yg tampil di tabel
        $data_table_coba_goldmart = DB::select($sql_coba_goldmart);

        $data_coba_goldmart_graph = array();
        foreach ($data_table_coba_goldmart as $key) {
            $data_coba_goldmart_graph[] = $key->Bracelet;
            $data_coba_goldmart_graph[] = $key->Earring;
            $data_coba_goldmart_graph[] = $key->Necklace;
            $data_coba_goldmart_graph[] = $key->Pendant;
            $data_coba_goldmart_graph[] = $key->Ring;
        }
        $data_coba_goldmart_graph = array_map('intval', $data_coba_goldmart_graph);
        /* Coba Goldmart - End */

        /* Coba Goldmaster - Start */
        $sql_coba_goldmaster = "SELECT
                                    SUM(COALESCE(query_2.`Bangle`, 0)) AS Bangle,
                                    SUM(COALESCE(query_2.`Bracelet`, 0)) AS Bracelet,
                                    SUM(COALESCE(query_2.`Brooch`, 0)) AS Brooch,
                                    SUM(COALESCE(query_2.`Charm`, 0)) AS Charm,
                                    SUM(COALESCE(query_2.`Collier`, 0)) AS Collier,
                                    SUM(COALESCE(query_2.`Earring`, 0)) AS Earring,
                                    SUM(COALESCE(query_2.`Necklace`, 0)) AS Necklace,
                                    SUM(COALESCE(query_2.`Pendant`, 0)) AS Pendant,
                                    SUM(COALESCE(query_2.`Ring`, 0)) AS Ring,
                                    SUM(COALESCE(query_2.`Tietack`, 0)) AS Tietack
                                FROM
                                    (SELECT
                                        CASE
                                            WHEN query_1.parameter_main = 'Coba' AND query_1.parameter_1 = 'Goldmaster' AND query_1.parameter_2 = 'Bangle' THEN COUNT(query_1.parameter_2)
                                            ELSE 0
                                        END AS 'Bangle',
                                        CASE
                                            WHEN query_1.parameter_main = 'Coba' AND query_1.parameter_1 = 'Goldmaster' AND query_1.parameter_2 = 'Bracelet' THEN COUNT(query_1.parameter_2)
                                            ELSE 0
                                        END AS 'Bracelet',
                                        CASE
                                            WHEN query_1.parameter_main = 'Coba' AND query_1.parameter_1 = 'Goldmaster' AND query_1.parameter_2 = 'Brooch' THEN COUNT(query_1.parameter_2)
                                            ELSE 0
                                        END AS 'Brooch',
                                        CASE
                                            WHEN query_1.parameter_main = 'Coba' AND query_1.parameter_1 = 'Goldmaster' AND query_1.parameter_2 = 'Charm' THEN COUNT(query_1.parameter_2)
                                            ELSE 0
                                        END AS 'Charm',
                                        CASE
                                            WHEN query_1.parameter_main = 'Coba' AND query_1.parameter_1 = 'Goldmaster' AND query_1.parameter_2 = 'Collier' THEN COUNT(query_1.parameter_2)
                                            ELSE 0
                                        END AS 'Collier',
                                        CASE
                                            WHEN query_1.parameter_main = 'Coba' AND query_1.parameter_1 = 'Goldmaster' AND query_1.parameter_2 = 'Earring' THEN COUNT(query_1.parameter_2)
                                            ELSE 0
                                        END AS 'Earring',
                                        CASE
                                            WHEN query_1.parameter_main = 'Coba' AND query_1.parameter_1 = 'Goldmaster' AND query_1.parameter_2 = 'Necklace' THEN COUNT(query_1.parameter_2)
                                            ELSE 0
                                        END AS 'Necklace',
                                        CASE
                                            WHEN query_1.parameter_main = 'Coba' AND query_1.parameter_1 = 'Goldmaster' AND query_1.parameter_2 = 'Pendant' THEN COUNT(query_1.parameter_2)
                                            ELSE 0
                                        END AS 'Pendant',
                                        CASE
                                            WHEN query_1.parameter_main = 'Coba' AND query_1.parameter_1 = 'Goldmaster' AND query_1.parameter_2 = 'Ring' THEN COUNT(query_1.parameter_2)
                                            ELSE 0
                                        END AS 'Ring',
                                        CASE
                                            WHEN query_1.parameter_main = 'Coba' AND query_1.parameter_1 = 'Goldmaster' AND query_1.parameter_2 = 'Tietack' THEN COUNT(query_1.parameter_2)
                                            ELSE 0
                                        END AS 'Tietack'
                                    FROM
                                        (SELECT
                                            customer_visit_detail.id,
                                            customer_visit_detail.parameter_main,
                                            customer_visit_detail.parameter_1,
                                            customer_visit_detail.parameter_2
                                        FROM
                                            customer_visit
                                            LEFT OUTER JOIN customer_visit_detail ON customer_visit.id = customer_visit_detail.id_visit
                                        WHERE
                                            customer_visit.tahun = " . activePeriod() . "
                                            AND customer_visit_detail.parameter_main IN ('Coba')
                                            AND customer_visit_detail.parameter_1 IN ('Goldmaster')
                                            AND customer_visit_detail.parameter_2 IN ('Bangle', 'Bracelet', 'Brooch', 'Charm', 'Collier', 'Earring', 'Necklace', 'Pendant', 'Ring', 'Tietack')
                                        GROUP BY
                                            customer_visit_detail.id,
                                            customer_visit_detail.parameter_main,
                                            customer_visit_detail.parameter_1,
                                            customer_visit_detail.parameter_2
                                        ORDER BY
                                            customer_visit_detail.parameter_main,
                                            customer_visit_detail.parameter_1,
                                            customer_visit_detail.parameter_2) AS query_1
                                GROUP BY
                                    query_1.id,
                                    query_1.parameter_main,
                                    query_1.parameter_1,
                                    query_1.parameter_2) AS query_2";

        // Untuk data yg tampil di tabel
        $data_table_coba_goldmaster = DB::select($sql_coba_goldmaster);

        $data_coba_goldmaster_graph = array();
        foreach ($data_table_coba_goldmaster as $key) {
            $data_coba_goldmaster_graph[] = $key->Bangle;
            $data_coba_goldmaster_graph[] = $key->Bracelet;
            $data_coba_goldmaster_graph[] = $key->Brooch;
            $data_coba_goldmaster_graph[] = $key->Charm;
            $data_coba_goldmaster_graph[] = $key->Collier;
            $data_coba_goldmaster_graph[] = $key->Earring;
            $data_coba_goldmaster_graph[] = $key->Necklace;
            $data_coba_goldmaster_graph[] = $key->Pendant;
            $data_coba_goldmaster_graph[] = $key->Ring;
            $data_coba_goldmaster_graph[] = $key->Tietack;
        }
        $data_coba_goldmaster_graph = array_map('intval', $data_coba_goldmaster_graph);
        /* Coba Goldmaster - End */

        /* Beli Goldmart - Start */
        $sql_beli_goldmart = "SELECT
                                SUM(COALESCE(query_2.`Bracelet`, 0)) AS Bracelet,
                                SUM(COALESCE(query_2.`Earring`, 0)) AS Earring,
                                SUM(COALESCE(query_2.`Necklace`, 0)) AS Necklace,
                                SUM(COALESCE(query_2.`Pendant`, 0)) AS Pendant,
                                SUM(COALESCE(query_2.`Ring`, 0)) AS Ring
                            FROM
                                (SELECT
                                    CASE
                                        WHEN query_1.parameter_main = 'Beli' AND query_1.parameter_1 = 'Goldmart' AND query_1.parameter_2 = 'Bracelet' THEN COUNT(query_1.parameter_2)
                                        ELSE 0
                                    END AS 'Bracelet',
                                    CASE
                                        WHEN query_1.parameter_main = 'Beli' AND query_1.parameter_1 = 'Goldmart' AND query_1.parameter_2 = 'Earring' THEN COUNT(query_1.parameter_2)
                                        ELSE 0
                                    END AS 'Earring',
                                    CASE
                                        WHEN query_1.parameter_main = 'Beli' AND query_1.parameter_1 = 'Goldmart' AND query_1.parameter_2 = 'Necklace' THEN COUNT(query_1.parameter_2)
                                        ELSE 0
                                    END AS 'Necklace',
                                    CASE
                                        WHEN query_1.parameter_main = 'Beli' AND query_1.parameter_1 = 'Goldmart' AND query_1.parameter_2 = 'Pendant' THEN COUNT(query_1.parameter_2)
                                        ELSE 0
                                    END AS 'Pendant',
                                    CASE
                                        WHEN query_1.parameter_main = 'Beli' AND query_1.parameter_1 = 'Goldmart' AND query_1.parameter_2 = 'Ring' THEN COUNT(query_1.parameter_2)
                                        ELSE 0
                                    END AS 'Ring'
                                FROM
                                    (SELECT
                                        customer_visit_detail.id,
                                        customer_visit_detail.parameter_main,
                                        customer_visit_detail.parameter_1,
                                        customer_visit_detail.parameter_2
                                    FROM
                                        customer_visit
                                        LEFT OUTER JOIN customer_visit_detail ON customer_visit.id = customer_visit_detail.id_visit
                                    WHERE
                                        customer_visit.tahun = " . activePeriod() . "
                                        AND customer_visit_detail.parameter_main IN ('Beli')
                                        AND customer_visit_detail.parameter_1 IN ('Goldmart')
                                        AND customer_visit_detail.parameter_2 IN ('Bracelet', 'Earring', 'Necklace', 'Pendant', 'Ring')
                                    GROUP BY
                                        customer_visit_detail.id,
                                        customer_visit_detail.parameter_main,
                                        customer_visit_detail.parameter_1,
                                        customer_visit_detail.parameter_2
                                    ORDER BY
                                        customer_visit_detail.parameter_main,
                                        customer_visit_detail.parameter_1,
                                        customer_visit_detail.parameter_2) AS query_1
                            GROUP BY
                                query_1.id,
                                query_1.parameter_main,
                                query_1.parameter_1,
                                query_1.parameter_2) AS query_2";

        // Untuk data yg tampil di tabel
        $data_table_beli_goldmart = DB::select($sql_beli_goldmart);

        $data_beli_goldmart_graph = array();
        foreach ($data_table_beli_goldmart as $key) {
            $data_beli_goldmart_graph[] = $key->Bracelet;
            $data_beli_goldmart_graph[] = $key->Earring;
            $data_beli_goldmart_graph[] = $key->Necklace;
            $data_beli_goldmart_graph[] = $key->Pendant;
            $data_beli_goldmart_graph[] = $key->Ring;
        }
        $data_beli_goldmart_graph = array_map('intval', $data_beli_goldmart_graph);
        /* Beli Goldmart - End */

        /* Beli Goldmaster - Start */
        $sql_beli_goldmaster = "SELECT
                                    SUM(COALESCE(query_2.`Bangle`, 0)) AS Bangle,
                                    SUM(COALESCE(query_2.`Bracelet`, 0)) AS Bracelet,
                                    SUM(COALESCE(query_2.`Brooch`, 0)) AS Brooch,
                                    SUM(COALESCE(query_2.`Charm`, 0)) AS Charm,
                                    SUM(COALESCE(query_2.`Collier`, 0)) AS Collier,
                                    SUM(COALESCE(query_2.`Earring`, 0)) AS Earring,
                                    SUM(COALESCE(query_2.`Necklace`, 0)) AS Necklace,
                                    SUM(COALESCE(query_2.`Pendant`, 0)) AS Pendant,
                                    SUM(COALESCE(query_2.`Ring`, 0)) AS Ring,
                                    SUM(COALESCE(query_2.`Tietack`, 0)) AS Tietack
                                FROM
                                    (SELECT
                                        CASE
                                            WHEN query_1.parameter_main = 'Beli' AND query_1.parameter_1 = 'Goldmaster' AND query_1.parameter_2 = 'Bangle' THEN COUNT(query_1.parameter_2)
                                            ELSE 0
                                        END AS 'Bangle',
                                        CASE
                                            WHEN query_1.parameter_main = 'Beli' AND query_1.parameter_1 = 'Goldmaster' AND query_1.parameter_2 = 'Bracelet' THEN COUNT(query_1.parameter_2)
                                            ELSE 0
                                        END AS 'Bracelet',
                                        CASE
                                            WHEN query_1.parameter_main = 'Beli' AND query_1.parameter_1 = 'Goldmaster' AND query_1.parameter_2 = 'Brooch' THEN COUNT(query_1.parameter_2)
                                            ELSE 0
                                        END AS 'Brooch',
                                        CASE
                                            WHEN query_1.parameter_main = 'Beli' AND query_1.parameter_1 = 'Goldmaster' AND query_1.parameter_2 = 'Charm' THEN COUNT(query_1.parameter_2)
                                            ELSE 0
                                        END AS 'Charm',
                                        CASE
                                            WHEN query_1.parameter_main = 'Beli' AND query_1.parameter_1 = 'Goldmaster' AND query_1.parameter_2 = 'Collier' THEN COUNT(query_1.parameter_2)
                                            ELSE 0
                                        END AS 'Collier',
                                        CASE
                                            WHEN query_1.parameter_main = 'Beli' AND query_1.parameter_1 = 'Goldmaster' AND query_1.parameter_2 = 'Earring' THEN COUNT(query_1.parameter_2)
                                            ELSE 0
                                        END AS 'Earring',
                                        CASE
                                            WHEN query_1.parameter_main = 'Beli' AND query_1.parameter_1 = 'Goldmaster' AND query_1.parameter_2 = 'Necklace' THEN COUNT(query_1.parameter_2)
                                            ELSE 0
                                        END AS 'Necklace',
                                        CASE
                                            WHEN query_1.parameter_main = 'Beli' AND query_1.parameter_1 = 'Goldmaster' AND query_1.parameter_2 = 'Pendant' THEN COUNT(query_1.parameter_2)
                                            ELSE 0
                                        END AS 'Pendant',
                                        CASE
                                            WHEN query_1.parameter_main = 'Beli' AND query_1.parameter_1 = 'Goldmaster' AND query_1.parameter_2 = 'Ring' THEN COUNT(query_1.parameter_2)
                                            ELSE 0
                                        END AS 'Ring',
                                        CASE
                                            WHEN query_1.parameter_main = 'Beli' AND query_1.parameter_1 = 'Goldmaster' AND query_1.parameter_2 = 'Tietack' THEN COUNT(query_1.parameter_2)
                                            ELSE 0
                                        END AS 'Tietack'
                                    FROM
                                        (SELECT
                                            customer_visit_detail.id,
                                            customer_visit_detail.parameter_main,
                                            customer_visit_detail.parameter_1,
                                            customer_visit_detail.parameter_2
                                        FROM
                                            customer_visit
                                            LEFT OUTER JOIN customer_visit_detail ON customer_visit.id = customer_visit_detail.id_visit
                                        WHERE
                                            customer_visit.tahun = " . activePeriod() . "
                                            AND customer_visit_detail.parameter_main IN ('Beli')
                                            AND customer_visit_detail.parameter_1 IN ('Goldmaster')
                                            AND customer_visit_detail.parameter_2 IN ('Bangle', 'Bracelet', 'Brooch', 'Charm', 'Collier', 'Earring', 'Necklace', 'Pendant', 'Ring', 'Tietack')
                                        GROUP BY
                                            customer_visit_detail.id,
                                            customer_visit_detail.parameter_main,
                                            customer_visit_detail.parameter_1,
                                            customer_visit_detail.parameter_2
                                        ORDER BY
                                            customer_visit_detail.parameter_main,
                                            customer_visit_detail.parameter_1,
                                            customer_visit_detail.parameter_2) AS query_1
                                GROUP BY
                                    query_1.id,
                                    query_1.parameter_main,
                                    query_1.parameter_1,
                                    query_1.parameter_2) AS query_2";

        // Untuk data yg tampil di tabel
        $data_table_beli_goldmaster = DB::select($sql_beli_goldmaster);

        $data_beli_goldmaster_graph = array();
        foreach ($data_table_beli_goldmaster as $key) {
            $data_beli_goldmaster_graph[] = $key->Bangle;
            $data_beli_goldmaster_graph[] = $key->Bracelet;
            $data_beli_goldmaster_graph[] = $key->Brooch;
            $data_beli_goldmaster_graph[] = $key->Charm;
            $data_beli_goldmaster_graph[] = $key->Collier;
            $data_beli_goldmaster_graph[] = $key->Earring;
            $data_beli_goldmaster_graph[] = $key->Necklace;
            $data_beli_goldmaster_graph[] = $key->Pendant;
            $data_beli_goldmaster_graph[] = $key->Ring;
            $data_beli_goldmaster_graph[] = $key->Tietack;
        }
        $data_beli_goldmaster_graph = array_map('intval', $data_beli_goldmaster_graph);
        /* Beli Goldmaster - End */

        if ($request->submit == 'export-datang') {
            return Excel::download(new LaporanKunjunganDetailDatangExport($sql_datang), 'laporan_kunjungan_detail_datang.xlsx');
        } elseif ($request->submit == 'export-tanya') {
            return Excel::download(new LaporanKunjunganDetailTanyaExport($sql_tanya), 'laporan_kunjungan_detail_tanya.xlsx');
        } elseif ($request->submit == 'export-coba') {
            return Excel::download(new LaporanKunjunganDetailCobaExport($sql_coba_goldmart, $sql_coba_goldmaster), 'laporan_kunjungan_detail_coba.xlsx');
        } elseif ($request->submit == 'export-beli') {
            return Excel::download(new LaporanKunjunganDetailBeliExport($sql_beli_goldmart, $sql_beli_goldmaster), 'laporan_kunjungan_detail_beli.xlsx');
        } else {
            return view('laporan.kunjungan_detail', compact(
                'data_table_datang',
                'data_datang_graph',
                'data_table_tanya',
                'data_tanya_graph',
                'data_table_coba_goldmart',
                'data_coba_goldmart_graph',
                'data_table_coba_goldmaster',
                'data_coba_goldmaster_graph',
                'data_table_beli_goldmart',
                'data_beli_goldmart_graph',
                'data_table_beli_goldmaster',
                'data_beli_goldmaster_graph',
            ));
        }
    }
}
