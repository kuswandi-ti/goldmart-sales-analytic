<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\RoleRequest;

class RoleController extends Controller
{
    function __construct()
    {
        $this->middleware(['permission:role create'])->only(['create', 'store']);
        $this->middleware(['permission:role delete'])->only(['destroy']);
        $this->middleware(['permission:role index'])->only(['index', 'show', 'data']);
        $this->middleware(['permission:role update'])->only(['edit', 'update']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::orderBy('name', 'ASC')->get()->groupBy('group_name');
        return view('role.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::orderBy('name', 'ASC')->get()->groupBy('group_name');
        return view('role.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {
        $store = Role::create([
            'name' => $request->role_name,
        ]);
        $store->syncPermissions($request->permissions);

        if ($store) {
            return redirect()->route('role.index')->with('success', __('Data role berhasil dibuat'));
        } else {
            return redirect()->route('role.index')->with('error', __('Data role gagal dibuat'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::findOrFail($id);

        $permissions = Permission::orderBy('name', 'ASC')->get()->groupBy('group_name');
        $roles_permissions = $role->permissions;
        $roles_permissions = $roles_permissions->pluck('name')->toArray();

        return view('role.edit', compact('role', 'permissions', 'roles_permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, string $id)
    {
        $role = Role::findOrFail($id);
        $update = $role->update([
            'name' => $request->role_name,
        ]);
        $role->syncPermissions($request->permissions);

        if ($update) {
            return redirect()->route('role.index')->with('success', __('Data role berhasil diperbarui'));
        } else {
            return redirect()->route('role.index')->with('error', __('Data role gagal diperbarui'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $role = Role::findOrFail($id);

            if ($role->name == 'Super Admin') {
                return response([
                    'status' => 'error',
                    'message' => __('Tidak bisa menghapus role Super Admin'),
                ]);
            }

            $role->delete();

            return response([
                'status' => 'success',
                'message' => __('Data role berhasil dihapus'),
            ]);
        } catch (\Throwable $th) {
            return response([
                'status' => 'error',
                'message' => __('Data role gagal dihapus'),
            ]);
        }
    }

    public function data(Request $request)
    {
        $query = Role::where('name', '!=', 'Super Admin')->get();

        return datatables($query)
            ->addIndexColumn()
            ->addColumn('action', function ($query) {
                if (canAccess(['role update'])) {
                    $update = '
                            <li>
                                <a class="dropdown-item border-bottom" href="' . route('role.edit', $query) . '">
                                    <i class="bx bx-edit-alt fs-20"></i> ' . __("Perbarui") . '
                                </a>
                            </li>
                        ';
                }
                if (canAccess(['role delete'])) {
                    $delete = '
                            <li>
                                <a class="dropdown-item border-bottom delete_item" href="' . route('role.destroy', $query) . '">
                                    <i class="bx bx-trash fs-20"></i> ' . __("Hapus") . '
                                </a>
                            </li>
                        ';
                }
                if (canAccess(['role update', 'role delete'])) {
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
