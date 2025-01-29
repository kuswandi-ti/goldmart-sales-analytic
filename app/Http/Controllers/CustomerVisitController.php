<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Order;
use App\Models\RangeHarga;
use App\Models\TipeBarang;
use Illuminate\Http\Request;
use App\Models\CustomerVisit;
use App\Models\CustomerVisitDetail;

class CustomerVisitController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:customer visit create', ['only' => ['create', 'store']]);
        $this->middleware('permission:customer visit delete', ['only' => ['destroy']]);
        $this->middleware('permission:customer visit index', ['only' => ['index', 'show', 'data', 'input', 'param1', 'param2', 'param3', 'param4']]);
        $this->middleware('permission:customer visit update', ['only' => ['edit', 'update', 'editParam1', 'editParam2', 'editParam3', 'editParam4']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('customer_visit.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brand = Brand::orderBy('nama', 'ASC')->get();
        $tipe_barang = TipeBarang::orderBy('nama', 'ASC')->get();
        $range_harga = RangeHarga::orderBy('nama', 'ASC')->get();

        return view('customer_visit.create', compact('brand', 'tipe_barang', 'range_harga'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $choice_param = $request->choice_param;
        // $proses_param = $request->proses_param;

        $bulan = date('m');
        $tahun = date('y');

        // XXX-MMYY-XXXX
        $no_dokumen = docNoCustomerVisit() . '-' . $bulan . $tahun . '-' . right('0000' . last_doc_no(docNoCustomerVisit(), $bulan, date('Y')), 4);

        // Header
        $store = CustomerVisit::create([
            'no_dokumen' => $no_dokumen,
            'tgl_visit' => saveDateNow(),
            'tahun' => date('Y', strtotime(saveDateNow())),
            'bulan' => date('n', strtotime(saveDateNow())),
            'week' => date('W', strtotime(saveDateNow())),
            'quarter' => ceil(date('n', strtotime(saveDateNow())) / 3),
            // 'parameter_1' => paramCustomerVisit($proses_param),
            // 'parameter_2' => paramCustomerVisit($proses_param),
            // 'parameter_3' => paramCustomerVisit($proses_param),
            // 'parameter_4' => paramCustomerVisit($proses_param),
            'id_sales_person' => getSession(0),
            'kode_sales' => getSession(1),
            'nama_sales' => getSession(2),
            'id_store' => getSession(3),
            'kode_store' => getSession(4),
            'nama_store' => getSession(5),
            'kota_store' => getSession(6),
            'created_by' => auth()->user()->name,
        ]);

        // Detail
        /* Step 1 */
        $params_lihat = $request->param_lihat;
        if (!empty($params_lihat)) {
            if (count($params_lihat) > 0) {
                for ($i = 0; $i < count($params_lihat); $i++) {
                    CustomerVisitDetail::create([
                        'id_visit' => $store->id,
                        'parameter_main' => 'Lihat',
                        'parameter_1' => $params_lihat[$i],
                        'parameter_2' => ($params_lihat[$i] == "Others" ? $request->lihat_keterangan : NULL),
                        'created_by' => auth()->user()->name,
                    ]);
                }
            }
        }

        /* Step 2 */
        $params_tanya = $request->param_tanya;
        if (!empty($params_tanya)) {
            if (count($params_tanya) > 0) {
                for ($i = 0; $i < count($params_tanya); $i++) {
                    // Jika Promo
                    if ($params_tanya[$i] == 'Promo' || $params_tanya[$i] == 'Buy Back' || $params_tanya[$i] == 'Reparasi' ||  $params_tanya[$i] == 'Others') {
                        CustomerVisitDetail::create([
                            'id_visit' => $store->id,
                            'parameter_main' => 'Tanya',
                            'parameter_1' => $params_tanya[$i],
                            'parameter_2' => ($params_tanya[$i] == "Others" ? $request->tanya_keterangan : ''),
                            'created_by' => auth()->user()->name,
                        ]);
                    }

                    // Jika Barang
                    if ($params_tanya[$i] == 'Barang') {
                        // Goldmart
                        $tanya_goldmart = $request->tanya_goldmart;
                        if (count($tanya_goldmart) > 0) {
                            for ($j = 0; $j < count($tanya_goldmart); $j++) {
                                CustomerVisitDetail::create([
                                    'id_visit' => $store->id,
                                    'parameter_main' => 'Tanya',
                                    'parameter_1' => $params_tanya[$i],
                                    'parameter_2' => 'Goldmart',
                                    'parameter_3' => $tanya_goldmart[$j],
                                    'created_by' => auth()->user()->name,
                                ]);
                            }
                        }

                        // Goldmaster
                        $tanya_goldmaster = $request->tanya_goldmaster;
                        if (count($tanya_goldmaster) > 0) {
                            for ($j = 0; $j < count($tanya_goldmaster); $j++) {
                                CustomerVisitDetail::create([
                                    'id_visit' => $store->id,
                                    'parameter_main' => 'Tanya',
                                    'parameter_1' => $params_tanya[$i],
                                    'parameter_2' => 'Goldmaster',
                                    'parameter_3' => $tanya_goldmaster[$j],
                                    'created_by' => auth()->user()->name,
                                ]);
                            }
                        }
                    }

                    // Jika Range Harga
                    if ($params_tanya[$i] == 'Range Harga') {
                        $tanya_rangeharga = $request->tanya_rangeharga;
                        if (count($tanya_rangeharga) > 0) {
                            for ($j = 0; $j < count($tanya_rangeharga); $j++) {
                                CustomerVisitDetail::create([
                                    'id_visit' => $store->id,
                                    'parameter_main' => 'Tanya',
                                    'parameter_1' => $params_tanya[$i],
                                    'parameter_2' => $tanya_rangeharga[$j],
                                    'created_by' => auth()->user()->name,
                                ]);
                            }
                        }
                    }
                }
            }
        }

        /* Step 3 */
        // Goldmart
        $coba_goldmart = $request->coba_goldmart;
        if (!empty($coba_goldmart)) {
            if (count($coba_goldmart) > 0) {
                for ($j = 0; $j < count($coba_goldmart); $j++) {
                    CustomerVisitDetail::create([
                        'id_visit' => $store->id,
                        'parameter_main' => 'Coba',
                        'parameter_1' => 'Goldmart',
                        'parameter_2' => $coba_goldmart[$j],
                        'created_by' => auth()->user()->name,
                    ]);
                }
            }
        }

        // Goldmaster
        $coba_goldmaster = $request->coba_goldmaster;
        if (!empty($coba_goldmaster)) {
            if (count($coba_goldmaster) > 0) {
                for ($j = 0; $j < count($coba_goldmaster); $j++) {
                    CustomerVisitDetail::create([
                        'id_visit' => $store->id,
                        'parameter_main' => 'Coba',
                        'parameter_1' => 'Goldmaster',
                        'parameter_2' => $coba_goldmaster[$j],
                        'created_by' => auth()->user()->name,
                    ]);
                }
            }
        }

        /* Step 4 */
        $total_qty = 0;
        $total_nominal = 0;
        $order = false;
        $beli_tipe_barang_goldmart = $request->beli_tipe_barang_goldmart;
        $beli_nominal_goldmart = $request->beli_nominal_goldmart;
        $beli_qty_goldmart = $request->beli_qty_goldmart;
        if (!empty($beli_tipe_barang_goldmart)) {
            if (count($beli_tipe_barang_goldmart) > 0) {
                for ($i = 0; $i < count($beli_tipe_barang_goldmart); $i++) {
                    if ($beli_nominal_goldmart[$i] > 0 || $beli_qty_goldmart[$i]) {
                        CustomerVisitDetail::create([
                            'id_visit' => $store->id,
                            'parameter_main' => 'Beli',
                            'parameter_1' => 'Goldmart',
                            'parameter_2' => $beli_tipe_barang_goldmart[$i],
                            'qty' => unformatAmount($beli_qty_goldmart[$i]),
                            'nominal' => unformatAmount($beli_nominal_goldmart[$i]),
                            'created_by' => auth()->user()->name,
                        ]);
                        $total_qty = $total_qty + $beli_qty_goldmart[$i];
                        $total_nominal = $total_nominal + $beli_nominal_goldmart[$i];
                    }
                }
            }
        }

        // Goldmaster
        $beli_tipe_barang_goldmaster = $request->beli_tipe_barang_goldmaster;
        $beli_nominal_goldmaster = $request->beli_nominal_goldmaster;
        $beli_qty_goldmaster = $request->beli_qty_goldmaster;
        if (!empty($beli_tipe_barang_goldmaster)) {
            if (count($beli_tipe_barang_goldmaster) > 0) {
                for ($i = 0; $i < count($beli_tipe_barang_goldmaster); $i++) {
                    if ($beli_nominal_goldmaster[$i] > 0 || $beli_qty_goldmaster[$i]) {
                        CustomerVisitDetail::create([
                            'id_visit' => $store->id,
                            'parameter_main' => 'Beli',
                            'parameter_1' => 'Goldmaster',
                            'parameter_2' => $beli_tipe_barang_goldmaster[$i],
                            'qty' => unformatAmount($beli_qty_goldmaster[$i]),
                            'nominal' => unformatAmount($beli_nominal_goldmaster[$i]),
                            'created_by' => auth()->user()->name,
                        ]);
                        $total_qty = $total_qty + $beli_qty_goldmaster[$i];
                        $total_nominal = $total_nominal + $beli_nominal_goldmaster[$i];
                    }
                }
            }
        }

        // Bayar
        if (auth()->user()->hasRole('Super Admin')) {
            $order = Order::create([
                'no_dokumen' => $no_dokumen,
                'nama_customer' => 'Walk In Customer',
                'qty' => $total_qty,
                'nominal' => $total_nominal,
                'status_bayar' => 'pending',
                'created_by' => auth()->user()->name,
            ]);

            // Set your Merchant Server Key
            \Midtrans\Config::$serverKey = config('midtrans.midtrans_server_key');
            // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
            \Midtrans\Config::$isProduction = config('midtrans.midtrans_is_production');
            // Set sanitization on (default)
            \Midtrans\Config::$isSanitized = config('midtrans.midtrans_is_sanitized');
            // Set 3DS transaction for credit card to true
            \Midtrans\Config::$is3ds = config('midtrans.midtrans_is_3ds');

            $params = array(
                'transaction_details' => array(
                    'order_id' => rand(),
                    'gross_amount' => $total_nominal,
                ),
                'customer_details' => array(
                    'first_name' => 'Walk In Customer',
                    'last_name' => 'Walk In Customer',
                    'email' => 'mail@mail.com',
                    'phone' => '081298694640',
                ),
            );

            $snapToken = \Midtrans\Snap::getSnapToken($params);
        }

        // $params = $request->param;
        // if ($choice_param == 'param1') {
        //     if (!empty($params)) {
        //         if (count($params) > 0) {
        //             for ($i = 0; $i < count($params); $i++) {
        //                 CustomerVisitDetail::create([
        //                     'id_visit' => $store->id,
        //                     'parameter_1' => $params[$i],
        //                     'parameter_2' => ($params[$i] == "Others" ? $request->keterangan : ''),
        //                     'created_by' => auth()->user()->name,
        //                 ]);
        //             }
        //         }
        //     }
        // }

        // if ($choice_param == 'param2') {
        //     if (!empty($params)) {
        //         if (count($params) > 0) {
        //             for ($i = 0; $i < count($params); $i++) {
        //                 // Jika Promo
        //                 if ($params[$i] == 'Promo' || $params[$i] == 'Buy Back' || $params[$i] == 'Reparasi' ||  $params[$i] == 'Others') {
        //                     CustomerVisitDetail::create([
        //                         'id_visit' => $store->id,
        //                         'parameter_1' => $params[$i],
        //                         'parameter_2' => ($params[$i] == "Others" ? $request->keterangan : ''),
        //                         'created_by' => auth()->user()->name,
        //                     ]);
        //                 }

        //                 // Jika Barang
        //                 if ($params[$i] == 'Barang') {
        //                     // Goldmart
        //                     $goldmart = $request->goldmart;
        //                     if (count($goldmart) > 0) {
        //                         for ($j = 0; $j < count($goldmart); $j++) {
        //                             CustomerVisitDetail::create([
        //                                 'id_visit' => $store->id,
        //                                 'parameter_1' => $params[$i],
        //                                 'parameter_2' => 'Goldmart',
        //                                 'parameter_3' => $goldmart[$j],
        //                                 'created_by' => auth()->user()->name,
        //                             ]);
        //                         }
        //                     }

        //                     // Goldmaster
        //                     $goldmaster = $request->goldmaster;
        //                     if (count($goldmaster) > 0) {
        //                         for ($j = 0; $j < count($goldmaster); $j++) {
        //                             CustomerVisitDetail::create([
        //                                 'id_visit' => $store->id,
        //                                 'parameter_1' => $params[$i],
        //                                 'parameter_2' => 'Goldmaster',
        //                                 'parameter_3' => $goldmaster[$j],
        //                                 'created_by' => auth()->user()->name,
        //                             ]);
        //                         }
        //                     }
        //                 }

        //                 // Jika Range Harga
        //                 if ($params[$i] == 'Range Harga') {
        //                     $rangeharga = $request->rangeharga;
        //                     if (count($rangeharga) > 0) {
        //                         for ($j = 0; $j < count($rangeharga); $j++) {
        //                             CustomerVisitDetail::create([
        //                                 'id_visit' => $store->id,
        //                                 'parameter_1' => $params[$i],
        //                                 'parameter_2' => $rangeharga[$j],
        //                                 'created_by' => auth()->user()->name,
        //                             ]);
        //                         }
        //                     }
        //                 }
        //             }
        //         }
        //     }
        // }

        // if ($choice_param == 'param3') {
        //     // Goldmart
        //     $goldmart = $request->goldmart;
        //     if (!empty($goldmart)) {
        //         if (count($goldmart) > 0) {
        //             for ($j = 0; $j < count($goldmart); $j++) {
        //                 CustomerVisitDetail::create([
        //                     'id_visit' => $store->id,
        //                     'parameter_1' => 'Goldmart',
        //                     'parameter_2' => $goldmart[$j],
        //                     'created_by' => auth()->user()->name,
        //                 ]);
        //             }
        //         }
        //     }

        //     // Goldmaster
        //     $goldmaster = $request->goldmaster;
        //     if (!empty($goldmaster)) {
        //         if (count($goldmaster) > 0) {
        //             for ($j = 0; $j < count($goldmaster); $j++) {
        //                 CustomerVisitDetail::create([
        //                     'id_visit' => $store->id,
        //                     'parameter_1' => 'Goldmaster',
        //                     'parameter_2' => $goldmaster[$j],
        //                     'created_by' => auth()->user()->name,
        //                 ]);
        //             }
        //         }
        //     }
        // }

        // if ($choice_param == 'param4') {
        //     // Goldmart
        //     $tipe_barang_goldmart = $request->tipe_barang_goldmart;
        //     $nominal_goldmart = $request->nominal_goldmart;
        //     $qty_goldmart = $request->qty_goldmart;
        //     if (!empty($tipe_barang_goldmart)) {
        //         if (count($tipe_barang_goldmart) > 0) {
        //             for ($i = 0; $i < count($tipe_barang_goldmart); $i++) {
        //                 if ($nominal_goldmart[$i] > 0 || $qty_goldmart[$i]) {
        //                     CustomerVisitDetail::create([
        //                         'id_visit' => $store->id,
        //                         'parameter_1' => 'Goldmart',
        //                         'parameter_2' => $tipe_barang_goldmart[$i],
        //                         'qty' => unformatAmount($qty_goldmart[$i]),
        //                         'nominal' => unformatAmount($nominal_goldmart[$i]),
        //                         'created_by' => auth()->user()->name,
        //                     ]);
        //                 }
        //             }
        //         }
        //     }

        //     // Goldmaster
        //     $tipe_barang_goldmaster = $request->tipe_barang_goldmaster;
        //     $nominal_goldmaster = $request->nominal_goldmaster;
        //     $qty_goldmaster = $request->qty_goldmaster;
        //     if (!empty($tipe_barang_goldmaster)) {
        //         if (count($tipe_barang_goldmaster) > 0) {
        //             for ($i = 0; $i < count($tipe_barang_goldmaster); $i++) {
        //                 if ($nominal_goldmaster[$i] > 0 || $qty_goldmaster[$i]) {
        //                     CustomerVisitDetail::create([
        //                         'id_visit' => $store->id,
        //                         'parameter_1' => 'Goldmaster',
        //                         'parameter_2' => $tipe_barang_goldmaster[$i],
        //                         'qty' => unformatAmount($qty_goldmaster[$i]),
        //                         'nominal' => unformatAmount($nominal_goldmaster[$i]),
        //                         'created_by' => auth()->user()->name,
        //                     ]);
        //                 }
        //             }
        //         }
        //     }
        // }

        if ($store) {
            if ($order) {
                return view('customer_visit.checkout', compact('snapToken', 'order', 'total_nominal'));
            } else {
                return redirect()->route('customervisit.index')->with('success', __('Data customer visit berhasil dibuat'));
            }
        } else {
            return redirect()->route('customervisit.index')->with('error', __('Data customer visit gagal dibuat'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $customer_visit = CustomerVisit::find($id);

        /* Param 1 */
        $query = CustomerVisitDetail::select('parameter_1')
            ->where('id_visit', $id)
            ->get();
        $customer_visit_detail_parameter_1 = [];
        foreach ($query as $key => $value) {
            $customer_visit_detail_parameter_1[] = $value->parameter_1;
        }
        $query = CustomerVisitDetail::select('parameter_1')
            ->where('id_visit', $id)
            ->where('parameter_main', 'Coba')
            ->where('parameter_1', 'Goldmart')
            ->get();
        $customer_visit_detail_parameter_1_goldmart_coba = [];
        foreach ($query as $key => $value) {
            $customer_visit_detail_parameter_1_goldmart_coba[] = $value->parameter_1;
        }
        $query = CustomerVisitDetail::select('parameter_1')
            ->where('id_visit', $id)
            ->where('parameter_main', 'Beli')
            ->where('parameter_1', 'Goldmart')
            ->get();
        $customer_visit_detail_parameter_1_goldmart_beli = [];
        foreach ($query as $key => $value) {
            $customer_visit_detail_parameter_1_goldmart_beli[] = $value->parameter_1;
        }
        $query = CustomerVisitDetail::select('parameter_1')
            ->where('id_visit', $id)
            ->where('parameter_main', 'Coba')
            ->where('parameter_1', 'Goldmaster')
            ->get();
        $customer_visit_detail_parameter_1_goldmaster_coba = [];
        foreach ($query as $key => $value) {
            $customer_visit_detail_parameter_1_goldmaster_coba[] = $value->parameter_1;
        }
        $query = CustomerVisitDetail::select('parameter_1')
            ->where('id_visit', $id)
            ->where('parameter_main', 'Beli')
            ->where('parameter_1', 'Goldmaster')
            ->get();
        $customer_visit_detail_parameter_1_goldmaster_beli = [];
        foreach ($query as $key => $value) {
            $customer_visit_detail_parameter_1_goldmaster_beli[] = $value->parameter_1;
        }

        /* Param 2 */
        $query = CustomerVisitDetail::select('parameter_2')
            ->where('id_visit', $id)
            ->get();
        // Lihat - Others
        $customer_visit_detail_parameter_2_oth_lihat = CustomerVisitDetail::select('parameter_2')
            ->where('id_visit', $id)
            ->where('parameter_main', 'Lihat')
            ->where('parameter_1', 'Others')
            ->first();
        // Tanya - Others
        $customer_visit_detail_parameter_2_oth_tanya = CustomerVisitDetail::select('parameter_2')
            ->where('id_visit', $id)
            ->where('parameter_main', 'Tanya')
            ->where('parameter_1', 'Others')
            ->first();
        // Tanya - Range Harga
        $query = CustomerVisitDetail::select('parameter_2')
            ->where('id_visit', $id)
            ->where('parameter_main', 'Tanya')
            ->where('parameter_1', 'Range Harga')
            ->get();
        $customer_visit_detail_parameter_2_range_harga = [];
        foreach ($query as $key => $value) {
            $customer_visit_detail_parameter_2_range_harga[] = $value->parameter_2;
        }
        // Coba - Goldmart
        $query = CustomerVisitDetail::select('parameter_2')
            ->where('id_visit', $id)
            ->where('parameter_main', 'Coba')
            ->where('parameter_1', 'Goldmart')
            ->get();
        $customer_visit_detail_parameter_2_goldmart_coba = [];
        foreach ($query as $key => $value) {
            $customer_visit_detail_parameter_2_goldmart_coba[] = $value->parameter_2;
        }
        // Coba - Goldmaster
        $query = CustomerVisitDetail::select('parameter_2')
            ->where('id_visit', $id)
            ->where('parameter_main', 'Coba')
            ->where('parameter_1', 'Goldmaster')
            ->get();
        $customer_visit_detail_parameter_2_goldmaster_coba = [];
        foreach ($query as $key => $value) {
            $customer_visit_detail_parameter_2_goldmaster_coba[] = $value->parameter_2;
        }

        /* Param 3 */
        // Tanya - Barang - Goldmart
        $query = CustomerVisitDetail::select('parameter_3')
            ->where('id_visit', $id)
            ->where('parameter_main', 'Tanya')
            ->where('parameter_1', 'Barang')
            ->where('parameter_2', 'Goldmart')
            ->get();
        $customer_visit_detail_parameter_3_barang_goldmart_tanya = [];
        foreach ($query as $key => $value) {
            $customer_visit_detail_parameter_3_barang_goldmart_tanya[] = $value->parameter_3;
        }
        // Tanya - Barang - Goldmaster
        $query = CustomerVisitDetail::select('parameter_3')
            ->where('id_visit', $id)
            ->where('parameter_main', 'Tanya')
            ->where('parameter_1', 'Barang')
            ->where('parameter_2', 'Goldmaster')
            ->get();
        $customer_visit_detail_parameter_3_barang_goldmaster_tanya = [];
        foreach ($query as $key => $value) {
            $customer_visit_detail_parameter_3_barang_goldmaster_tanya[] = $value->parameter_3;
        }

        // Parameter 4 - Beli - Goldmart
        $customer_visit_detail_parameter_4_goldmart_beli = CustomerVisitDetail::select('parameter_2', 'qty', 'nominal')
            ->where('id_visit', $id)
            ->where('parameter_main', 'Beli')
            ->where('parameter_1', 'Goldmart')
            ->get();

        // Parameter 4 - Beli - Goldmaster
        $customer_visit_detail_parameter_4_goldmaster_beli = CustomerVisitDetail::select('parameter_2', 'qty', 'nominal')
            ->where('id_visit', $id)
            ->where('parameter_main', 'Beli')
            ->where('parameter_1', 'Goldmaster')
            ->get();

        $brand = Brand::orderBy('nama', 'ASC')->get();
        $tipe_barang = TipeBarang::orderBy('nama', 'ASC')->get();
        $range_harga = RangeHarga::orderBy('nama', 'ASC')->get();

        return view('customer_visit.show', compact(
            'customer_visit',
            'customer_visit_detail_parameter_1',
            'customer_visit_detail_parameter_1_goldmart_coba',
            'customer_visit_detail_parameter_1_goldmart_beli',
            'customer_visit_detail_parameter_1_goldmaster_coba',
            'customer_visit_detail_parameter_1_goldmaster_beli',
            'customer_visit_detail_parameter_2_range_harga',
            'customer_visit_detail_parameter_2_goldmart_coba',
            'customer_visit_detail_parameter_2_goldmaster_coba',
            'customer_visit_detail_parameter_2_oth_lihat',
            'customer_visit_detail_parameter_2_oth_tanya',
            'customer_visit_detail_parameter_3_barang_goldmart_tanya',
            'customer_visit_detail_parameter_3_barang_goldmaster_tanya',
            'customer_visit_detail_parameter_4_goldmart_beli',
            'customer_visit_detail_parameter_4_goldmaster_beli',
            'brand',
            'tipe_barang',
            'range_harga'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $customer_visit = CustomerVisit::find($id);

        /* Param 1 */
        $query = CustomerVisitDetail::select('parameter_1')
            ->where('id_visit', $id)
            ->get();
        $customer_visit_detail_parameter_1 = [];
        foreach ($query as $key => $value) {
            $customer_visit_detail_parameter_1[] = $value->parameter_1;
        }
        $query = CustomerVisitDetail::select('parameter_1')
            ->where('id_visit', $id)
            ->where('parameter_main', 'Coba')
            ->where('parameter_1', 'Goldmart')
            ->get();
        $customer_visit_detail_parameter_1_goldmart_coba = [];
        foreach ($query as $key => $value) {
            $customer_visit_detail_parameter_1_goldmart_coba[] = $value->parameter_1;
        }
        $query = CustomerVisitDetail::select('parameter_1')
            ->where('id_visit', $id)
            ->where('parameter_main', 'Beli')
            ->where('parameter_1', 'Goldmart')
            ->get();
        $customer_visit_detail_parameter_1_goldmart_beli = [];
        foreach ($query as $key => $value) {
            $customer_visit_detail_parameter_1_goldmart_beli[] = $value->parameter_1;
        }
        $query = CustomerVisitDetail::select('parameter_1')
            ->where('id_visit', $id)
            ->where('parameter_main', 'Coba')
            ->where('parameter_1', 'Goldmaster')
            ->get();
        $customer_visit_detail_parameter_1_goldmaster_coba = [];
        foreach ($query as $key => $value) {
            $customer_visit_detail_parameter_1_goldmaster_coba[] = $value->parameter_1;
        }
        $query = CustomerVisitDetail::select('parameter_1')
            ->where('id_visit', $id)
            ->where('parameter_main', 'Beli')
            ->where('parameter_1', 'Goldmaster')
            ->get();
        $customer_visit_detail_parameter_1_goldmaster_beli = [];
        foreach ($query as $key => $value) {
            $customer_visit_detail_parameter_1_goldmaster_beli[] = $value->parameter_1;
        }

        /* Param 2 */
        $query = CustomerVisitDetail::select('parameter_2')
            ->where('id_visit', $id)
            ->get();
        // Lihat - Others
        $customer_visit_detail_parameter_2_oth_lihat = CustomerVisitDetail::select('parameter_2')
            ->where('id_visit', $id)
            ->where('parameter_main', 'Lihat')
            ->where('parameter_1', 'Others')
            ->first();
        // Tanya - Others
        $customer_visit_detail_parameter_2_oth_tanya = CustomerVisitDetail::select('parameter_2')
            ->where('id_visit', $id)
            ->where('parameter_main', 'Tanya')
            ->where('parameter_1', 'Others')
            ->first();
        // Tanya - Range Harga
        $query = CustomerVisitDetail::select('parameter_2')
            ->where('id_visit', $id)
            ->where('parameter_main', 'Tanya')
            ->where('parameter_1', 'Range Harga')
            ->get();
        $customer_visit_detail_parameter_2_range_harga = [];
        foreach ($query as $key => $value) {
            $customer_visit_detail_parameter_2_range_harga[] = $value->parameter_2;
        }
        // Coba - Goldmart
        $query = CustomerVisitDetail::select('parameter_2')
            ->where('id_visit', $id)
            ->where('parameter_main', 'Coba')
            ->where('parameter_1', 'Goldmart')
            ->get();
        $customer_visit_detail_parameter_2_goldmart_coba = [];
        foreach ($query as $key => $value) {
            $customer_visit_detail_parameter_2_goldmart_coba[] = $value->parameter_2;
        }
        // Coba - Goldmaster
        $query = CustomerVisitDetail::select('parameter_2')
            ->where('id_visit', $id)
            ->where('parameter_main', 'Coba')
            ->where('parameter_1', 'Goldmaster')
            ->get();
        $customer_visit_detail_parameter_2_goldmaster_coba = [];
        foreach ($query as $key => $value) {
            $customer_visit_detail_parameter_2_goldmaster_coba[] = $value->parameter_2;
        }

        /* Param 3 */
        // Tanya - Barang - Goldmart
        $query = CustomerVisitDetail::select('parameter_3')
            ->where('id_visit', $id)
            ->where('parameter_main', 'Tanya')
            ->where('parameter_1', 'Barang')
            ->where('parameter_2', 'Goldmart')
            ->get();
        $customer_visit_detail_parameter_3_barang_goldmart_tanya = [];
        foreach ($query as $key => $value) {
            $customer_visit_detail_parameter_3_barang_goldmart_tanya[] = $value->parameter_3;
        }
        // Tanya - Barang - Goldmaster
        $query = CustomerVisitDetail::select('parameter_3')
            ->where('id_visit', $id)
            ->where('parameter_main', 'Tanya')
            ->where('parameter_1', 'Barang')
            ->where('parameter_2', 'Goldmaster')
            ->get();
        $customer_visit_detail_parameter_3_barang_goldmaster_tanya = [];
        foreach ($query as $key => $value) {
            $customer_visit_detail_parameter_3_barang_goldmaster_tanya[] = $value->parameter_3;
        }

        // Parameter 4 - Beli - Goldmart
        $customer_visit_detail_parameter_4_goldmart_beli = CustomerVisitDetail::select('parameter_2', 'qty', 'nominal')
            ->where('id_visit', $id)
            ->where('parameter_main', 'Beli')
            ->where('parameter_1', 'Goldmart')
            ->get();

        // Parameter 4 - Beli - Goldmaster
        $customer_visit_detail_parameter_4_goldmaster_beli = CustomerVisitDetail::select('parameter_2', 'qty', 'nominal')
            ->where('id_visit', $id)
            ->where('parameter_main', 'Beli')
            ->where('parameter_1', 'Goldmaster')
            ->get();

        $brand = Brand::orderBy('nama', 'ASC')->get();
        $tipe_barang = TipeBarang::orderBy('nama', 'ASC')->get();
        $range_harga = RangeHarga::orderBy('nama', 'ASC')->get();

        return view('customer_visit.edit', compact(
            'customer_visit',
            'customer_visit_detail_parameter_1',
            'customer_visit_detail_parameter_1_goldmart_coba',
            'customer_visit_detail_parameter_1_goldmart_beli',
            'customer_visit_detail_parameter_1_goldmaster_coba',
            'customer_visit_detail_parameter_1_goldmaster_beli',
            'customer_visit_detail_parameter_2_range_harga',
            'customer_visit_detail_parameter_2_goldmart_coba',
            'customer_visit_detail_parameter_2_goldmaster_coba',
            'customer_visit_detail_parameter_2_oth_lihat',
            'customer_visit_detail_parameter_2_oth_tanya',
            'customer_visit_detail_parameter_3_barang_goldmart_tanya',
            'customer_visit_detail_parameter_3_barang_goldmaster_tanya',
            'customer_visit_detail_parameter_4_goldmart_beli',
            'customer_visit_detail_parameter_4_goldmaster_beli',
            'brand',
            'tipe_barang',
            'range_harga'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // $choice_param = $request->choice_param;
        // $proses_param = $request->proses_param;

        // Header
        $customer_visit = CustomerVisit::findOrFail($id);
        $update = $customer_visit->update([
            'updated_by' => auth()->user()->name,
        ]);

        CustomerVisitDetail::where('id_visit', $id)->delete();

        // Detail
        /* Step 1 */
        $params_lihat = $request->param_lihat;
        if (!empty($params_lihat)) {
            if (count($params_lihat) > 0) {
                for ($i = 0; $i < count($params_lihat); $i++) {
                    CustomerVisitDetail::create([
                        'id_visit' => $id,
                        'parameter_main' => 'Lihat',
                        'parameter_1' => $params_lihat[$i],
                        'parameter_2' => ($params_lihat[$i] == "Others" ? $request->lihat_keterangan : NULL),
                        'created_by' => auth()->user()->name,
                    ]);
                }
            }
        }

        /* Step 2 */
        $params_tanya = $request->param_tanya;
        if (!empty($params_tanya)) {
            if (count($params_tanya) > 0) {
                for ($i = 0; $i < count($params_tanya); $i++) {
                    // Jika Promo
                    if ($params_tanya[$i] == 'Promo' || $params_tanya[$i] == 'Buy Back' || $params_tanya[$i] == 'Reparasi' ||  $params_tanya[$i] == 'Others') {
                        CustomerVisitDetail::create([
                            'id_visit' => $id,
                            'parameter_main' => 'Tanya',
                            'parameter_1' => $params_tanya[$i],
                            'parameter_2' => ($params_tanya[$i] == "Others" ? $request->tanya_keterangan : ''),
                            'created_by' => auth()->user()->name,
                        ]);
                    }

                    // Jika Barang
                    if ($params_tanya[$i] == 'Barang') {
                        // Goldmart
                        $tanya_goldmart = $request->tanya_goldmart;
                        if (count($tanya_goldmart) > 0) {
                            for ($j = 0; $j < count($tanya_goldmart); $j++) {
                                CustomerVisitDetail::create([
                                    'id_visit' => $id,
                                    'parameter_main' => 'Tanya',
                                    'parameter_1' => $params_tanya[$i],
                                    'parameter_2' => 'Goldmart',
                                    'parameter_3' => $tanya_goldmart[$j],
                                    'created_by' => auth()->user()->name,
                                ]);
                            }
                        }

                        // Goldmaster
                        $tanya_goldmaster = $request->tanya_goldmaster;
                        if (count($tanya_goldmaster) > 0) {
                            for ($j = 0; $j < count($tanya_goldmaster); $j++) {
                                CustomerVisitDetail::create([
                                    'id_visit' => $id,
                                    'parameter_main' => 'Tanya',
                                    'parameter_1' => $params_tanya[$i],
                                    'parameter_2' => 'Goldmaster',
                                    'parameter_3' => $tanya_goldmaster[$j],
                                    'created_by' => auth()->user()->name,
                                ]);
                            }
                        }
                    }

                    // Jika Range Harga
                    if ($params_tanya[$i] == 'Range Harga') {
                        $tanya_rangeharga = $request->tanya_rangeharga;
                        if (count($tanya_rangeharga) > 0) {
                            for ($j = 0; $j < count($tanya_rangeharga); $j++) {
                                CustomerVisitDetail::create([
                                    'id_visit' => $id,
                                    'parameter_main' => 'Tanya',
                                    'parameter_1' => $params_tanya[$i],
                                    'parameter_2' => $tanya_rangeharga[$j],
                                    'created_by' => auth()->user()->name,
                                ]);
                            }
                        }
                    }
                }
            }
        }

        /* Step 3 */
        // Goldmart
        $coba_goldmart = $request->coba_goldmart;
        if (!empty($coba_goldmart)) {
            if (count($coba_goldmart) > 0) {
                for ($j = 0; $j < count($coba_goldmart); $j++) {
                    CustomerVisitDetail::create([
                        'id_visit' => $id,
                        'parameter_main' => 'Coba',
                        'parameter_1' => 'Goldmart',
                        'parameter_2' => $coba_goldmart[$j],
                        'created_by' => auth()->user()->name,
                    ]);
                }
            }
        }

        // Goldmaster
        $coba_goldmaster = $request->coba_goldmaster;
        if (!empty($coba_goldmaster)) {
            if (count($coba_goldmaster) > 0) {
                for ($j = 0; $j < count($coba_goldmaster); $j++) {
                    CustomerVisitDetail::create([
                        'id_visit' => $id,
                        'parameter_main' => 'Coba',
                        'parameter_1' => 'Goldmaster',
                        'parameter_2' => $coba_goldmaster[$j],
                        'created_by' => auth()->user()->name,
                    ]);
                }
            }
        }

        /* Step 4 */
        $beli_tipe_barang_goldmart = $request->beli_tipe_barang_goldmart;
        $beli_nominal_goldmart = $request->beli_nominal_goldmart;
        $beli_qty_goldmart = $request->beli_qty_goldmart;
        if (!empty($beli_tipe_barang_goldmart)) {
            if (count($beli_tipe_barang_goldmart) > 0) {
                for ($i = 0; $i < count($beli_tipe_barang_goldmart); $i++) {
                    if (
                        $beli_nominal_goldmart[$i] > 0 || $beli_qty_goldmart[$i]
                    ) {
                        CustomerVisitDetail::create([
                            'id_visit' => $id,
                            'parameter_main' => 'Beli',
                            'parameter_1' => 'Goldmart',
                            'parameter_2' => $beli_tipe_barang_goldmart[$i],
                            'qty' => unformatAmount($beli_qty_goldmart[$i]),
                            'nominal' => unformatAmount($beli_nominal_goldmart[$i]),
                            'created_by' => auth()->user()->name,
                        ]);
                    }
                }
            }
        }

        // Goldmaster
        $beli_tipe_barang_goldmaster = $request->beli_tipe_barang_goldmaster;
        $beli_nominal_goldmaster = $request->beli_nominal_goldmaster;
        $beli_qty_goldmaster = $request->beli_qty_goldmaster;
        if (!empty($beli_tipe_barang_goldmaster)) {
            if (count($beli_tipe_barang_goldmaster) > 0) {
                for (
                    $i = 0;
                    $i < count($beli_tipe_barang_goldmaster);
                    $i++
                ) {
                    if ($beli_nominal_goldmaster[$i] > 0 || $beli_qty_goldmaster[$i]) {
                        CustomerVisitDetail::create([
                            'id_visit' => $id,
                            'parameter_main' => 'Beli',
                            'parameter_1' => 'Goldmaster',
                            'parameter_2' => $beli_tipe_barang_goldmaster[$i],
                            'qty' => unformatAmount($beli_qty_goldmaster[$i]),
                            'nominal' => unformatAmount($beli_nominal_goldmaster[$i]),
                            'created_by' => auth()->user()->name,
                        ]);
                    }
                }
            }
        }

        // // Detail
        // $params = $request->param;
        // if ($choice_param == 'param1') {
        //     if (!empty($params)) {
        //         if (count($params) > 0) {
        //             for ($i = 0; $i < count($params); $i++) {
        //                 CustomerVisitDetail::create([
        //                     'id_visit' => $id,
        //                     'parameter_1' => $params[$i],
        //                     'parameter_2' => ($params[$i] == "Others" ? $request->keterangan : ''),
        //                     'created_by' => auth()->user()->name,
        //                 ]);
        //             }
        //         }
        //     }
        // }

        // if ($choice_param == 'param2') {
        //     if (!empty($params)) {
        //         if (count($params) > 0) {
        //             for ($i = 0; $i < count($params); $i++) {
        //                 // Jika Promo
        //                 if ($params[$i] == 'Promo' || $params[$i] == 'Buy Back' || $params[$i] == 'Reparasi' ||  $params[$i] == 'Others') {
        //                     CustomerVisitDetail::create([
        //                         'id_visit' => $id,
        //                         'parameter_1' => $params[$i],
        //                         'parameter_2' => ($params[$i] == "Others" ? $request->keterangan : ''),
        //                         'created_by' => auth()->user()->name,
        //                     ]);
        //                 }

        //                 // Jika Barang
        //                 if ($params[$i] == 'Barang') {
        //                     // Goldmart
        //                     $goldmart = $request->goldmart;
        //                     if (count($goldmart) > 0) {
        //                         for ($j = 0; $j < count($goldmart); $j++) {
        //                             CustomerVisitDetail::create([
        //                                 'id_visit' => $id,
        //                                 'parameter_1' => $params[$i],
        //                                 'parameter_2' => 'Goldmart',
        //                                 'parameter_3' => $goldmart[$j],
        //                                 'created_by' => auth()->user()->name,
        //                             ]);
        //                         }
        //                     }

        //                     // Goldmaster
        //                     $goldmaster = $request->goldmaster;
        //                     if (count($goldmaster) > 0) {
        //                         for ($j = 0; $j < count($goldmaster); $j++) {
        //                             CustomerVisitDetail::create([
        //                                 'id_visit' => $id,
        //                                 'parameter_1' => $params[$i],
        //                                 'parameter_2' => 'Goldmaster',
        //                                 'parameter_3' => $goldmaster[$j],
        //                                 'created_by' => auth()->user()->name,
        //                             ]);
        //                         }
        //                     }
        //                 }

        //                 // Jika Range Harga
        //                 if ($params[$i] == 'Range Harga') {
        //                     $rangeharga = $request->rangeharga;
        //                     if (count($rangeharga) > 0) {
        //                         for ($j = 0; $j < count($rangeharga); $j++) {
        //                             CustomerVisitDetail::create([
        //                                 'id_visit' => $id,
        //                                 'parameter_1' => $params[$i],
        //                                 'parameter_2' => $rangeharga[$j],
        //                                 'created_by' => auth()->user()->name,
        //                             ]);
        //                         }
        //                     }
        //                 }
        //             }
        //         }
        //     }
        // }

        // if ($choice_param == 'param3') {
        //     // Goldmart
        //     $goldmart = $request->goldmart;
        //     if (!empty($goldmart)) {
        //         if (count($goldmart) > 0) {
        //             for ($j = 0; $j < count($goldmart); $j++) {
        //                 CustomerVisitDetail::create([
        //                     'id_visit' => $id,
        //                     'parameter_1' => 'Goldmart',
        //                     'parameter_2' => $goldmart[$j],
        //                     'created_by' => auth()->user()->name,
        //                 ]);
        //             }
        //         }
        //     }

        //     // Goldmaster
        //     $goldmaster = $request->goldmaster;
        //     if (!empty($goldmaster)) {
        //         if (count($goldmaster) > 0) {
        //             for ($j = 0; $j < count($goldmaster); $j++) {
        //                 CustomerVisitDetail::create([
        //                     'id_visit' => $id,
        //                     'parameter_1' => 'Goldmaster',
        //                     'parameter_2' => $goldmaster[$j],
        //                     'created_by' => auth()->user()->name,
        //                 ]);
        //             }
        //         }
        //     }
        // }

        // if ($choice_param == 'param4') {
        //     // Goldmart
        //     $tipe_barang_goldmart = $request->tipe_barang_goldmart;
        //     $nominal_goldmart = $request->nominal_goldmart;
        //     $qty_goldmart = $request->qty_goldmart;
        //     if (!empty($tipe_barang_goldmart)) {
        //         if (count($tipe_barang_goldmart) > 0) {
        //             for ($i = 0; $i < count($tipe_barang_goldmart); $i++) {
        //                 if ($nominal_goldmart[$i] > 0 || $qty_goldmart[$i]) {
        //                     CustomerVisitDetail::create([
        //                         'id_visit' => $id,
        //                         'parameter_1' => 'Goldmart',
        //                         'parameter_2' => $tipe_barang_goldmart[$i],
        //                         'qty' => unformatAmount($qty_goldmart[$i]),
        //                         'nominal' => unformatAmount($nominal_goldmart[$i]),
        //                         'created_by' => auth()->user()->name,
        //                     ]);
        //                 }
        //             }
        //         }
        //     }

        //     // Goldmaster
        //     $tipe_barang_goldmaster = $request->tipe_barang_goldmaster;
        //     $nominal_goldmaster = $request->nominal_goldmaster;
        //     $qty_goldmaster = $request->qty_goldmaster;
        //     if (!empty($tipe_barang_goldmaster)) {
        //         if (count($tipe_barang_goldmaster) > 0) {
        //             for ($i = 0; $i < count($tipe_barang_goldmaster); $i++) {
        //                 if ($nominal_goldmaster[$i] > 0 || $qty_goldmaster[$i]) {
        //                     CustomerVisitDetail::create([
        //                         'id_visit' => $id,
        //                         'parameter_1' => 'Goldmaster',
        //                         'parameter_2' => $tipe_barang_goldmaster[$i],
        //                         'qty' => unformatAmount($qty_goldmaster[$i]),
        //                         'nominal' => unformatAmount($nominal_goldmaster[$i]),
        //                         'created_by' => auth()->user()->name,
        //                     ]);
        //                 }
        //             }
        //         }
        //     }
        // }

        if ($update) {
            return redirect()->route('customervisit.index')->with('success', __('Data customer visit berhasil diperbarui'));
        } else {
            return redirect()->route('customervisit.index')->with('error', __('Data customer visit gagal diperbarui'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $customer_visit = CustomerVisit::findOrFail($id);
            $destroy = $customer_visit->delete();

            if ($destroy) {
                CustomerVisitDetail::where('id_visit', $id)
                    ->delete();
                return response([
                    'status' => 'success',
                    'message' => __('Data user berhasil dihapus')
                ]);
            } else {
                return response([
                    'status' => 'error',
                    'message' => __('Data user gagal dihapus')
                ]);
            }
        } catch (\Throwable $th) {
            return response([
                'status' => 'error',
                'message' => __('Data user gagal dihapus')
            ]);
        }
    }

    // public function input()
    // {
    //     return view('customer_visit.input');
    // }

    // public function param1()
    // {
    //     return view('customer_visit.param1');
    // }

    // public function param2()
    // {
    //     $brand = Brand::orderBy('nama', 'ASC')->get();
    //     $tipe_barang = TipeBarang::orderBy('nama', 'ASC')->get();
    //     $range_harga = RangeHarga::orderBy('nama', 'ASC')->get();

    //     return view('customer_visit.param2', compact('brand', 'tipe_barang', 'range_harga'));
    // }

    // public function param3()
    // {
    //     $brand = Brand::orderBy('nama', 'ASC')->get();
    //     $tipe_barang = TipeBarang::orderBy('nama', 'ASC')->get();
    //     return view('customer_visit.param3', compact('brand', 'tipe_barang'));
    // }

    // public function param4()
    // {
    //     $brand = Brand::orderBy('nama', 'ASC')->get();
    //     $tipe_barang = TipeBarang::orderBy('nama', 'ASC')->get();
    //     return view('customer_visit.param4', compact('brand', 'tipe_barang'));
    // }

    // public function actionParam1(string $id, string $action)
    // {
    //     $customer_visit = CustomerVisit::find($id);

    //     $query = CustomerVisitDetail::select('parameter_1')
    //         ->where('id_visit', $id)
    //         ->get();
    //     $customer_visit_detail_parameter_1 = [];
    //     foreach ($query as $key => $value) {
    //         $customer_visit_detail_parameter_1[] = $value->parameter_1;
    //     }

    //     $customer_visit_detail_parameter_2 = CustomerVisitDetail::select('parameter_2')
    //         ->where('id_visit', $id)
    //         ->where('parameter_1', 'Others')
    //         ->first();

    //     if ($action == 'show') {
    //         return view('customer_visit.show_param1', compact(
    //             'customer_visit',
    //             'customer_visit_detail_parameter_1',
    //             'customer_visit_detail_parameter_2'
    //         ));
    //     } elseif ($action == 'edit') {
    //         return view('customer_visit.edit_param1', compact(
    //             'customer_visit',
    //             'customer_visit_detail_parameter_1',
    //             'customer_visit_detail_parameter_2'
    //         ));
    //     }
    // }

    // public function actionParam2(string $id, string $action)
    // {
    //     $customer_visit = CustomerVisit::find($id);

    //     // Parameter 1
    //     $query = CustomerVisitDetail::select('parameter_1')
    //         ->where('id_visit', $id)
    //         ->get();
    //     $customer_visit_detail_parameter_1 = [];
    //     foreach ($query as $key => $value) {
    //         $customer_visit_detail_parameter_1[] = $value->parameter_1;
    //     }

    //     $tipe_barang = TipeBarang::orderBy('nama', 'ASC')->get();
    //     $range_harga = RangeHarga::orderBy('nama', 'ASC')->get();

    //     // Parameter 3 - Barang - Goldmart
    //     $query = CustomerVisitDetail::select('parameter_3')
    //         ->where('id_visit', $id)
    //         ->where('parameter_1', 'Barang')
    //         ->where('parameter_2', 'Goldmart')
    //         ->get();
    //     $customer_visit_detail_parameter_3_barang_goldmart = [];
    //     foreach ($query as $key => $value) {
    //         $customer_visit_detail_parameter_3_barang_goldmart[] = $value->parameter_3;
    //     }

    //     // Parameter 3 - Barang - Goldmaster
    //     $query = CustomerVisitDetail::select('parameter_3')
    //         ->where('id_visit', $id)
    //         ->where('parameter_1', 'Barang')
    //         ->where('parameter_2', 'Goldmaster')
    //         ->get();
    //     $customer_visit_detail_parameter_3_barang_goldmaster = [];
    //     foreach ($query as $key => $value) {
    //         $customer_visit_detail_parameter_3_barang_goldmaster[] = $value->parameter_3;
    //     }

    //     // Parameter 2 - Range Harga
    //     $query = CustomerVisitDetail::select('parameter_2')
    //         ->where('id_visit', $id)
    //         ->where('parameter_1', 'Range Harga')
    //         ->get();
    //     $customer_visit_detail_parameter_2_range_harga = [];
    //     foreach ($query as $key => $value) {
    //         $customer_visit_detail_parameter_2_range_harga[] = $value->parameter_2;
    //     }

    //     // Parameter 2 - Others
    //     $customer_visit_detail_parameter_2_others = CustomerVisitDetail::select('parameter_2')
    //         ->where('id_visit', $id)
    //         ->where('parameter_1', 'Others')
    //         ->first();

    //     if ($action == 'show') {
    //         return view('customer_visit.show_param2', compact(
    //             'customer_visit',
    //             'tipe_barang',
    //             'range_harga',
    //             'customer_visit_detail_parameter_1',
    //             'customer_visit_detail_parameter_3_barang_goldmart',
    //             'customer_visit_detail_parameter_3_barang_goldmaster',
    //             'customer_visit_detail_parameter_2_range_harga',
    //             'customer_visit_detail_parameter_2_others',
    //         ));
    //     } elseif ($action == 'edit') {
    //         return view('customer_visit.edit_param2', compact(
    //             'customer_visit',
    //             'tipe_barang',
    //             'range_harga',
    //             'customer_visit_detail_parameter_1',
    //             'customer_visit_detail_parameter_3_barang_goldmart',
    //             'customer_visit_detail_parameter_3_barang_goldmaster',
    //             'customer_visit_detail_parameter_2_range_harga',
    //             'customer_visit_detail_parameter_2_others',
    //         ));
    //     }
    // }

    // public function actionParam3(string $id, string $action)
    // {
    //     $customer_visit = CustomerVisit::find($id);

    //     // Parameter 1
    //     $query = CustomerVisitDetail::select('parameter_1')
    //         ->where('id_visit', $id)
    //         ->get();
    //     $customer_visit_detail_parameter_1 = [];
    //     foreach ($query as $key => $value) {
    //         $customer_visit_detail_parameter_1[] = $value->parameter_1;
    //     }

    //     $tipe_barang = TipeBarang::orderBy('nama', 'ASC')->get();

    //     // Parameter 2 - Goldmart
    //     $query = CustomerVisitDetail::select('parameter_2')
    //         ->where('id_visit', $id)
    //         ->where('parameter_1', 'Goldmart')
    //         ->get();
    //     $customer_visit_detail_parameter_2_goldmart = [];
    //     foreach ($query as $key => $value) {
    //         $customer_visit_detail_parameter_2_goldmart[] = $value->parameter_2;
    //     }

    //     // Parameter 2 - Goldmaster
    //     $query = CustomerVisitDetail::select('parameter_2')
    //         ->where('id_visit', $id)
    //         ->where('parameter_1', 'Goldmaster')
    //         ->get();
    //     $customer_visit_detail_parameter_2_goldmaster = [];
    //     foreach ($query as $key => $value) {
    //         $customer_visit_detail_parameter_2_goldmaster[] = $value->parameter_2;
    //     }

    //     if ($action == 'show') {
    //         return view('customer_visit.show_param3', compact(
    //             'customer_visit',
    //             'tipe_barang',
    //             'customer_visit_detail_parameter_1',
    //             'customer_visit_detail_parameter_2_goldmart',
    //             'customer_visit_detail_parameter_2_goldmaster',
    //         ));
    //     } elseif ($action == 'edit') {
    //         return view('customer_visit.edit_param3', compact(
    //             'customer_visit',
    //             'tipe_barang',
    //             'customer_visit_detail_parameter_1',
    //             'customer_visit_detail_parameter_2_goldmart',
    //             'customer_visit_detail_parameter_2_goldmaster',
    //         ));
    //     }
    // }

    // public function actionParam4(string $id, string $action)
    // {
    //     $customer_visit = CustomerVisit::find($id);

    //     // Parameter 1
    //     $query = CustomerVisitDetail::select('parameter_1')
    //         ->where('id_visit', $id)
    //         ->get();
    //     $customer_visit_detail_parameter_1 = [];
    //     foreach ($query as $key => $value) {
    //         $customer_visit_detail_parameter_1[] = $value->parameter_1;
    //     }

    //     $tipe_barang = TipeBarang::orderBy('nama', 'ASC')->get();

    //     // Parameter 2 - Goldmart
    //     $customer_visit_detail_parameter_2_goldmart = CustomerVisitDetail::select('parameter_2', 'qty', 'nominal')
    //         ->where('id_visit', $id)
    //         ->where('parameter_1', 'Goldmart')
    //         ->get();

    //     // Parameter 2 - Goldmaster
    //     $customer_visit_detail_parameter_2_goldmaster = CustomerVisitDetail::select('parameter_2', 'qty', 'nominal')
    //         ->where('id_visit', $id)
    //         ->where('parameter_1', 'Goldmaster')
    //         ->get();

    //     if ($action == 'show') {
    //         return view('customer_visit.show_param4', compact(
    //             'customer_visit',
    //             'tipe_barang',
    //             'customer_visit_detail_parameter_1',
    //             'customer_visit_detail_parameter_2_goldmart',
    //             'customer_visit_detail_parameter_2_goldmaster',
    //         ));
    //     } elseif ($action == 'edit') {
    //         return view('customer_visit.edit_param4', compact(
    //             'customer_visit',
    //             'tipe_barang',
    //             'customer_visit_detail_parameter_1',
    //             'customer_visit_detail_parameter_2_goldmart',
    //             'customer_visit_detail_parameter_2_goldmaster',
    //         ));
    //     }
    // }

    public function data(Request $request)
    {
        $query = CustomerVisit::periodeaktif()->orderBy('tgl_visit', 'DESC');

        return datatables($query)
            ->addIndexColumn()
            // ->editColumn('parameter_1', function ($query) {
            //     return '<h6><span class="badge bg-' . setParamBadge($query->parameter_1) . '">' . $query->parameter_1 . '</span></h6>';
            // })
            ->addColumn('action', function ($query) {
                // if ($query->parameter_1 == 'Lihat') {
                //     $link = 'customervisit.action.param1';
                // } elseif ($query->parameter_1 == 'Tanya') {
                //     $link = 'customervisit.action.param2';
                // } elseif ($query->parameter_1 == 'Coba') {
                //     $link = 'customervisit.action.param3';
                // } elseif ($query->parameter_1 == 'Beli') {
                //     $link = 'customervisit.action.param4';
                // }
                if (canAccess(['customer visit update'])) {
                    $update = '
                            <li>
                                <a class="dropdown-item border-bottom" href="' . route('customervisit.edit', $query) . '">
                                    <i class="bx bx-edit-alt fs-20"></i> ' . __("Perbarui") . '
                                </a>
                            </li>
                        ';
                }
                if (canAccess(['customer visit delete'])) {
                    $delete = '
                            <li>
                                <a class="dropdown-item border-bottom delete_item" href="' . route('customervisit.destroy', $query->id) . '">
                                    <i class="bx bx-trash fs-20"></i> ' . __("Hapus") . '
                                </a>
                            </li>
                        ';
                }
                $view = '
                            <li>
                                <a class="edit dropdown-item border-bottom" href="' . route('customervisit.show', $query) . '" data-toggle="tooltip" data-id="' . $query->id . '">
                                    <i class="bx bx-show fs-20"></i> ' . __("Lihat") . '
                                </a>
                            </li>
                        ';
                if (canAccess(['customer visit update', 'customer visit delete', 'customer visit restore'])) {
                    return '<div class="dropdown">
                                <button class="btn btn-outline-primary btn-sm btn-wave waves-effect waves-light dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bx bx-cog fs-16"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" style="">' .
                        (!empty($update) ? $update : '') .
                        (!empty($view) ? $view : '') .
                        (!empty($restore) ? $restore : '') .
                        (!empty($delete) ? $delete : '') . '
                                </ul>
                            </div>';
                } else {
                    return '<div class="dropdown">
                                <button class="btn btn-outline-primary btn-sm btn-wave waves-effect waves-light dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bx bx-cog fs-16"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" style="">' .
                        (!empty($view) ? $view : '') . '
                                </ul>
                            </div>';
                }
            })
            ->rawColumns(['action'])
            ->escapeColumns([])
            ->make(true);
    }
}
