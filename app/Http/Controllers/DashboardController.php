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

            $total_customer_visit = DB::table('customer_visit')
                ->select(DB::raw('COUNT(no_dokumen) as total_customer_visit'))
                ->whereYear('tgl_visit', activePeriod())
                ->first();

            $total_customer_beli = DB::table('customer_visit')
                ->select(DB::raw('COUNT(customer_visit.no_dokumen) as total_customer_beli'))
                ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
                ->whereYear('customer_visit.tgl_visit', activePeriod())
                ->where('customer_visit_detail.parameter_main', 'Beli')
                ->first();
            /* Widget - End */

            /* Grafik 1 - Start */
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

            /* Table - per Hari - Start */
            $penjualan_hari_ini_per_tipe_barang = DB::table('customer_visit')
                ->select(DB::raw('customer_visit_detail.parameter_1,
                    customer_visit_detail.parameter_2,
                    SUM(customer_visit_detail.qty) AS qty,
                    SUM(customer_visit_detail.nominal) AS nominal'))
                ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
                ->where('customer_visit.tgl_visit', saveDateNow())
                ->where('customer_visit_detail.parameter_main', 'Beli')
                ->groupBy(['customer_visit_detail.parameter_1', 'customer_visit_detail.parameter_2'])
                ->get();

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
            /* Table - per Hari - End */

            /* Table - per Bulan - Start */
            $penjualan_bulan_ini_per_tipe_barang = DB::table('customer_visit')
                ->select(DB::raw('customer_visit_detail.parameter_1,
                    customer_visit_detail.parameter_2,
                    SUM(customer_visit_detail.qty) AS qty,
                    SUM(customer_visit_detail.nominal) AS nominal'))
                ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
                ->whereYear('customer_visit.tgl_visit', activePeriod())
                ->whereMonth('customer_visit.tgl_visit', date('m'))
                ->where('customer_visit_detail.parameter_main', 'Beli')
                ->groupBy(['customer_visit_detail.parameter_1', 'customer_visit_detail.parameter_2'])
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
            /* Table - per Bulan - End */

            /* Table - per Tahun - Start */
            $penjualan_tahun_ini_per_tipe_barang = DB::table('customer_visit')
                ->select(DB::raw('customer_visit_detail.parameter_1,
                    customer_visit_detail.parameter_2,
                    SUM(customer_visit_detail.qty) AS qty,
                    SUM(customer_visit_detail.nominal) AS nominal'))
                ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
                ->whereYear('customer_visit.tgl_visit', activePeriod())
                ->where('customer_visit_detail.parameter_main', 'Beli')
                ->groupBy(['customer_visit_detail.parameter_1', 'customer_visit_detail.parameter_2'])
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
            /* Table - per Tahun - End */
        } else {
            /* Widget - Start */
            $total_sales_value = DB::table('customer_visit')
                ->select(DB::raw('customer_visit.id_sales_person, SUM(customer_visit_detail.nominal) as total_sales_value'))
                ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
                ->whereYear('customer_visit.tgl_visit', activePeriod())
                ->where('customer_visit_detail.parameter_main', 'Beli')
                ->where('customer_visit.id_sales_person', getSession(0))
                ->groupBy([
                    'customer_visit.id_sales_person',
                ])
                ->first();

            $total_sales_pcs = DB::table('customer_visit')
                ->select(DB::raw('customer_visit.id_sales_person, SUM(customer_visit_detail.qty) as total_sales_pcs'))
                ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
                ->whereYear('customer_visit.tgl_visit', activePeriod())
                ->where('customer_visit_detail.parameter_main', 'Beli')
                ->where('customer_visit.id_sales_person', getSession(0))
                ->groupBy([
                    'customer_visit.id_sales_person',
                ])
                ->first();

            $total_customer_visit = DB::table('customer_visit')
                ->select(DB::raw('customer_visit.id_sales_person, COUNT(no_dokumen) as total_customer_visit'))
                ->whereYear('tgl_visit', activePeriod())
                ->where('customer_visit.id_sales_person', getSession(0))
                ->groupBy([
                    'customer_visit.id_sales_person',
                ])
                ->first();

            $total_customer_beli = DB::table('customer_visit')
                ->select(DB::raw('customer_visit.id_sales_person, COUNT(no_dokumen) as total_customer_beli'))
                ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
                ->whereYear('customer_visit.tgl_visit', activePeriod())
                ->where('customer_visit_detail.parameter_main', 'Beli')
                ->where('customer_visit.id_sales_person', getSession(0))
                ->groupBy([
                    'customer_visit.id_sales_person',
                ])
                ->first();
            /* Widget - End */

            /* Grafik 1 - Start */
            $total_nominal_goldmart_graph = 0;
            $total_nominal_goldmaster_graph = 0;
            /* Grafik 1 - End */

            /* Table - per Hari - Start */
            $penjualan_hari_ini_per_tipe_barang = DB::table('customer_visit')
                ->select(DB::raw('customer_visit_detail.parameter_1,
                    customer_visit_detail.parameter_2,
                    SUM(customer_visit_detail.qty) AS qty,
                    SUM(customer_visit_detail.nominal) AS nominal'))
                ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
                ->where('customer_visit.tgl_visit', saveDateNow())
                ->where('customer_visit_detail.parameter_main', 'Beli')
                ->where('customer_visit.id_sales_person', getSession(0))
                ->groupBy(['customer_visit_detail.parameter_1', 'customer_visit_detail.parameter_2'])
                ->get();
            $penjualan_hari_ini_per_person = DB::table('customer_visit')
                ->select(DB::raw('customer_visit.id_sales_person, customer_visit.kode_sales, customer_visit.nama_sales,
                    customer_visit.id_store, customer_visit.kode_store, customer_visit.nama_store, customer_visit.kota_store,
                    SUM(customer_visit_detail.qty) AS qty,
                    SUM(customer_visit_detail.nominal) AS nominal'))
                ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
                ->where('customer_visit.tgl_visit', saveDateNow())
                ->where('customer_visit_detail.parameter_main', 'Beli')
                ->where('customer_visit.id_store', getSession(3))
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
            $penjualan_hari_ini_per_store = DB::table('customer_visit')
                ->select(DB::raw('customer_visit.id_store, customer_visit.kode_store, customer_visit.nama_store, customer_visit.kota_store,
                    SUM(customer_visit_detail.qty) AS qty,
                    SUM(customer_visit_detail.nominal) AS nominal'))
                ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
                ->where('customer_visit.tgl_visit', saveDateNow())
                ->where('customer_visit_detail.parameter_main', 'Beli')
                ->where('customer_visit.id_store', getSession(3))
                ->groupBy([
                    'customer_visit.id_store',
                    'customer_visit.kode_store',
                    'customer_visit.nama_store',
                    'customer_visit.kota_store',
                ])
                ->get();
            /* Table - per Hari - End */

            /* Table - per Bulan - Start */
            $penjualan_bulan_ini_per_tipe_barang = DB::table('customer_visit')
                ->select(DB::raw('customer_visit_detail.parameter_1,
                    customer_visit_detail.parameter_2,
                    SUM(customer_visit_detail.qty) AS qty,
                    SUM(customer_visit_detail.nominal) AS nominal'))
                ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
                ->whereYear('customer_visit.tgl_visit', activePeriod())
                ->whereMonth('customer_visit.tgl_visit', date('m'))
                ->where('customer_visit_detail.parameter_main', 'Beli')
                ->where('customer_visit.id_sales_person', getSession(0))
                ->groupBy(['customer_visit_detail.parameter_1', 'customer_visit_detail.parameter_2'])
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
                ->where('customer_visit.id_store', getSession(3))
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
            $penjualan_bulan_ini_per_store = DB::table('customer_visit')
                ->select(DB::raw('customer_visit.id_store, customer_visit.kode_store, customer_visit.nama_store, customer_visit.kota_store,
                    SUM(customer_visit_detail.qty) AS qty,
                    SUM(customer_visit_detail.nominal) AS nominal'))
                ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
                ->whereYear('customer_visit.tgl_visit', activePeriod())
                ->whereMonth('customer_visit.tgl_visit', date('m'))
                ->where('customer_visit_detail.parameter_main', 'Beli')
                ->where('customer_visit.id_store', getSession(3))
                ->groupBy([
                    'customer_visit.id_store',
                    'customer_visit.kode_store',
                    'customer_visit.nama_store',
                    'customer_visit.kota_store',
                ])
                ->get();
            /* Table - per Bulan - End */

            /* Table - per Tahun - Start */
            $penjualan_tahun_ini_per_tipe_barang = DB::table('customer_visit')
                ->select(DB::raw('customer_visit_detail.parameter_1,
                    customer_visit_detail.parameter_2,
                    SUM(customer_visit_detail.qty) AS qty,
                    SUM(customer_visit_detail.nominal) AS nominal'))
                ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
                ->whereYear('customer_visit.tgl_visit', activePeriod())
                ->where('customer_visit_detail.parameter_main', 'Beli')
                ->where('customer_visit.id_sales_person', getSession(0))
                ->groupBy(['customer_visit_detail.parameter_1', 'customer_visit_detail.parameter_2'])
                ->get();
            $penjualan_tahun_ini_per_person = DB::table('customer_visit')
                ->select(DB::raw('customer_visit.id_sales_person, customer_visit.kode_sales, customer_visit.nama_sales,
                    customer_visit.id_store, customer_visit.kode_store, customer_visit.nama_store, customer_visit.kota_store,
                    SUM(customer_visit_detail.qty) AS qty,
                    SUM(customer_visit_detail.nominal) AS nominal'))
                ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
                ->whereYear('customer_visit.tgl_visit', activePeriod())
                ->where('customer_visit_detail.parameter_main', 'Beli')
                ->where('customer_visit.id_store', getSession(3))
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
            $penjualan_tahun_ini_per_store = DB::table('customer_visit')
                ->select(DB::raw('customer_visit.id_store, customer_visit.kode_store, customer_visit.nama_store, customer_visit.kota_store,
                    SUM(customer_visit_detail.qty) AS qty,
                    SUM(customer_visit_detail.nominal) AS nominal'))
                ->leftJoin('customer_visit_detail', 'customer_visit.id', '=', 'customer_visit_detail.id_visit')
                ->whereYear('customer_visit.tgl_visit', activePeriod())
                ->where('customer_visit_detail.parameter_main', 'Beli')
                ->where('customer_visit.id_store', getSession(3))
                ->groupBy([
                    'customer_visit.id_store',
                    'customer_visit.kode_store',
                    'customer_visit.nama_store',
                    'customer_visit.kota_store',
                ])
                ->get();
            /* Table - per Tahun - End */
        }

        return view(
            'dashboard.index',
            compact(
                'total_sales_value',
                'total_sales_pcs',
                'total_customer_visit',
                'total_customer_beli',
                'total_nominal_goldmart_graph',
                'total_nominal_goldmaster_graph',
                'penjualan_hari_ini_per_tipe_barang',
                'penjualan_bulan_ini_per_tipe_barang',
                'penjualan_tahun_ini_per_tipe_barang',
                'penjualan_hari_ini_per_person',
                'penjualan_bulan_ini_per_person',
                'penjualan_tahun_ini_per_person',
                'penjualan_hari_ini_per_store',
                'penjualan_bulan_ini_per_store',
                'penjualan_tahun_ini_per_store',
            )
        );
    }
}
