<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserPasswordUpdateRequest;
use App\Http\Requests\UserRequest;
use App\Models\SalesPerson;

class UserController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:user create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user delete', ['only' => ['destroy']]);
        $this->middleware('permission:user index', ['only' => ['index', 'show', 'data']]);
        $this->middleware('permission:user restore', ['only' => ['restore']]);
        $this->middleware('permission:user update', ['only' => ['edit', 'update']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('user.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::where('name', '!=', 'Super Admin')
            ->orderBy('name')
            ->pluck('name', 'name');
        $sales_person = SalesPerson::active()
            ->orderBy('nama')
            ->get();

        return view('user.create', compact('roles', 'sales_person'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $query = SalesPerson::select('id', 'kode', 'nama')
            ->where('id', $request->sales_person)
            ->first();

        $store = User::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'email' => $request->email,
            'username' => $request->email,
            'nik' => $request->nik,
            'password' => bcrypt($request->password),
            'join_date' => saveDateNow(),
            'email_verified_at' => saveDateTimeNow(),
            'approved' => 1,
            'approved_at' => saveDateTimeNow(),
            'approved_by' => auth()->user()->name,
            'id_sales_person' => $query['id'],
            'kode_sales' => $query['kode'],
            'nama_sales' => $query['nama'],
            'created_by' => auth()->user()->name,
        ]);

        $store->assignRole($request->role);

        // TODO : Send email verifikasi

        if ($store) {
            return redirect()->route('user.index')->with('success', __('Data user berhasil dibuat'));
        } else {
            return redirect()->route('user.index')->with('error', __('Data user gagal dibuat'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::where('name', '!=', 'Super Admin')->orderBy('name')->pluck('name', 'id');
        $sales_person = SalesPerson::active()
            ->orderBy('nama')
            ->get();

        return view('user.edit', compact('user', 'roles', 'sales_person'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(User $user, UserRequest $request)
    {
        $query = SalesPerson::select('id', 'kode', 'nama')
            ->where('id', $request->sales_person)
            ->first();

        $update = $user->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'email' => $request->email,
            'username' => $request->email,
            'nik' => $request->nik,
            'id_sales_person' => $query['id'],
            'kode_sales' => $query['kode'],
            'nama_sales' => $query['nama'],
            'updated_by' => auth()->user()->name,
        ]);

        $user->syncRoles($request->role);

        if ($update) {
            return redirect()->route('user.index')->with('success', __('Data user berhasil diperbarui'));
        } else {
            return redirect()->route('user.index')->with('error', __('Data user gagal diperbarui'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            $destroy = $user->update([
                'status_aktif' => 0,
                'deleted_at' => saveDateTimeNow(),
                'deleted_by' => auth()->user()->name,
            ]);

            if ($destroy) {
                return response([
                    'status' => 'success',
                    'message' => __('Data user berhasil dihapus')
                ]);
            } else {
                return response([
                    'status' => 'error',
                    'message' => __('Data user gagal dihapus')
                ]);
            }
        } catch (\Throwable $th) {
            return response([
                'status' => 'error',
                'message' => __('Data user gagal dihapus')
            ]);
        }
    }

    public function restore(User $user)
    {
        $restore = $user->update([
            'status_aktif' => 1,
            'restored_at' => saveDateTimeNow(),
            'restored_by' => auth()->user()->name,
        ]);

        if ($restore) {
            return redirect()->route('user.index')->with('success', __('Data user berhasil dipulihkan'));
        } else {
            return redirect()->route('user.index')->with('error', __('Data user gagal dipulihkan'));
        }
    }

    public function updatePassword(UserPasswordUpdateRequest $request, string $id)
    {
        $user = User::findOrFail($id);
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->back()->with('success', __('Data password berhasil diperbarui'));
    }

    public function data(Request $request)
    {
        $query = User::get()->filter(
            fn($user) => $user->roles->where('name', '!=', 'Super Admin')->toArray()
        );

        return datatables($query)
            ->addIndexColumn()
            ->editColumn('role', function ($query) {
                return $query->getRoleNames()->first();
            })
            ->editColumn('status_aktif', function ($query) {
                return '<h6><span class="badge bg-' . setStatusBadge($query->status_aktif) . '">' . setStatusText($query->status_aktif) . '</span></h6>';
            })
            ->addColumn('action', function ($query) {
                if ($query->status_aktif == 1) {
                    if (canAccess(['user update'])) {
                        $update = '
                            <li>
                                <a class="dropdown-item border-bottom" href="' . route('user.edit', $query) . '">
                                    <i class="bx bx-edit-alt fs-20"></i> ' . __("Perbarui") . '
                                </a>
                            </li>
                        ';
                    }
                    if (canAccess(['user delete'])) {
                        $delete = '
                            <li>
                                <a class="dropdown-item border-bottom delete_item" href="' . route('user.destroy', $query) . '">
                                    <i class="bx bx-trash fs-20"></i> ' . __("Hapus") . '
                                </a>
                            </li>
                        ';
                    }
                } else {
                    if (canAccess(['user restore'])) {
                        $restore = '
                            <li>
                                <a class="dropdown-item border-bottom" href="' . route('user.restore', $query) . '">
                                    <i class="bx bx-sync fs-20"></i> ' . __("Pulihkan") . '
                                </a>
                            </li>
                        ';
                    }
                }
                if (canAccess(['user update', 'user delete', 'user restore'])) {
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
