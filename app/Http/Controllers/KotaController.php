<?php

namespace App\Http\Controllers;

use App\Models\Kota;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\KotaRequest;

class KotaController extends Controller
{
    function __construct()
    {
        $this->middleware(['permission:kota create'])->only(['create', 'store']);
        $this->middleware(['permission:kota delete'])->only(['destroy']);
        $this->middleware(['permission:kota index'])->only(['index', 'show', 'data']);
        $this->middleware(['permission:kota update'])->only(['edit', 'update']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('kota.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kota.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KotaRequest $request)
    {
        $store = Kota::create([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama),
            'created_by' => auth()->user()->name,
        ]);

        if ($store) {
            return redirect()->route('kotas.index')->with('success', __('Data kota berhasil dibuat'));
        } else {
            return redirect()->route('kotas.index')->with('error', __('Data kota gagal dibuat'));
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
    public function edit(Kota $kota)
    {
        return view('kota.edit', compact('kota'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Kota $kota, KotaRequest $request)
    {
        $update = $kota->update([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama),
            'updated_by' => auth()->user()->name,
        ]);

        if ($update) {
            return redirect()->route('kotas.index')->with('success', __('Data kota berhasil diperbarui'));
        } else {
            return redirect()->route('kotas.index')->with('error', __('Data kota gagal diperbarui'));
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
        $query = Kota::where('id', '<>', 0);

        return datatables($query)
            ->addIndexColumn()
            ->addColumn('action', function ($query) {
                if (canAccess(['kota update'])) {
                    $update = '
                            <li>
                                <a class="edit dropdown-item border-bottom" href="' . route('kotas.edit', $query) . '" data-toggle="tooltip" data-id="' . $query->id . '">
                                    <i class="bx bx-edit-alt fs-20"></i> ' . __("Perbarui") . '
                                </a>
                            </li>
                        ';
                }
                if (canAccess(['kota update'])) {
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
