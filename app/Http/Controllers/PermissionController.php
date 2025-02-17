<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\PermissionRequest;

class PermissionController extends Controller
{
    function __construct()
    {
        $this->middleware(['permission:permission create'])->only(['create', 'store']);
        $this->middleware(['permission:permission delete'])->only(['destroy']);
        $this->middleware(['permission:permission index'])->only(['index', 'show', 'data']);
        $this->middleware(['permission:permission update'])->only(['edit', 'update']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('permission.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('permission.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PermissionRequest $request)
    {
        $store = Permission::create([
            'name' => $request->permission_name,
            'group_name' => $request->group_name,
        ]);

        if ($store) {
            return redirect()->route('permission.index')->with('success', __('Data permission berhasil dibuat'));
        } else {
            return redirect()->route('permission.index')->with('error', __('Data permission gagal dibuat'));
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
        $permission = Permission::findOrFail($id);

        return view('permission.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PermissionRequest $request, string $id)
    {
        $permission = Permission::findOrFail($id);
        $update = $permission->update([
            'name' => $request->permission_name,
            'group_name' => $request->group_name,
        ]);

        if ($update) {
            return redirect()->route('permission.index')->with('success', __('Data permission berhasil diperbarui'));
        } else {
            return redirect()->route('permission.index')->with('error', __('Data permission gagal diperbarui'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $permission = Permission::findOrFail($id);
            $permission->delete();
            return response([
                'status' => 'success',
                'message' => __('Data permission berhasil dihapus'),
            ]);
        } catch (\Throwable $th) {
            return response([
                'status' => 'error',
                'message' => __('Data permission gagal dihapus'),
            ]);
        }
    }

    public function data(Request $request)
    {
        $query = Permission::where('id', '<>', 0)->get();

        return datatables($query)
            ->addIndexColumn()
            ->addColumn('action', function ($query) {
                if (canAccess(['permission update'])) {
                    $update = '
                            <li>
                                <a class="dropdown-item border-bottom" href="' . route('permission.edit', $query) . '">
                                    <i class="bx bx-edit-alt fs-20"></i> ' . __("Perbarui") . '
                                </a>
                            </li>
                        ';
                }
                if (canAccess(['permission delete'])) {
                    $delete = '
                            <li>
                                <a class="dropdown-item border-bottom delete_item" href="' . route('permission.destroy', $query) . '">
                                    <i class="bx bx-trash fs-20"></i> ' . __("Hapus") . '
                                </a>
                            </li>
                        ';
                }
                if (canAccess(['permission update', 'permission delete'])) {
                    return '<div class="dropdown">
                                <button class="btn btn-outline-primary btn-sm btn-wave waves-effect waves-light dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bx bx-cog fs-16"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" style="">' .
                        (!empty($update) ? $update : '') .
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
