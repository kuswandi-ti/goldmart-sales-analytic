<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\SalesPerson;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\SalesPersonRequest;

class SalesPersonController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:sales person create', ['only' => ['create', 'store']]);
        $this->middleware('permission:sales person delete', ['only' => ['destroy']]);
        $this->middleware('permission:sales person index', ['only' => ['index', 'show', 'data']]);
        $this->middleware('permission:sales person restore', ['only' => ['restore']]);
        $this->middleware('permission:sales person update', ['only' => ['edit', 'update']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('sales_person.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $store = Store::active()
            ->orderBy('nama')
            ->pluck(
                DB::raw("CONCAT(nama, ' - ', kota) as nama"),
                'id'
            );

        return view('sales_person.create', compact('store'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SalesPersonRequest $request)
    {
        $query = Store::select('id', 'kode', 'nama', 'kota')
            ->where('id', $request->store)
            ->first();

        $kode = docNoSalesPerson() . right('0000' . last_doc_no(docNoSalesPerson(), date('m'), date('Y')), 4);

        $store = SalesPerson::create([
            'kode' => $kode,
            'slug' => Str::slug($kode),
            'nama' => $request->nama,
            'nik' => $request->nik,
            'id_store' => $query['id'],
            'kode_store' => $query['kode'],
            'nama_store' => $query['nama'],
            'kota_store' => $query['kota'],
            'created_by' => auth()->user()->name,
        ]);

        if ($store) {
            return redirect()->route('salesperson.index')->with('success', __('Data sales person berhasil dibuat'));
        } else {
            return redirect()->route('salesperson.index')->with('error', __('Data sales person gagal dibuat'));
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
    public function edit(SalesPerson $salesperson)
    {
        $store = Store::active()
            ->orderBy('nama')
            ->pluck(
                DB::raw("CONCAT(nama, ' - ', kota) as nama"),
                'id'
            );

        return view('sales_person.edit', compact('salesperson', 'store'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SalesPerson $salesperson, SalesPersonRequest $request)
    {
        $query = Store::select('id', 'kode', 'nama', 'kota')
            ->where('id', $request->store)
            ->first();

        $update = $salesperson->update([
            'nama' => $request->nama,
            'nik' => $request->nik,
            'id_store' => $query['id'],
            'kode_store' => $query['kode'],
            'nama_store' => $query['nama'],
            'kota_store' => $query['kota'],
            'updated_by' => auth()->user()->name,
        ]);

        if ($update) {
            return redirect()->route('salesperson.index')->with('success', __('Data sales person berhasil diperbarui'));
        } else {
            return redirect()->route('salesperson.index')->with('error', __('Data sales person gagal diperbarui'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SalesPerson $salesperson)
    {
        try {
            $destroy = $salesperson->update([
                'status_aktif' => 0,
                'deleted_at' => saveDateTimeNow(),
                'deleted_by' => auth()->user()->name,
            ]);

            if ($destroy) {
                return response([
                    'status' => 'success',
                    'message' => __('Data sales person berhasil dihapus')
                ]);
            } else {
                return response([
                    'status' => 'error',
                    'message' => __('Data sales person gagal dihapus')
                ]);
            }
        } catch (\Throwable $th) {
            return response([
                'status' => 'error',
                'message' => __('Data sales person gagal dihapus')
            ]);
        }
    }

    public function restore(SalesPerson $salesperson)
    {
        $restore = $salesperson->update([
            'status_aktif' => 1,
            'restored_at' => saveDateTimeNow(),
            'restored_by' => auth()->user()->name,
        ]);

        if ($restore) {
            return redirect()->route('salesperson.index')->with('success', __('Data sales person berhasil dipulihkan'));
        } else {
            return redirect()->route('salesperson.index')->with('error', __('Data sales person gagal dipulihkan'));
        }
    }

    public function data(Request $request)
    {
        $query = SalesPerson::where('id', '<>', 0);

        return datatables($query)
            ->addIndexColumn()
            ->editColumn('status_aktif', function ($query) {
                return '<h6><span class="badge bg-' . setStatusBadge($query->status_aktif) . '">' . setStatusText($query->status_aktif) . '</span></h6>';
            })
            ->addColumn('action', function ($query) {
                if ($query->status_aktif == 1) {
                    if (canAccess(['sales person update'])) {
                        $update = '
                            <li>
                                <a class="dropdown-item border-bottom" href="' . route('salesperson.edit', $query) . '">
                                    <i class="bx bx-edit-alt fs-20"></i> ' . __("Perbarui") . '
                                </a>
                            </li>
                        ';
                    }
                    if (canAccess(['sales person delete'])) {
                        $delete = '
                            <li>
                                <a class="dropdown-item border-bottom delete_item" href="' . route('salesperson.destroy', $query) . '">
                                    <i class="bx bx-trash fs-20"></i> ' . __("Hapus") . '
                                </a>
                            </li>
                        ';
                    }
                } else {
                    if (canAccess(['sales person restore'])) {
                        $restore = '
                            <li>
                                <a class="dropdown-item border-bottom" href="' . route('salesperson.restore', $query) . '">
                                    <i class="bx bx-sync fs-20"></i> ' . __("Pulihkan") . '
                                </a>
                            </li>
                        ';
                    }
                }
                if (canAccess(['sales person update', 'sales person delete', 'sales person restore'])) {
                    return '<div class="dropdown">
                                <button class="btn btn-outline-primary btn-sm btn-wave waves-effect waves-light dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bx bx-cog fs-16"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" style="">' .
                        (!empty($update) ? $update : '') .
                        (!empty($restore) ? $restore : '') .
                        (!empty($delete) ? $delete : '') . '
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
