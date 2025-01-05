<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use Illuminate\Http\Request;

class NasabahController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:nasabah index', ['only' => ['index', 'show', 'data']]);
        $this->middleware('permission:nasabah update', ['only' => ['edit', 'update']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('nasabah.index');
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
        //
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
        $nasabah = Nasabah::findOrFail($id);

        return view('nasabah.edit', compact('nasabah'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Nasabah $nasabah)
    {
        $update = $nasabah->update([
            'email' => $request->email,
            'no_tlp' => $request->no_tlp,
            'alamat' => $request->alamat,
            'updated_at' => saveDateTimeNow(),
            'updated_by' => auth()->user()->name,
        ]);

        if ($update) {
            return redirect()->route('nasabah.index')->with('success', __('Data berhasil diperbarui'));
        } else {
            return redirect()->route('nasabah.index')->with('error', __('Data gagal diperbarui'));
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
        $query = Nasabah::orderBy('nama', 'DESC');

        return datatables($query)
            ->addIndexColumn()
            ->addColumn('action', function ($query) {
                if (canAccess(['nasabah update'])) {
                    $update = '
                            <li>
                                <a class="edit dropdown-item border-bottom" href="' . route('nasabah.edit', $query) . '" data-toggle="tooltip" data-id="' . $query->id . '">
                                    <i class="bx bx-edit-alt fs-20"></i> ' . __("Perbarui") . '
                                </a>
                            </li>
                        ';
                }
                if (canAccess(['nasabah update'])) {
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
