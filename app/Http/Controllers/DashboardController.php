<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    function queryKunjungan($parameter_main, $id_store = '')
    {
        if ($id_store == '') {
            $sql = "SELECT
                    store.id AS id_store,
                    store.nama AS nama_store,
                    COALESCE(query_2.jml, 0) AS jml
                FROM
                    store
                    LEFT OUTER JOIN
                    (
                    SELECT
                    query_1.id_store,
                    COUNT(query_1.parameter_main) AS jml
                    FROM
                    (SELECT
                        customer_visit.id_store,
                        customer_visit_detail.parameter_main
                    FROM
                        customer_visit
                        LEFT OUTER JOIN customer_visit_detail ON customer_visit.id = customer_visit_detail.id_visit
                    WHERE
                        YEAR(customer_visit.tgl_visit) = " . activePeriod() . "
                        AND customer_visit_detail.parameter_main = '" . $parameter_main . "'
                    GROUP BY
                        customer_visit.id,
                        customer_visit_detail.parameter_main) AS query_1
                    GROUP BY
                        query_1.id_store) AS query_2 ON store.id = query_2.id_store
                ORDER BY
                    store.nama";
        } else {
            $sql = "SELECT
                    store.id AS id_store,
                    store.nama AS nama_store,
                    COALESCE(query_2.jml, 0) AS jml
                FROM
                    store
                    LEFT OUTER JOIN
                    (
                    SELECT
                    query_1.id_store,
                    COUNT(query_1.parameter_main) AS jml
                    FROM
                    (SELECT
                        customer_visit.id_store,
                        customer_visit_detail.parameter_main
                    FROM
                        customer_visit
                        LEFT OUTER JOIN customer_visit_detail ON customer_visit.id = customer_visit_detail.id_visit
                    WHERE
                        YEAR(customer_visit.tgl_visit) = " . activePeriod() . "
                        AND customer_visit_detail.parameter_main = '" . $parameter_main . "'
                    GROUP BY
                        customer_visit.id,
                        customer_visit_detail.parameter_main) AS query_1
                    GROUP BY
                        query_1.id_store) AS query_2 ON store.id = query_2.id_store
                WHERE
                    store.id = " . getSession(3) . "
                ORDER BY
                    store.nama";
        }

        return $sql;
    }

    public function index()
    {
        if (auth()->user()->can('dashboard gsa')) {
            /* Widget - Start */
            $total_sales_value = DB::table('customer_visit')
                ->select(DB::raw('SUM(customer_visit_detail.nominal) as total_sales_value'))
                ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
                ->whereYear('customer_visit.tgl_visit', activePeriod())
                ->where('customer_visit_detail.parameter_main', 'Beli')
                ->first();

            $total_sales_pcs = DB::table('customer_visit')
                ->select(DB::raw('SUM(customer_visit_detail.qty) as total_sales_pcs'))
                ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
                ->whereYear('customer_visit.tgl_visit', activePeriod())
                ->where('customer_visit_detail.parameter_main', 'Beli')
                ->first();

            $total_customer_datang = DB::table('customer_visit_detail')
                ->select(DB::raw('customer_visit_detail.id_visit, customer_visit_detail.parameter_main'))
                ->leftJoin('customer_visit', 'customer_visit_detail.id_visit', '=', 'customer_visit.id')
                ->whereYear('customer_visit.tgl_visit', activePeriod())
                ->where('customer_visit_detail.parameter_main', 'Datang')
                ->groupBy(['customer_visit_detail.id_visit', 'customer_visit_detail.parameter_main'])
                ->get();

            $total_customer_tanya = DB::table('customer_visit_detail')
                ->select(DB::raw('customer_visit_detail.id_visit, customer_visit_detail.parameter_main'))
                ->leftJoin('customer_visit', 'customer_visit_detail.id_visit', '=', 'customer_visit.id')
                ->whereYear('customer_visit.tgl_visit', activePeriod())
                ->where('customer_visit_detail.parameter_main', 'Tanya')
                ->groupBy(['customer_visit_detail.id_visit', 'customer_visit_detail.parameter_main'])
                ->get();

            $total_customer_coba = DB::table('customer_visit_detail')
                ->select(DB::raw('customer_visit_detail.id_visit, customer_visit_detail.parameter_main'))
                ->leftJoin('customer_visit', 'customer_visit_detail.id_visit', '=', 'customer_visit.id')
                ->whereYear('customer_visit.tgl_visit', activePeriod())
                ->where('customer_visit_detail.parameter_main', 'Coba')
                ->groupBy(['customer_visit_detail.id_visit', 'customer_visit_detail.parameter_main'])
                ->get();

            $total_customer_beli = DB::table('customer_visit_detail')
                ->select(DB::raw('customer_visit_detail.id_visit, customer_visit_detail.parameter_main'))
                ->leftJoin('customer_visit', 'customer_visit_detail.id_visit', '=', 'customer_visit.id')
                ->whereYear('customer_visit.tgl_visit', activePeriod())
                ->where('customer_visit_detail.parameter_main', 'Beli')
                ->groupBy(['customer_visit_detail.id_visit', 'customer_visit_detail.parameter_main'])
                ->get();
            /* Widget - End */

            // $total_customer_visit = DB::table('customer_visit')
            //     ->select(DB::raw('COUNT(no_dokumen) as total_customer_visit'))
            //     ->whereYear('tgl_visit', activePeriod())
            //     ->first();

            // $total_customer_beli = DB::table('customer_visit')
            //     ->select(DB::raw('COUNT(customer_visit.no_dokumen) as total_customer_beli'))
            //     ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
            //     ->whereYear('customer_visit.tgl_visit', activePeriod())
            //     ->where('customer_visit_detail.parameter_main', 'Beli')
            //     ->first();
            /* Widget - End */

            /* Grafik 1 - Start */
            $sql = "SELECT nama FROM store WHERE status_aktif = 1 ORDER BY nama";
            $data_store = DB::select($sql);
            $data_store_graph = array();
            foreach ($data_store as $key) {
                $data_store_graph[] = $key->nama;
            }

            // Datang
            $sql = $this->queryKunjungan('Datang', '');
            $data_datang = DB::select($sql);
            $total_datang_graph = array();
            foreach ($data_datang as $key) {
                $total_datang_graph[] = $key->jml;
            }
            $total_datang_graph = array_map('intval', $total_datang_graph);

            // Tanya
            $sql = $this->queryKunjungan('Tanya', '');
            $data_tanya = DB::select($sql);
            $total_tanya_graph = array();
            foreach ($data_tanya as $key) {
                $total_tanya_graph[] = $key->jml;
            }
            $total_tanya_graph = array_map('intval', $total_tanya_graph);

            // Coba
            $sql = $this->queryKunjungan('Coba', '');
            $data_coba = DB::select($sql);
            $total_coba_graph = array();
            foreach ($data_coba as $key) {
                $total_coba_graph[] = $key->jml;
            }
            $total_coba_graph = array_map('intval', $total_coba_graph);

            // Beli
            $sql = $this->queryKunjungan('Beli', '');
            $data_beli = DB::select($sql);
            $total_beli_graph = array();
            foreach ($data_beli as $key) {
                $total_beli_graph[] = $key->jml;
            }
            $total_beli_graph = array_map('intval', $total_beli_graph);
            /* Grafik 1 - End */

            /* Grafik 2 - Start */
            // Goldmart
            $total_nominal_goldmart = array();
            for ($i = 0; $i < 12; $i++) {
                $total_nominal_goldmart[] = DB::table('customer_visit')
                    ->select(DB::raw('SUM(customer_visit_detail.nominal) AS total_goldmart'))
                    ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
                    ->where('customer_visit.tahun', activePeriod())
                    ->where('customer_visit.bulan', $i + 1)
                    ->where('customer_visit_detail.parameter_main', 'Beli')
                    ->where('customer_visit_detail.parameter_1', 'Goldmart')
                    ->pluck('total_goldmart')
                    ->first();
            }
            $total_nominal_goldmart_graph = array_map('intval', $total_nominal_goldmart);

            // Goldmaster
            $total_nominal_goldmaster = array();
            for ($i = 0; $i < 12; $i++) {
                $total_nominal_goldmaster[] = DB::table('customer_visit')
                    ->select(DB::raw('SUM(customer_visit_detail.nominal) AS total_goldmaster'))
                    ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
                    ->where('customer_visit.tahun', activePeriod())
                    ->where('customer_visit.bulan', $i + 1)
                    ->where('customer_visit_detail.parameter_main', 'Beli')
                    ->where('customer_visit_detail.parameter_1', 'Goldmaster')
                    ->pluck('total_goldmaster')
                    ->first();
            }
            $total_nominal_goldmaster_graph = array_map('intval', $total_nominal_goldmaster);
            /* Grafik 2 - End */

            /* Tabel 1 - Start */
            $sql = "SELECT
                        store.id AS id_store,
                        store.nama AS nama_store,
                        SUM(COALESCE(query_2.datang, 0)) AS datang,
                        SUM(COALESCE(query_2.tanya, 0)) AS tanya,
                        SUM(COALESCE(query_2.coba, 0)) AS coba,
                        SUM(COALESCE(query_2.beli, 0)) AS beli
                    FROM
                        store
                        LEFT OUTER JOIN
                        (
                        SELECT
                        query_1.id_store,
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
                            customer_visit_detail.parameter_main
                        FROM
                            customer_visit
                            LEFT OUTER JOIN customer_visit_detail ON customer_visit.id = customer_visit_detail.id_visit
                        WHERE
                            YEAR(customer_visit.tgl_visit) = 2025
                            AND customer_visit_detail.parameter_main IN ('Datang', 'Tanya', 'Coba', 'Beli')
                        GROUP BY
                            customer_visit.id,
                            customer_visit_detail.parameter_main) AS query_1
                        GROUP BY
                            query_1.id_store,
                            query_1.parameter_main) AS query_2 ON store.id = query_2.id_store
                    GROUP BY
                        store.id,
                        store.nama
                    ORDER BY
                        store.nama";
            $data_kunjungan = DB::select($sql);
            /* Tabel 1 - End */


            // $total_lihat = array();
            // for ($i = 0; $i < 12; $i++) {
            //     $total_lihat[] = DB::table('customer_visit')
            //         ->select(DB::raw('COUNT(no_dokumen) AS total_lihat'))
            //         ->where('tahun', activePeriod())
            //         ->where('bulan', $i + 1)
            //         ->where('parameter_1', 'Lihat')
            //         ->pluck('total_lihat')
            //         ->first();
            // }
            // $total_lihat_graph = array_map('intval', $total_lihat);

            // $total_tanya = array();
            // for ($i = 0; $i < 12; $i++) {
            //     $total_tanya[] = DB::table('customer_visit')
            //         ->select(DB::raw('COUNT(no_dokumen) AS total_tanya'))
            //         ->where('tahun', activePeriod())
            //         ->where('bulan', $i + 1)
            //         ->where('parameter_1', 'Tanya')
            //         ->pluck('total_tanya')
            //         ->first();
            // }
            // $total_tanya_graph = array_map('intval', $total_tanya);

            // $total_coba = array();
            // for ($i = 0; $i < 12; $i++) {
            //     $total_coba[] = DB::table('customer_visit')
            //         ->select(DB::raw('COUNT(no_dokumen) AS total_coba'))
            //         ->where('tahun', activePeriod())
            //         ->where('bulan', $i + 1)
            //         ->where('parameter_1', 'Coba')
            //         ->pluck('total_coba')
            //         ->first();
            // }
            // $total_coba_graph = array_map('intval', $total_coba);

            // $total_beli = array();
            // for ($i = 0; $i < 12; $i++) {
            //     $total_beli[] = DB::table('customer_visit')
            //         ->select(DB::raw('COUNT(no_dokumen) AS total_beli'))
            //         ->where('tahun', activePeriod())
            //         ->where('bulan', $i + 1)
            //         ->where('parameter_1', 'Beli')
            //         ->pluck('total_beli')
            //         ->first();
            // }
            // $total_beli_graph = array_map('intval', $total_beli);
            /* Grafik 1 - End */

            // /* Table - per Hari - Start */
            // $penjualan_hari_ini_per_tipe_barang = DB::table('customer_visit')
            //     ->select(DB::raw('customer_visit_detail.parameter_1,
            //         customer_visit_detail.parameter_2,
            //         SUM(customer_visit_detail.qty) AS qty,
            //         SUM(customer_visit_detail.nominal) AS nominal'))
            //     ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
            //     ->where('customer_visit.tgl_visit', saveDateNow())
            //     ->where('customer_visit_detail.parameter_main', 'Beli')
            //     ->groupBy(['customer_visit_detail.parameter_1', 'customer_visit_detail.parameter_2'])
            //     ->get();

            // $penjualan_hari_ini_per_person = DB::table('customer_visit')
            //     ->select(DB::raw('customer_visit.id_sales_person, customer_visit.kode_sales, customer_visit.nama_sales,
            //         customer_visit.id_store, customer_visit.kode_store, customer_visit.nama_store, customer_visit.kota_store,
            //         SUM(customer_visit_detail.qty) AS qty,
            //         SUM(customer_visit_detail.nominal) AS nominal'))
            //     ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
            //     ->where('customer_visit.tgl_visit', saveDateNow())
            //     ->where('customer_visit_detail.parameter_main', 'Beli')
            //     ->groupBy([
            //         'customer_visit.id_sales_person',
            //         'customer_visit.kode_sales',
            //         'customer_visit.nama_sales',
            //         'customer_visit.id_store',
            //         'customer_visit.kode_store',
            //         'customer_visit.nama_store',
            //         'customer_visit.kota_store',
            //     ])
            //     ->get();
            // $penjualan_hari_ini_per_store = DB::table('customer_visit')
            //     ->select(DB::raw('customer_visit.id_store, customer_visit.kode_store, customer_visit.nama_store, customer_visit.kota_store,
            //         SUM(customer_visit_detail.qty) AS qty,
            //         SUM(customer_visit_detail.nominal) AS nominal'))
            //     ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
            //     ->where('customer_visit.tgl_visit', saveDateNow())
            //     ->where('customer_visit_detail.parameter_main', 'Beli')
            //     ->groupBy([
            //         'customer_visit.id_store',
            //         'customer_visit.kode_store',
            //         'customer_visit.nama_store',
            //         'customer_visit.kota_store',
            //     ])
            //     ->get();
            // /* Table - per Hari - End */

            // /* Table - per Bulan - Start */
            // $penjualan_bulan_ini_per_tipe_barang = DB::table('customer_visit')
            //     ->select(DB::raw('customer_visit_detail.parameter_1,
            //         customer_visit_detail.parameter_2,
            //         SUM(customer_visit_detail.qty) AS qty,
            //         SUM(customer_visit_detail.nominal) AS nominal'))
            //     ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
            //     ->whereYear('customer_visit.tgl_visit', activePeriod())
            //     ->whereMonth('customer_visit.tgl_visit', date('m'))
            //     ->where('customer_visit_detail.parameter_main', 'Beli')
            //     ->groupBy(['customer_visit_detail.parameter_1', 'customer_visit_detail.parameter_2'])
            //     ->get();
            // $penjualan_bulan_ini_per_person = DB::table('customer_visit')
            //     ->select(DB::raw('customer_visit.id_sales_person, customer_visit.kode_sales, customer_visit.nama_sales,
            //         customer_visit.id_store, customer_visit.kode_store, customer_visit.nama_store, customer_visit.kota_store,
            //         SUM(customer_visit_detail.qty) AS qty,
            //         SUM(customer_visit_detail.nominal) AS nominal'))
            //     ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
            //     ->whereYear('customer_visit.tgl_visit', activePeriod())
            //     ->whereMonth('customer_visit.tgl_visit', date('m'))
            //     ->where('customer_visit_detail.parameter_main', 'Beli')
            //     ->groupBy([
            //         'customer_visit.id_sales_person',
            //         'customer_visit.kode_sales',
            //         'customer_visit.nama_sales',
            //         'customer_visit.id_store',
            //         'customer_visit.kode_store',
            //         'customer_visit.nama_store',
            //         'customer_visit.kota_store',
            //     ])
            //     ->get();
            // $penjualan_bulan_ini_per_store = DB::table('customer_visit')
            //     ->select(DB::raw('customer_visit.id_store, customer_visit.kode_store, customer_visit.nama_store, customer_visit.kota_store,
            //         SUM(customer_visit_detail.qty) AS qty,
            //         SUM(customer_visit_detail.nominal) AS nominal'))
            //     ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
            //     ->whereYear('customer_visit.tgl_visit', activePeriod())
            //     ->whereMonth('customer_visit.tgl_visit', date('m'))
            //     ->where('customer_visit_detail.parameter_main', 'Beli')
            //     ->groupBy([
            //         'customer_visit.id_store',
            //         'customer_visit.kode_store',
            //         'customer_visit.nama_store',
            //         'customer_visit.kota_store',
            //     ])
            //     ->get();
            // /* Table - per Bulan - End */

            // /* Table - per Tahun - Start */
            // $penjualan_tahun_ini_per_tipe_barang = DB::table('customer_visit')
            //     ->select(DB::raw('customer_visit_detail.parameter_1,
            //         customer_visit_detail.parameter_2,
            //         SUM(customer_visit_detail.qty) AS qty,
            //         SUM(customer_visit_detail.nominal) AS nominal'))
            //     ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
            //     ->whereYear('customer_visit.tgl_visit', activePeriod())
            //     ->where('customer_visit_detail.parameter_main', 'Beli')
            //     ->groupBy(['customer_visit_detail.parameter_1', 'customer_visit_detail.parameter_2'])
            //     ->get();
            // $penjualan_tahun_ini_per_person = DB::table('customer_visit')
            //     ->select(DB::raw('customer_visit.id_sales_person, customer_visit.kode_sales, customer_visit.nama_sales,
            //         customer_visit.id_store, customer_visit.kode_store, customer_visit.nama_store, customer_visit.kota_store,
            //         SUM(customer_visit_detail.qty) AS qty,
            //         SUM(customer_visit_detail.nominal) AS nominal'))
            //     ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
            //     ->whereYear('customer_visit.tgl_visit', activePeriod())
            //     ->where('customer_visit_detail.parameter_main', 'Beli')
            //     ->groupBy([
            //         'customer_visit.id_sales_person',
            //         'customer_visit.kode_sales',
            //         'customer_visit.nama_sales',
            //         'customer_visit.id_store',
            //         'customer_visit.kode_store',
            //         'customer_visit.nama_store',
            //         'customer_visit.kota_store',
            //     ])
            //     ->get();
            // $penjualan_tahun_ini_per_store = DB::table('customer_visit')
            //     ->select(DB::raw('customer_visit.id_store, customer_visit.kode_store, customer_visit.nama_store, customer_visit.kota_store,
            //         SUM(customer_visit_detail.qty) AS qty,
            //         SUM(customer_visit_detail.nominal) AS nominal'))
            //     ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
            //     ->whereYear('customer_visit.tgl_visit', activePeriod())
            //     ->where('customer_visit_detail.parameter_main', 'Beli')
            //     ->groupBy([
            //         'customer_visit.id_store',
            //         'customer_visit.kode_store',
            //         'customer_visit.nama_store',
            //         'customer_visit.kota_store',
            //     ])
            //     ->get();
            // /* Table - per Tahun - End */
        } else {
            /* Widget - Start */
            $total_sales_value = DB::table('customer_visit')
                ->select(DB::raw('customer_visit.id_store, SUM(customer_visit_detail.nominal) as total_sales_value'))
                ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
                ->whereYear('customer_visit.tgl_visit', activePeriod())
                ->where('customer_visit_detail.parameter_main', 'Beli')
                ->where('customer_visit.id_store', getSession(3))
                ->groupBy([
                    'customer_visit.id_store',
                ])
                ->first();

            $total_sales_pcs = DB::table('customer_visit')
                ->select(DB::raw('customer_visit.id_store, SUM(customer_visit_detail.qty) as total_sales_pcs'))
                ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
                ->whereYear('customer_visit.tgl_visit', activePeriod())
                ->where('customer_visit_detail.parameter_main', 'Beli')
                ->where('customer_visit.id_store', getSession(3))
                ->groupBy([
                    'customer_visit.id_store',
                ])
                ->first();

            $total_customer_datang = DB::table('customer_visit_detail')
                ->select(DB::raw('customer_visit_detail.id_visit, customer_visit_detail.parameter_main'))
                ->leftJoin('customer_visit', 'customer_visit_detail.id_visit', '=', 'customer_visit.id')
                ->whereYear('customer_visit.tgl_visit', activePeriod())
                ->where('customer_visit_detail.parameter_main', 'Datang')
                ->where('customer_visit.id_store', getSession(3))
                ->groupBy(['customer_visit_detail.id_visit', 'customer_visit_detail.parameter_main'])
                ->get();

            $total_customer_tanya = DB::table('customer_visit_detail')
                ->select(DB::raw('customer_visit_detail.id_visit, customer_visit_detail.parameter_main'))
                ->leftJoin('customer_visit', 'customer_visit_detail.id_visit', '=', 'customer_visit.id')
                ->whereYear('customer_visit.tgl_visit', activePeriod())
                ->where('customer_visit_detail.parameter_main', 'Tanya')
                ->where('customer_visit.id_store', getSession(3))
                ->groupBy(['customer_visit_detail.id_visit', 'customer_visit_detail.parameter_main'])
                ->get();

            $total_customer_coba = DB::table('customer_visit_detail')
                ->select(DB::raw('customer_visit_detail.id_visit, customer_visit_detail.parameter_main'))
                ->leftJoin('customer_visit', 'customer_visit_detail.id_visit', '=', 'customer_visit.id')
                ->whereYear('customer_visit.tgl_visit', activePeriod())
                ->where('customer_visit_detail.parameter_main', 'Coba')
                ->where('customer_visit.id_store', getSession(3))
                ->groupBy(['customer_visit_detail.id_visit', 'customer_visit_detail.parameter_main'])
                ->get();

            $total_customer_beli = DB::table('customer_visit_detail')
                ->select(DB::raw('customer_visit_detail.id_visit, customer_visit_detail.parameter_main'))
                ->leftJoin('customer_visit', 'customer_visit_detail.id_visit', '=', 'customer_visit.id')
                ->whereYear('customer_visit.tgl_visit', activePeriod())
                ->where('customer_visit_detail.parameter_main', 'Beli')
                ->where('customer_visit.id_store', getSession(3))
                ->groupBy(['customer_visit_detail.id_visit', 'customer_visit_detail.parameter_main'])
                ->get();
            /* Widget - End */

            /* Grafik 1 - Start */
            $sql = "SELECT nama FROM store WHERE status_aktif = 1 AND id = " . getSession(3) . " ORDER BY nama";
            $data_store = DB::select($sql);
            $data_store_graph = array();
            foreach ($data_store as $key) {
                $data_store_graph[] = $key->nama;
            }

            // Datang
            $sql = $this->queryKunjungan("Datang", getSession(3));
            $data_datang = DB::select($sql);
            $total_datang_graph = array();
            foreach ($data_datang as $key) {
                $total_datang_graph[] = $key->jml;
            }
            $total_datang_graph = array_map('intval', $total_datang_graph);

            // Tanya
            $sql = $this->queryKunjungan("Tanya", getSession(3));
            $data_tanya = DB::select($sql);
            $total_tanya_graph = array();
            foreach ($data_tanya as $key) {
                $total_tanya_graph[] = $key->jml;
            }
            $total_tanya_graph = array_map('intval', $total_tanya_graph);

            // Coba
            $sql = $this->queryKunjungan("Coba", getSession(3));
            $data_coba = DB::select($sql);
            $total_coba_graph = array();
            foreach ($data_coba as $key) {
                $total_coba_graph[] = $key->jml;
            }
            $total_coba_graph = array_map('intval', $total_coba_graph);

            // Beli
            $sql = $this->queryKunjungan("Beli", getSession(3));
            $data_beli = DB::select($sql);
            $total_beli_graph = array();
            foreach ($data_beli as $key) {
                $total_beli_graph[] = $key->jml;
            }
            $total_beli_graph = array_map('intval', $total_beli_graph);
            /* Grafik 1 - End */

            // $total_customer_visit = DB::table('customer_visit')
            //     ->select(DB::raw('customer_visit.id_sales_person, COUNT(no_dokumen) as total_customer_visit'))
            //     ->whereYear('tgl_visit', activePeriod())
            //     ->where('customer_visit.id_sales_person', getSession(0))
            //     ->groupBy([
            //         'customer_visit.id_sales_person',
            //     ])
            //     ->first();

            // $total_customer_beli = DB::table('customer_visit')
            //     ->select(DB::raw('customer_visit.id_sales_person, COUNT(no_dokumen) as total_customer_beli'))
            //     ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
            //     ->whereYear('customer_visit.tgl_visit', activePeriod())
            //     ->where('customer_visit_detail.parameter_main', 'Beli')
            //     ->where('customer_visit.id_sales_person', getSession(0))
            //     ->groupBy([
            //         'customer_visit.id_sales_person',
            //     ])
            //     ->first();
            /* Widget - End */

            /* Grafik 2 - Start */
            $total_nominal_goldmart_graph = 0;
            for ($i = 0; $i < 12; $i++) {
                $total_nominal_goldmart[] = DB::table('customer_visit')
                    ->select(DB::raw('SUM(customer_visit_detail.nominal) AS total_goldmart'))
                    ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
                    ->where('customer_visit.tahun', activePeriod())
                    ->where('customer_visit.bulan', $i + 1)
                    ->where('customer_visit_detail.parameter_main', 'Beli')
                    ->where('customer_visit_detail.parameter_1', 'Goldmart')
                    ->where('customer_visit.id_sales_person', getSession(0))
                    ->pluck('total_goldmart')
                    ->first();
            }
            $total_nominal_goldmart_graph = array_map('intval', $total_nominal_goldmart);

            $total_nominal_goldmaster_graph = 0;
            for ($i = 0; $i < 12; $i++) {
                $total_nominal_goldmaster[] = DB::table('customer_visit')
                    ->select(DB::raw('SUM(customer_visit_detail.nominal) AS total_goldmaster'))
                    ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
                    ->where('customer_visit.tahun', activePeriod())
                    ->where('customer_visit.bulan', $i + 1)
                    ->where('customer_visit_detail.parameter_main', 'Beli')
                    ->where('customer_visit_detail.parameter_1', 'Goldmaster')
                    ->where('customer_visit.id_sales_person', getSession(0))
                    ->pluck('total_goldmaster')
                    ->first();
            }
            $total_nominal_goldmaster_graph = array_map('intval', $total_nominal_goldmaster);
            /* Grafik 2 - End */

            // /* Table - per Hari - Start */
            // $penjualan_hari_ini_per_tipe_barang = DB::table('customer_visit')
            //     ->select(DB::raw('customer_visit_detail.parameter_1,
            //         customer_visit_detail.parameter_2,
            //         SUM(customer_visit_detail.qty) AS qty,
            //         SUM(customer_visit_detail.nominal) AS nominal'))
            //     ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
            //     ->where('customer_visit.tgl_visit', saveDateNow())
            //     ->where('customer_visit_detail.parameter_main', 'Beli')
            //     ->where('customer_visit.id_sales_person', getSession(0))
            //     ->groupBy(['customer_visit_detail.parameter_1', 'customer_visit_detail.parameter_2'])
            //     ->get();
            // $penjualan_hari_ini_per_person = DB::table('customer_visit')
            //     ->select(DB::raw('customer_visit.id_sales_person, customer_visit.kode_sales, customer_visit.nama_sales,
            //         customer_visit.id_store, customer_visit.kode_store, customer_visit.nama_store, customer_visit.kota_store,
            //         SUM(customer_visit_detail.qty) AS qty,
            //         SUM(customer_visit_detail.nominal) AS nominal'))
            //     ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
            //     ->where('customer_visit.tgl_visit', saveDateNow())
            //     ->where('customer_visit_detail.parameter_main', 'Beli')
            //     ->where('customer_visit.id_store', getSession(3))
            //     ->groupBy([
            //         'customer_visit.id_sales_person',
            //         'customer_visit.kode_sales',
            //         'customer_visit.nama_sales',
            //         'customer_visit.id_store',
            //         'customer_visit.kode_store',
            //         'customer_visit.nama_store',
            //         'customer_visit.kota_store',
            //     ])
            //     ->get();
            // $penjualan_hari_ini_per_store = DB::table('customer_visit')
            //     ->select(DB::raw('customer_visit.id_store, customer_visit.kode_store, customer_visit.nama_store, customer_visit.kota_store,
            //         SUM(customer_visit_detail.qty) AS qty,
            //         SUM(customer_visit_detail.nominal) AS nominal'))
            //     ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
            //     ->where('customer_visit.tgl_visit', saveDateNow())
            //     ->where('customer_visit_detail.parameter_main', 'Beli')
            //     ->where('customer_visit.id_store', getSession(3))
            //     ->groupBy([
            //         'customer_visit.id_store',
            //         'customer_visit.kode_store',
            //         'customer_visit.nama_store',
            //         'customer_visit.kota_store',
            //     ])
            //     ->get();
            // /* Table - per Hari - End */

            // /* Table - per Bulan - Start */
            // $penjualan_bulan_ini_per_tipe_barang = DB::table('customer_visit')
            //     ->select(DB::raw('customer_visit_detail.parameter_1,
            //         customer_visit_detail.parameter_2,
            //         SUM(customer_visit_detail.qty) AS qty,
            //         SUM(customer_visit_detail.nominal) AS nominal'))
            //     ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
            //     ->whereYear('customer_visit.tgl_visit', activePeriod())
            //     ->whereMonth('customer_visit.tgl_visit', date('m'))
            //     ->where('customer_visit_detail.parameter_main', 'Beli')
            //     ->where('customer_visit.id_sales_person', getSession(0))
            //     ->groupBy(['customer_visit_detail.parameter_1', 'customer_visit_detail.parameter_2'])
            //     ->get();
            // $penjualan_bulan_ini_per_person = DB::table('customer_visit')
            //     ->select(DB::raw('customer_visit.id_sales_person, customer_visit.kode_sales, customer_visit.nama_sales,
            //         customer_visit.id_store, customer_visit.kode_store, customer_visit.nama_store, customer_visit.kota_store,
            //         SUM(customer_visit_detail.qty) AS qty,
            //         SUM(customer_visit_detail.nominal) AS nominal'))
            //     ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
            //     ->whereYear('customer_visit.tgl_visit', activePeriod())
            //     ->whereMonth('customer_visit.tgl_visit', date('m'))
            //     ->where('customer_visit_detail.parameter_main', 'Beli')
            //     ->where('customer_visit.id_store', getSession(3))
            //     ->groupBy([
            //         'customer_visit.id_sales_person',
            //         'customer_visit.kode_sales',
            //         'customer_visit.nama_sales',
            //         'customer_visit.id_store',
            //         'customer_visit.kode_store',
            //         'customer_visit.nama_store',
            //         'customer_visit.kota_store',
            //     ])
            //     ->get();
            // $penjualan_bulan_ini_per_store = DB::table('customer_visit')
            //     ->select(DB::raw('customer_visit.id_store, customer_visit.kode_store, customer_visit.nama_store, customer_visit.kota_store,
            //         SUM(customer_visit_detail.qty) AS qty,
            //         SUM(customer_visit_detail.nominal) AS nominal'))
            //     ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
            //     ->whereYear('customer_visit.tgl_visit', activePeriod())
            //     ->whereMonth('customer_visit.tgl_visit', date('m'))
            //     ->where('customer_visit_detail.parameter_main', 'Beli')
            //     ->where('customer_visit.id_store', getSession(3))
            //     ->groupBy([
            //         'customer_visit.id_store',
            //         'customer_visit.kode_store',
            //         'customer_visit.nama_store',
            //         'customer_visit.kota_store',
            //     ])
            //     ->get();
            // /* Table - per Bulan - End */

            // /* Table - per Tahun - Start */
            // $penjualan_tahun_ini_per_tipe_barang = DB::table('customer_visit')
            //     ->select(DB::raw('customer_visit_detail.parameter_1,
            //         customer_visit_detail.parameter_2,
            //         SUM(customer_visit_detail.qty) AS qty,
            //         SUM(customer_visit_detail.nominal) AS nominal'))
            //     ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
            //     ->whereYear('customer_visit.tgl_visit', activePeriod())
            //     ->where('customer_visit_detail.parameter_main', 'Beli')
            //     ->where('customer_visit.id_sales_person', getSession(0))
            //     ->groupBy(['customer_visit_detail.parameter_1', 'customer_visit_detail.parameter_2'])
            //     ->get();
            // $penjualan_tahun_ini_per_person = DB::table('customer_visit')
            //     ->select(DB::raw('customer_visit.id_sales_person, customer_visit.kode_sales, customer_visit.nama_sales,
            //         customer_visit.id_store, customer_visit.kode_store, customer_visit.nama_store, customer_visit.kota_store,
            //         SUM(customer_visit_detail.qty) AS qty,
            //         SUM(customer_visit_detail.nominal) AS nominal'))
            //     ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
            //     ->whereYear('customer_visit.tgl_visit', activePeriod())
            //     ->where('customer_visit_detail.parameter_main', 'Beli')
            //     ->where('customer_visit.id_store', getSession(3))
            //     ->groupBy([
            //         'customer_visit.id_sales_person',
            //         'customer_visit.kode_sales',
            //         'customer_visit.nama_sales',
            //         'customer_visit.id_store',
            //         'customer_visit.kode_store',
            //         'customer_visit.nama_store',
            //         'customer_visit.kota_store',
            //     ])
            //     ->get();
            // $penjualan_tahun_ini_per_store = DB::table('customer_visit')
            //     ->select(DB::raw('customer_visit.id_store, customer_visit.kode_store, customer_visit.nama_store, customer_visit.kota_store,
            //         SUM(customer_visit_detail.qty) AS qty,
            //         SUM(customer_visit_detail.nominal) AS nominal'))
            //     ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
            //     ->whereYear('customer_visit.tgl_visit', activePeriod())
            //     ->where('customer_visit_detail.parameter_main', 'Beli')
            //     ->where('customer_visit.id_store', getSession(3))
            //     ->groupBy([
            //         'customer_visit.id_store',
            //         'customer_visit.kode_store',
            //         'customer_visit.nama_store',
            //         'customer_visit.kota_store',
            //     ])
            //     ->get();
            // /* Table - per Tahun - End */
        }

        return view(
            'dashboard.index',
            compact(
                'total_sales_value',
                'total_sales_pcs',
                'total_customer_datang',
                'total_customer_tanya',
                'total_customer_coba',
                'total_customer_beli',
                'data_store_graph',
                'total_datang_graph',
                'total_tanya_graph',
                'total_coba_graph',
                'total_beli_graph',
                'total_nominal_goldmart_graph',
                'total_nominal_goldmaster_graph',
                'data_kunjungan',
                // 'penjualan_hari_ini_per_tipe_barang',
                // 'penjualan_bulan_ini_per_tipe_barang',
                // 'penjualan_tahun_ini_per_tipe_barang',
                // 'penjualan_hari_ini_per_person',
                // 'penjualan_bulan_ini_per_person',
                // 'penjualan_tahun_ini_per_person',
                // 'penjualan_hari_ini_per_store',
                // 'penjualan_bulan_ini_per_store',
                // 'penjualan_tahun_ini_per_store',
            )
        );
    }
}
