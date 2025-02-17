<?php

namespace App\Http\Controllers;

use App\Models\RangeHarga;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\RangeHargaRequest;

class RangeHargaController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:range harga create', ['only' => ['create', 'store']]);
        $this->middleware('permission:range harga delete', ['only' => ['destroy']]);
        $this->middleware('permission:range harga index', ['only' => ['index', 'show', 'data']]);
        $this->middleware('permission:range harga update', ['only' => ['edit', 'update']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('range_harga.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('range_harga.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RangeHargaRequest $request)
    {
        $store = RangeHarga::create([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama),
            'harga_min' => unformatAmount($request->harga_min),
            'harga_max' => unformatAmount($request->harga_max),
            'created_by' => auth()->user()->name,
        ]);

        if ($store) {
            return redirect()->route('rangeharga.index')->with('success', __('Data range harga berhasil dibuat'));
        } else {
            return redirect()->route('rangeharga.index')->with('error', __('Data range harga gagal dibuat'));
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
    public function edit(RangeHarga $rangeharga)
    {
        return view('range_harga.edit', compact('rangeharga'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RangeHarga $rangeharga, RangeHargaRequest $request)
    {
        $update = $rangeharga->update([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama),
            'harga_min' => unformatAmount($request->harga_min),
            'harga_max' => unformatAmount($request->harga_max),
            'updated_by' => auth()->user()->name,
        ]);

        if ($update) {
            return redirect()->route('rangeharga.index')->with('success', __('Data range harga berhasil diperbarui'));
        } else {
            return redirect()->route('rangeharga.index')->with('error', __('Data range harga gagal diperbarui'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function data(Request $request)
    {
        $query = RangeHarga::where('id', '<>', 0);

        return datatables($query)
            ->addIndexColumn()
            ->addColumn('action', function ($query) {
                if (canAccess(['range harga update'])) {
                    $update = '
                            <li>
                                <a class="edit dropdown-item border-bottom" href="' . route('rangeharga.edit', $query) . '" data-toggle="tooltip" data-id="' . $query->id . '">
                                    <i class="bx bx-edit-alt fs-20"></i> ' . __("Perbarui") . '
                                </a>
                            </li>
                        ';
                }
                if (canAccess(['range harga update'])) {
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
