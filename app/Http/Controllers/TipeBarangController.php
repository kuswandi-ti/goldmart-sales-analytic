<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\TipeBarang;
use Illuminate\Http\Request;
use App\Http\Requests\TipeBarangRequest;

class TipeBarangController extends Controller
{
    function __construct()
    {
        $this->middleware(['permission:tipe barang create'])->only(['create', 'store']);
        $this->middleware(['permission:tipe barang delete'])->only(['destroy']);
        $this->middleware(['permission:tipe barang index'])->only(['index', 'show', 'data']);
        $this->middleware(['permission:tipe barang update'])->only(['edit', 'update']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('tipe_barang.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = Brand::orderBy('nama')->pluck('nama', 'id');

        return view('tipe_barang.create', compact('brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TipeBarangRequest $request)
    {
        $store = TipeBarang::create([
            'nama' => $request->nama,
            'id_brand' => $request->brand,
            'created_by' => auth()->user()->name,
        ]);

        if ($store) {
            return redirect()->route('tipebarang.index')->with('success', __('Data tipe barang berhasil dibuat'));
        } else {
            return redirect()->route('tipebarang.index')->with('error', __('Data tipe barang gagal dibuat'));
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
    public function edit(TipeBarang $tipebarang)
    {
        $brands = Brand::orderBy('nama')->pluck('nama', 'id');

        return view('tipe_barang.edit', compact('tipebarang', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TipeBarang $tipebarang, Request $request)
    {
        $update = $tipebarang->update([
            'nama' => $request->nama,
            'id_brand' => $request->brand,
            'updated_by' => auth()->user()->name,
        ]);

        if ($update) {
            return redirect()->route('tipebarang.index')->with('success', __('Data tipebarang berhasil diperbarui'));
        } else {
            return redirect()->route('tipebarang.index')->with('error', __('Data tipebarang gagal diperbarui'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipeBarang $tipebarang)
    {
        try {
            $destroy = $tipebarang->update([
                'status_aktif' => 0,
                'deleted_at' => saveDateTimeNow(),
                'deleted_by' => auth()->user()->name,
            ]);

            if ($destroy) {
                return response([
                    'status' => 'success',
                    'message' => __('Data tipe barang berhasil dihapus')
                ]);
            } else {
                return response([
                    'status' => 'error',
                    'message' => __('Data tipe barang gagal dihapus')
                ]);
            }
        } catch (\Throwable $th) {
            return response([
                'status' => 'error',
                'message' => __('Data tipe barang gagal dihapus')
            ]);
        }
    }

    public function restore(TipeBarang $tipebarang)
    {
        $restore = $tipebarang->update([
            'status_aktif' => 1,
            'restored_at' => saveDateTimeNow(),
            'restored_by' => auth()->user()->name,
        ]);

        if ($restore) {
            return redirect()->route('tipebarang.index')->with('success', __('Data tipe barang berhasil dipulihkan'));
        } else {
            return redirect()->route('tipebarang.index')->with('error', __('Data tipe barang gagal dipulihkan'));
        }
    }

    public function data(Request $request)
    {
        // $query = TipeBarang::select('tipe_barang.id AS id', 'tipe_barang.nama AS nama_tipe_barang', 'brand.nama AS nama_brand')
        //     ->leftJoin('brand', 'tipe_barang.id_brand', '=', 'brand.id')
        //     ->orderBy('brand.nama','ASC')
        //     ->orderBy('tipe_barang.nama','ASC');

        $query = TipeBarang::select('tipe_barang.id AS id', 'tipe_barang.nama AS nama_tipe_barang', 'brand.nama AS nama_brand', 'tipe_barang.status_aktif')
            ->leftJoin('brand', 'tipe_barang.id_brand', '=', 'brand.id');

        return datatables($query)
            ->addIndexColumn()
            ->editColumn('status_aktif', function ($query) {
                return '<h6><span class="badge bg-' . setStatusBadge($query->status_aktif) . '">' . setStatusText($query->status_aktif) . '</span></h6>';
            })
            ->addColumn('action', function ($query) {
                // if (canAccess(['tipe barang update'])) {
                //     $update = '
                //             <li>
                //                 <a class="edit dropdown-item border-bottom" href="' . route('tipebarang.edit', $query) . '" data-toggle="tooltip" data-id="' . $query->id . '">
                //                     <i class="bx bx-edit-alt fs-20"></i> ' . __("Perbarui") . '
                //                 </a>
                //             </li>
                //         ';
                // }
                // if (canAccess(['tipe barang update'])) {
                //     return '<div class="dropdown">
                //                 <button class="btn btn-outline-primary btn-sm btn-wave waves-effect waves-light dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                //                     <i class="bx bx-cog fs-16"></i>
                //                 </button>
                //                 <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" style="">' .
                //         (!empty($update) ? $update : '') . '
                //                 </ul>
                //             </div>';
                // } else {
                //     return '<span class="badge rounded-pill bg-outline-danger">' . __("Tidak ada akses") . '</span>';
                // }
                if ($query->status_aktif == 1) {
                    if (canAccess(['tipe barang update'])) {
                        $update = '
                            <li>
                                <a class="dropdown-item border-bottom" href="' . route('tipebarang.edit', $query) . '">
                                    <i class="bx bx-edit-alt fs-20"></i> ' . __("Perbarui") . '
                                </a>
                            </li>
                        ';
                    }
                    if (canAccess(['tipe barang delete'])) {
                        $delete = '
                            <li>
                                <a class="dropdown-item border-bottom delete_item" href="' . route('tipebarang.destroy', $query) . '">
                                    <i class="bx bx-trash fs-20"></i> ' . __("Hapus") . '
                                </a>
                            </li>
                        ';
                    }
                } else {
                    if (canAccess(['tipe barang restore'])) {
                        $restore = '
                            <li>
                                <a class="dropdown-item border-bottom" href="' . route('tipebarang.restore', $query) . '">
                                    <i class="bx bx-sync fs-20"></i> ' . __("Pulihkan") . '
                                </a>
                            </li>
                        ';
                    }
                }
                if (canAccess(['tipe barang update', 'tipe barang delete', 'tipe barang restore'])) {
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
