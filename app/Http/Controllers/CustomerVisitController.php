<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\RangeHarga;
use App\Models\TipeBarang;
use Illuminate\Http\Request;
use App\Models\CustomerVisit;
use App\Models\CustomerVisitDetail;

class CustomerVisitController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:customer visit create', ['only' => ['create', 'store', 'storeParam1', 'storeParam2', 'storeParam3', 'storeParam4']]);
        $this->middleware('permission:customer visit delete', ['only' => ['destroy']]);
        $this->middleware('permission:customer visit index', ['only' => ['index', 'show', 'data', 'param1', 'param2', 'param3', 'param4']]);
        $this->middleware('permission:customer visit update', ['only' => ['edit', 'update']]);
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $choice_param = $request->choice_param;
        $proses_param = $request->proses_param;

        $bulan = date('m');
        $tahun = date('y');

        // XXX-MMYY-XXXX
        $no_dokumen = docNoCustomerVisit() . '-' . $bulan . $tahun . '-' . right('0000' . last_doc_no(docNoCustomerVisit(), $bulan, $tahun), 4);

        // Header
        $store = CustomerVisit::create([
            'no_dokumen' => $no_dokumen,
            'tgl_visit' => saveDateNow(),
            'parameter_1' => paramCustomerVisit($proses_param),
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
        $params = $request->param;
        if ($choice_param == 'param1') {
            if (count($params) > 0) {
                for ($i = 0; $i < count($params); $i++) {
                    CustomerVisitDetail::create([
                        'id_visit' => $store->id,
                        'parameter_1' => $params[$i],
                        'parameter_2' => ($params[$i] == "Others" ? $request->keterangan : ''),
                        'created_by' => auth()->user()->name,
                    ]);
                }
            }
        }
        if ($choice_param == 'param2') {
            if (count($params) > 0) {
                for ($i = 0; $i < count($params); $i++) {
                    // Jika Promo
                    if ($params[$i] == 'Promo') {
                        CustomerVisitDetail::create([
                            'id_visit' => $store->id,
                            'parameter_1' => $params[$i],
                            'created_by' => auth()->user()->name,
                        ]);
                    }
                    // Jika Barang
                    if ($params[$i] == 'Barang') {
                        $brands = $request->brands;
                        // Jika ada brand yg diceklis
                        if (count($brands) > 0) {
                            for ($j = 0; $j < count($brands); $j++) {
                                // Jika ada tipe barang yg diinput
                                $tipebarang = $request->tipebarang;
                                // if (count($tipebarangs) > 0) {
                                //     for ($k = 0; $k < count($brands); $k++) {

                                //     }
                                // }
                                CustomerVisitDetail::create([
                                    'id_visit' => $store->id,
                                    'parameter_1' => $params[$i],
                                    'parameter_2' => $brands[$j],
                                    'parameter_3' => $tipebarang[$j],
                                    'created_by' => auth()->user()->name,
                                ]);
                            }
                        }
                    }
                }
            }
        }

        if ($store) {
            return redirect()->route('customervisit.index')->with('success', __('Data customer visit berhasil dibuat'));
        } else {
            return redirect()->route('customervisit.index')->with('error', __('Data customer visit gagal dibuat'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function input()
    {
        return view('customer_visit.input');
    }

    public function param1()
    {
        return view('customer_visit.param1');
    }

    public function param2()
    {
        $brand = Brand::orderBy('nama', 'ASC')->get();
        $tipe_barang = TipeBarang::orderBy('nama', 'ASC')->get();
        $range_harga = RangeHarga::orderBy('nama', 'ASC')->get();

        return view('customer_visit.param2', compact('brand', 'tipe_barang', 'range_harga'));
    }

    public function param3()
    {
        $brand = Brand::orderBy('nama', 'ASC')->get();
        $tipe_barang = TipeBarang::orderBy('nama', 'ASC')->get();
        return view('customer_visit.param3', compact('brand', 'tipe_barang'));
    }

    public function param4()
    {
        $brand = Brand::orderBy('nama', 'ASC')->get();
        $tipe_barang = TipeBarang::orderBy('nama', 'ASC')->get();
        return view('customer_visit.param4', compact('brand', 'tipe_barang'));
    }

    public function data(Request $request)
    {
        $query = CustomerVisit::orderBy('tgl_visit', 'DESC');

        return datatables($query)
            ->addIndexColumn()
            ->addColumn('action', function ($query) {
                if (canAccess(['customer visit update'])) {
                    $update = '
                            <li>
                                <a class="edit dropdown-item border-bottom" href="' . route('customervisit.edit', $query) . '" data-toggle="tooltip" data-id="' . $query->id . '">
                                    <i class="bx bx-edit-alt fs-20"></i> ' . __("Perbarui") . '
                                </a>
                            </li>
                        ';
                }
                if (canAccess(['customer visit update'])) {
                    return '<div class="dropdown">
                                <button class="btn btn-outline-primary btn-sm btn-wave waves-effect waves-light dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bx bx-cog fs-16"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" style="">' .
                        (!empty($update) ? $update : '') . '
                                </ul>
                            </div>';
                } else {
                    return '<span class="badge rounded-pill bg-outline-danger">' . __("Tidak ada akses") . '</span>';
                }
            })
            ->rawColumns(['action'])
            ->escapeColumns([])
            ->make(true);
    }
}
