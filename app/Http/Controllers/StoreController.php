<?php

namespace App\Http\Controllers;

use App\Models\Kota;
use App\Models\Store;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRequest;

class StoreController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:store create', ['only' => ['create', 'store']]);
        $this->middleware('permission:store delete', ['only' => ['destroy']]);
        $this->middleware('permission:store index', ['only' => ['index', 'show', 'data']]);
        $this->middleware('permission:store restore', ['only' => ['restore']]);
        $this->middleware('permission:store update', ['only' => ['edit', 'update']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('store.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kota = Kota::orderBy('nama')->pluck('nama', 'nama');

        return view('store.create', compact('kota'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $kode = docNoStore() . right('0000' . last_doc_no(docNoStore(), date('m'), date('Y')), 3);
        $store = Store::create([
            'kode' => $kode,
            'slug' => Str::slug($kode),
            'nama' => $request->nama,
            'kota' => $request->kota,
            'status' => 1,
            'created_by' => auth()->user()->name,
        ]);

        if ($store) {
            return redirect()->route('store.index')->with('success', __('Data store berhasil dibuat'));
        } else {
            return redirect()->route('store.index')->with('error', __('Data store gagal dibuat'));
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
    public function edit(Store $store)
    {
        $kota = Kota::orderBy('nama')->pluck('nama', 'nama');

        return view('store.edit', compact('store', 'kota'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Store $store, StoreRequest $request)
    {
        $update = $store->update([
            'nama' => $request->nama,
            'kota' => $request->kota,
            'updated_by' => auth()->user()->name,
        ]);

        if ($update) {
            return redirect()->route('store.index')->with('success', __('Data store berhasil diperbarui'));
        } else {
            return redirect()->route('store.index')->with('error', __('Data store gagal diperbarui'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Store $store)
    {
        try {
            $destroy = $store->update([
                'status_aktif' => 0,
                'deleted_at' => saveDateTimeNow(),
                'deleted_by' => auth()->user()->name,
            ]);

            if ($destroy) {
                return response([
                    'status' => 'success',
                    'message' => __('Data store berhasil dihapus')
                ]);
            } else {
                return response([
                    'status' => 'error',
                    'message' => __('Data store gagal dihapus')
                ]);
            }
        } catch (\Throwable $th) {
            return response([
                'status' => 'error',
                'message' => __('Data store gagal dihapus')
            ]);
        }
    }

    public function restore(Store $store)
    {
        $restore = $store->update([
            'status_aktif' => 1,
            'restored_at' => saveDateTimeNow(),
            'restored_by' => auth()->user()->name,
        ]);

        if ($restore) {
            return redirect()->route('store.index')->with('success', __('Data store berhasil dipulihkan'));
        } else {
            return redirect()->route('store.index')->with('error', __('Data store gagal dipulihkan'));
        }
    }

    public function data(Request $request)
    {
        $query = Store::where('id', '<>', 0);

        return datatables($query)
            ->addIndexColumn()
            ->editColumn('status_aktif', function ($query) {
                return '<h6><span class="badge bg-' . setStatusBadge($query->status_aktif) . '">' . setStatusText($query->status_aktif) . '</span></h6>';
            })
            ->addColumn('action', function ($query) {
                if ($query->status_aktif == 1) {
                    if (canAccess(['store update'])) {
                        $update = '
                            <li>
                                <a class="dropdown-item border-bottom" href="' . route('store.edit', $query) . '">
                                    <i class="bx bx-edit-alt fs-20"></i> ' . __("Perbarui") . '
                                </a>
                            </li>
                        ';
                    }
                    if (canAccess(['store delete'])) {
                        $delete = '
                            <li>
                                <a class="dropdown-item border-bottom delete_item" href="' . route('store.destroy', $query) . '">
                                    <i class="bx bx-trash fs-20"></i> ' . __("Hapus") . '
                                </a>
                            </li>
                        ';
                    }
                } else {
                    if (canAccess(['store restore'])) {
                        $restore = '
                            <li>
                                <a class="dropdown-item border-bottom" href="' . route('store.restore', $query) . '">
                                    <i class="bx bx-sync fs-20"></i> ' . __("Pulihkan") . '
                                </a>
                            </li>
                        ';
                    }
                }
                if (canAccess(['store update', 'store delete', 'store restore'])) {
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
