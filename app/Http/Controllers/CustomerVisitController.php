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
        $no_dokumen = docNoCustomerVisit() . '-' . $bulan . $tahun . '-' . right('0000' . last_doc_no(docNoCustomerVisit(), $bulan, date('Y')), 4);

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
            if (!empty($params)) {
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
        }

        if ($choice_param == 'param2') {
            if (!empty($params)) {
                if (count($params) > 0) {
                    for ($i = 0; $i < count($params); $i++) {
                        // Jika Promo
                        if ($params[$i] == 'Promo' || $params[$i] == 'Buy Back' || $params[$i] == 'Reparasi' ||  $params[$i] == 'Others') {
                            CustomerVisitDetail::create([
                                'id_visit' => $store->id,
                                'parameter_1' => $params[$i],
                                'parameter_2' => ($params[$i] == "Others" ? $request->keterangan : ''),
                                'created_by' => auth()->user()->name,
                            ]);
                        }

                        // Jika Barang
                        if ($params[$i] == 'Barang') {
                            // Goldmart
                            $goldmart = $request->goldmart;
                            if (count($goldmart) > 0) {
                                for ($j = 0; $j < count($goldmart); $j++) {
                                    CustomerVisitDetail::create([
                                        'id_visit' => $store->id,
                                        'parameter_1' => $params[$i],
                                        'parameter_2' => 'Goldmart',
                                        'parameter_3' => $goldmart[$j],
                                        'created_by' => auth()->user()->name,
                                    ]);
                                }
                            }

                            // Goldmaster
                            $goldmaster = $request->goldmaster;
                            if (count($goldmaster) > 0) {
                                for ($j = 0; $j < count($goldmaster); $j++) {
                                    CustomerVisitDetail::create([
                                        'id_visit' => $store->id,
                                        'parameter_1' => $params[$i],
                                        'parameter_2' => 'Goldmaster',
                                        'parameter_3' => $goldmaster[$j],
                                        'created_by' => auth()->user()->name,
                                    ]);
                                }
                            }
                        }

                        // Jika Range Harga
                        if ($params[$i] == 'Range Harga') {
                            $rangeharga = $request->rangeharga;
                            if (count($rangeharga) > 0) {
                                for ($j = 0; $j < count($rangeharga); $j++) {
                                    CustomerVisitDetail::create([
                                        'id_visit' => $store->id,
                                        'parameter_1' => $params[$i],
                                        'parameter_2' => $rangeharga[$j],
                                        'created_by' => auth()->user()->name,
                                    ]);
                                }
                            }
                        }
                    }
                }
            }
        }

        if ($choice_param == 'param3') {
            // Goldmart
            $goldmart = $request->goldmart;
            if (!empty($goldmart)) {
                if (count($goldmart) > 0) {
                    for ($j = 0; $j < count($goldmart); $j++) {
                        CustomerVisitDetail::create([
                            'id_visit' => $store->id,
                            'parameter_1' => 'Goldmart',
                            'parameter_2' => $goldmart[$j],
                            'created_by' => auth()->user()->name,
                        ]);
                    }
                }
            }

            // Goldmaster
            $goldmaster = $request->goldmaster;
            if (!empty($goldmaster)) {
                if (count($goldmaster) > 0) {
                    for ($j = 0; $j < count($goldmaster); $j++) {
                        CustomerVisitDetail::create([
                            'id_visit' => $store->id,
                            'parameter_1' => 'Goldmaster',
                            'parameter_2' => $goldmaster[$j],
                            'created_by' => auth()->user()->name,
                        ]);
                    }
                }
            }
        }

        if ($choice_param == 'param4') {
            // Goldmart
            $tipe_barang_goldmart = $request->tipe_barang_goldmart;
            $nominal_goldmart = $request->nominal_goldmart;
            $qty_goldmart = $request->qty_goldmart;
            if (!empty($tipe_barang_goldmart)) {
                if (count($tipe_barang_goldmart) > 0) {
                    for ($i = 0; $i < count($tipe_barang_goldmart); $i++) {
                        if ($nominal_goldmart[$i] > 0 || $qty_goldmart[$i]) {
                            CustomerVisitDetail::create([
                                'id_visit' => $store->id,
                                'parameter_1' => 'Goldmart',
                                'parameter_2' => $tipe_barang_goldmart[$i],
                                'qty' => $qty_goldmart[$i],
                                'nominal' => $nominal_goldmart[$i],
                                'created_by' => auth()->user()->name,
                            ]);
                        }
                    }
                }
            }

            // Goldmaster
            $tipe_barang_goldmaster = $request->tipe_barang_goldmaster;
            $nominal_goldmaster = $request->nominal_goldmaster;
            $qty_goldmaster = $request->qty_goldmaster;
            if (!empty($tipe_barang_goldmaster)) {
                if (count($tipe_barang_goldmaster) > 0) {
                    for ($i = 0; $i < count($tipe_barang_goldmaster); $i++) {
                        if ($nominal_goldmaster[$i] > 0 || $qty_goldmaster[$i]) {
                            CustomerVisitDetail::create([
                                'id_visit' => $store->id,
                                'parameter_1' => 'Goldmaster',
                                'parameter_2' => $tipe_barang_goldmaster[$i],
                                'qty' => $qty_goldmaster[$i],
                                'nominal' => $nominal_goldmaster[$i],
                                'created_by' => auth()->user()->name,
                            ]);
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
        $choice_param = $request->choice_param;
        $proses_param = $request->proses_param;

        // Header
        $customer_visit = CustomerVisit::findOrFail($id);
        $update = $customer_visit->update([
            'updated_by' => auth()->user()->name,
        ]);

        CustomerVisitDetail::where('id_visit', $id)->delete();

        // Detail
        $params = $request->param;
        if ($choice_param == 'param1') {
            if (!empty($params)) {
                if (count($params) > 0) {
                    for ($i = 0; $i < count($params); $i++) {
                        CustomerVisitDetail::create([
                            'id_visit' => $id,
                            'parameter_1' => $params[$i],
                            'parameter_2' => ($params[$i] == "Others" ? $request->keterangan : ''),
                            'created_by' => auth()->user()->name,
                        ]);
                    }
                }
            }
        }

        if ($choice_param == 'param2') {
            if (!empty($params)) {
                if (count($params) > 0) {
                    for ($i = 0; $i < count($params); $i++) {
                        // Jika Promo
                        if ($params[$i] == 'Promo' || $params[$i] == 'Buy Back' || $params[$i] == 'Reparasi' ||  $params[$i] == 'Others') {
                            CustomerVisitDetail::create([
                                'id_visit' => $id,
                                'parameter_1' => $params[$i],
                                'parameter_2' => ($params[$i] == "Others" ? $request->keterangan : ''),
                                'created_by' => auth()->user()->name,
                            ]);
                        }

                        // Jika Barang
                        if ($params[$i] == 'Barang') {
                            // Goldmart
                            $goldmart = $request->goldmart;
                            if (count($goldmart) > 0) {
                                for ($j = 0; $j < count($goldmart); $j++) {
                                    CustomerVisitDetail::create([
                                        'id_visit' => $id,
                                        'parameter_1' => $params[$i],
                                        'parameter_2' => 'Goldmart',
                                        'parameter_3' => $goldmart[$j],
                                        'created_by' => auth()->user()->name,
                                    ]);
                                }
                            }

                            // Goldmaster
                            $goldmaster = $request->goldmaster;
                            if (count($goldmaster) > 0) {
                                for ($j = 0; $j < count($goldmaster); $j++) {
                                    CustomerVisitDetail::create([
                                        'id_visit' => $id,
                                        'parameter_1' => $params[$i],
                                        'parameter_2' => 'Goldmaster',
                                        'parameter_3' => $goldmaster[$j],
                                        'created_by' => auth()->user()->name,
                                    ]);
                                }
                            }
                        }

                        // Jika Range Harga
                        if ($params[$i] == 'Range Harga') {
                            $rangeharga = $request->rangeharga;
                            if (count($rangeharga) > 0) {
                                for ($j = 0; $j < count($rangeharga); $j++) {
                                    CustomerVisitDetail::create([
                                        'id_visit' => $id,
                                        'parameter_1' => $params[$i],
                                        'parameter_2' => $rangeharga[$j],
                                        'created_by' => auth()->user()->name,
                                    ]);
                                }
                            }
                        }
                    }
                }
            }
        }

        if ($choice_param == 'param3') {
            // Goldmart
            $goldmart = $request->goldmart;
            if (!empty($goldmart)) {
                if (count($goldmart) > 0) {
                    for ($j = 0; $j < count($goldmart); $j++) {
                        CustomerVisitDetail::create([
                            'id_visit' => $id,
                            'parameter_1' => 'Goldmart',
                            'parameter_2' => $goldmart[$j],
                            'created_by' => auth()->user()->name,
                        ]);
                    }
                }
            }

            // Goldmaster
            $goldmaster = $request->goldmaster;
            if (!empty($goldmaster)) {
                if (count($goldmaster) > 0) {
                    for ($j = 0; $j < count($goldmaster); $j++) {
                        CustomerVisitDetail::create([
                            'id_visit' => $id,
                            'parameter_1' => 'Goldmaster',
                            'parameter_2' => $goldmaster[$j],
                            'created_by' => auth()->user()->name,
                        ]);
                    }
                }
            }
        }

        if ($choice_param == 'param4') {
            // Goldmart
            $tipe_barang_goldmart = $request->tipe_barang_goldmart;
            $nominal_goldmart = $request->nominal_goldmart;
            $qty_goldmart = $request->qty_goldmart;
            if (!empty($tipe_barang_goldmart)) {
                if (count($tipe_barang_goldmart) > 0) {
                    for ($i = 0; $i < count($tipe_barang_goldmart); $i++) {
                        if ($nominal_goldmart[$i] > 0 || $qty_goldmart[$i]) {
                            CustomerVisitDetail::create([
                                'id_visit' => $id,
                                'parameter_1' => 'Goldmart',
                                'parameter_2' => $tipe_barang_goldmart[$i],
                                'qty' => $qty_goldmart[$i],
                                'nominal' => $nominal_goldmart[$i],
                                'created_by' => auth()->user()->name,
                            ]);
                        }
                    }
                }
            }

            // Goldmaster
            $tipe_barang_goldmaster = $request->tipe_barang_goldmaster;
            $nominal_goldmaster = $request->nominal_goldmaster;
            $qty_goldmaster = $request->qty_goldmaster;
            if (!empty($tipe_barang_goldmaster)) {
                if (count($tipe_barang_goldmaster) > 0) {
                    for ($i = 0; $i < count($tipe_barang_goldmaster); $i++) {
                        if ($nominal_goldmaster[$i] > 0 || $qty_goldmaster[$i]) {
                            CustomerVisitDetail::create([
                                'id_visit' => $id,
                                'parameter_1' => 'Goldmaster',
                                'parameter_2' => $tipe_barang_goldmaster[$i],
                                'qty' => $qty_goldmaster[$i],
                                'nominal' => $nominal_goldmaster[$i],
                                'created_by' => auth()->user()->name,
                            ]);
                        }
                    }
                }
            }
        }

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

    public function editParam1(string $id)
    {
        $customer_visit = CustomerVisit::find($id);

        $query = CustomerVisitDetail::select('parameter_1')
            ->where('id_visit', $id)
            ->get();
        $customer_visit_detail_parameter_1 = [];
        foreach ($query as $key => $value) {
            $customer_visit_detail_parameter_1[] = $value->parameter_1;
        }

        $customer_visit_detail_parameter_2 = CustomerVisitDetail::select('parameter_2')
            ->where('id_visit', $id)
            ->where('parameter_1', 'Others')
            ->first();

        return view('customer_visit.edit_param1', compact('customer_visit', 'customer_visit_detail_parameter_1', 'customer_visit_detail_parameter_2'));
    }

    public function editParam2(string $id)
    {
        $customer_visit = CustomerVisit::find($id);

        // Parameter 1
        $query = CustomerVisitDetail::select('parameter_1')
            ->where('id_visit', $id)
            ->get();
        $customer_visit_detail_parameter_1 = [];
        foreach ($query as $key => $value) {
            $customer_visit_detail_parameter_1[] = $value->parameter_1;
        }

        $tipe_barang = TipeBarang::orderBy('nama', 'ASC')->get();
        $range_harga = RangeHarga::orderBy('nama', 'ASC')->get();

        // Parameter 3 - Barang - Goldmart
        $query = CustomerVisitDetail::select('parameter_3')
            ->where('id_visit', $id)
            ->where('parameter_1', 'Barang')
            ->where('parameter_2', 'Goldmart')
            ->get();
        $customer_visit_detail_parameter_3_barang_goldmart = [];
        foreach ($query as $key => $value) {
            $customer_visit_detail_parameter_3_barang_goldmart[] = $value->parameter_3;
        }

        // Parameter 3 - Barang - Goldmaster
        $query = CustomerVisitDetail::select('parameter_3')
            ->where('id_visit', $id)
            ->where('parameter_1', 'Barang')
            ->where('parameter_2', 'Goldmaster')
            ->get();
        $customer_visit_detail_parameter_3_barang_goldmaster = [];
        foreach ($query as $key => $value) {
            $customer_visit_detail_parameter_3_barang_goldmaster[] = $value->parameter_3;
        }

        // Parameter 2 - Range Harga
        $query = CustomerVisitDetail::select('parameter_2')
            ->where('id_visit', $id)
            ->where('parameter_1', 'Range Harga')
            ->get();
        $customer_visit_detail_parameter_2_range_harga = [];
        foreach ($query as $key => $value) {
            $customer_visit_detail_parameter_2_range_harga[] = $value->parameter_2;
        }

        // Parameter 2 - Others
        $customer_visit_detail_parameter_2_others = CustomerVisitDetail::select('parameter_2')
            ->where('id_visit', $id)
            ->where('parameter_1', 'Others')
            ->first();

        return view('customer_visit.edit_param2', compact(
            'customer_visit',
            'tipe_barang',
            'range_harga',
            'customer_visit_detail_parameter_1',
            'customer_visit_detail_parameter_3_barang_goldmart',
            'customer_visit_detail_parameter_3_barang_goldmaster',
            'customer_visit_detail_parameter_2_range_harga',
            'customer_visit_detail_parameter_2_others',
        ));
    }

    public function editParam3(string $id)
    {
        $customer_visit = CustomerVisit::find($id);

        // Parameter 1
        $query = CustomerVisitDetail::select('parameter_1')
            ->where('id_visit', $id)
            ->get();
        $customer_visit_detail_parameter_1 = [];
        foreach ($query as $key => $value) {
            $customer_visit_detail_parameter_1[] = $value->parameter_1;
        }

        return view('customer_visit.edit_param3', compact('customer_visit', 'customer_visit_detail_parameter_1'));
    }

    public function editParam4(string $id)
    {
        $customer_visit = CustomerVisit::find($id);

        // Parameter 1
        $query = CustomerVisitDetail::select('parameter_1')
            ->where('id_visit', $id)
            ->get();
        $customer_visit_detail_parameter_1 = [];
        foreach ($query as $key => $value) {
            $customer_visit_detail_parameter_1[] = $value->parameter_1;
        }

        // // Parameter 2
        // $customer_visit_detail_parameter_2 = CustomerVisitDetail::select('parameter_2')
        //     ->where('id_visit', $id)
        //     ->where('parameter_1', 'Others')
        //     ->first();


        return view('customer_visit.edit_param4', compact('customer_visit', 'customer_visit_detail_parameter_1'));
    }

    public function data(Request $request)
    {
        $query = CustomerVisit::orderBy('tgl_visit', 'DESC');

        return datatables($query)
            ->addIndexColumn()
            ->editColumn('parameter_1', function ($query) {
                return '<h6><span class="badge bg-' . setParamBadge($query->parameter_1) . '">' . $query->parameter_1 . '</span></h6>';
            })
            ->addColumn('action', function ($query) {
                if (canAccess(['customer visit update'])) {
                    if ($query->parameter_1 == 'Lihat') {
                        $link = 'customervisit.edit.param1';
                    } elseif ($query->parameter_1 == 'Tanya') {
                        $link = 'customervisit.edit.param2';
                    } elseif ($query->parameter_1 == 'Coba') {
                        $link = 'customervisit.edit.param3';
                    } elseif ($query->parameter_1 == 'Beli') {
                        $link = 'customervisit.edit.param4';
                    }
                    $update = '
                            <li>
                                <a class="edit dropdown-item border-bottom" href="' . route($link, $query) . '" data-toggle="tooltip" data-id="' . $query->id . '">
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
