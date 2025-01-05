<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KreditNasabah;
use App\Models\KreditDetail;
use App\Models\ViewKreditNasabah;
use App\Traits\FileUploadTrait;
use DB;

class KreditNasabahController extends Controller
{
    use FileUploadTrait;

    function __construct()
    {
        $this->middleware('permission:kredit nasabah index', ['only' => ['index', 'show', 'data']]);
        $this->middleware('permission:kredit nasabah update', ['only' => ['edit', 'update']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('kredit_nasabah.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kredit_nasabah = KreditNasabah::findOrFail($id);
        $kredit_detail = KreditDetail::where('id_kredit_nasabah', $id)->get();

        return view('kredit_nasabah.show', compact('kredit_nasabah', 'kredit_detail'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kredit_nasabah = KreditNasabah::findOrFail($id);
        $kredit_detail = KreditDetail::where('id_kredit_nasabah', $id)->get();

        // return response()->json($kredit_nasabah);
        return view('kredit_nasabah.edit', compact('kredit_nasabah', 'kredit_detail'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KreditNasabah $kreditnasabah)
    {
        // $id = $request->id;
        $imagePath = $this->handleImageUpload($request, 'image_barang', $request->old_image_barang, 'barang');

        $id_detail = $request->id_detail;
        $no_seri = $request->no_seri;
        $gramasi = $request->gramasi;

        // dd(count($no_seri));

        $update = $kreditnasabah->update([
            'status_kredit' => $request->status_kredit,
            'tgl_lunas' => $request->tgl_lunas,
            'status_kirim_barang' => $request->status_kirim_barang,
            'tgl_kirim_barang' => $request->tgl_kirim_barang,
            'note_kirim_barang' => $request->note_kirim_barang,
            'image' => !empty($imagePath) ? $imagePath : $request->old_image_barang,
            'updated_at' => saveDateTimeNow(),
            'updated_by' => auth()->user()->name,
        ]);

        // $update = DB::table('kredit_detail')->where('id_kredit_nasabah', '=', $id)->delete();

        if (count($no_seri) > 0) {
            for ($i = 0; $i < count($no_seri); $i++) {
                $cek = KreditDetail::where('no_seri', '=', $no_seri[$i])->first();
                if ($cek) {
                    return redirect()->back()->withInput()->withErrors('Data No. [' . $cek->no_seri . '] sudah pernah dipakai');
                }
            }
        }

        if (count($no_seri) > 0) {
            for ($i = 0; $i < count($no_seri); $i++) {
                // $update = KreditDetail::create([
                //     'id_kredit_nasabah' => $id,
                //     'gramasi' => $gramasi[$i],
                //     'no_seri' => $no_seri[$i]
                // ]);

                // $detail = KreditDetail::find($id_detail[$i]);
                // $update = $detail->update([
                //     'gramasi' => $gramasi[$i],
                //     'no_seri' => $no_seri[$i]
                // ]);
                // $detail->gramasi = $gramasi[$i];
                // $detail->description = $no_seri[$i];

                // $detail->save();

                $update = KreditDetail::where('id', '=', $id_detail[$i])
                    ->update([
                        // 'gramasi' => $gramasi[$i],
                        'no_seri' => $no_seri[$i],
                        'updated_at' => saveDateTimeNow(),
                        'updated_by' => auth()->user()->name,
                    ]);
            }
        }

        if ($update) {
            return redirect()->route('kreditnasabah.index')->with('success', __('Data berhasil diperbarui'));
        } else {
            return redirect()->route('kreditnasabah.index')->with('error', __('Data gagal diperbarui'));
        }
    }

    public function detail($filter)
    {
        $text = "";

        switch ($filter) {
            case 'nasabah':
                $text = "Total Nasabah";
                break;
            case 'kredit':
                $text = "Total Nilai Kredit";
                break;
            case 'keuntungan':
                $text = "Total Keuntungan";
                break;
            case 'sudah-lunas':
                $text = "Total Pelunasan";
                break;
            case 'belum-lunas':
                $text = "Belum Pelunasan";
                break;
            default:
                $text = "All";
        }

        return view('kredit_nasabah.detail', compact('text', 'filter'));
    }

    public function data(Request $request)
    {
        $query = ViewKreditNasabah::periode()->where('status_kredit', 'Berjalan')->orderBy('tgl_incoming', 'DESC');

        return datatables($query)
            ->addIndexColumn()
            ->addColumn('action', function ($query) {
                // if ($query->status_lunas == 'Belum Lunas' || $query->status_kirim_barang == 'Belum Dikirim') {
                if (canAccess(['kredit nasabah update'])) {
                    // $update = '
                    //     <li>
                    //         <a class="edit dropdown-item border-bottom" href="javascript:void(0);" data-toggle="tooltip" data-id="' . $query->id . '">
                    //             <i class="bx bx-edit-alt fs-20"></i> ' . __("Perbarui") . '
                    //         </a>
                    //     </li>
                    // ';
                    $update = '
                            <li>
                                <a class="edit dropdown-item border-bottom" href="' . route('kreditnasabah.edit', $query) . '" data-toggle="tooltip" data-id="' . $query->id . '">
                                    <i class="bx bx-edit-alt fs-20"></i> ' . __("Perbarui") . '
                                </a>
                            </li>
                        ';
                }
                $view = '
                            <li>
                                <a class="edit dropdown-item border-bottom" href="' . route('kreditnasabah.show', $query) . '" data-toggle="tooltip" data-id="' . $query->id . '">
                                    <i class="bx bx-show fs-20"></i> ' . __("Lihat") . '
                                </a>
                            </li>
                        ';
                // } else {
                //     $update = '
                //             <li>
                //                 <a class="dropdown-item border-bottom">
                //                     <i class="bx bx-minus-circle fs-20"></i> ' . __("Tidak Ada Aksi") . '
                //                 </a>
                //             </li>
                //         ';
                // }
                if (canAccess(['kredit nasabah update'])) {
                    return '<div class="dropdown">
                                <button class="btn btn-outline-primary btn-sm btn-wave waves-effect waves-light dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bx bx-cog fs-16"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" style="">' .
                        (!empty($update) ? $update : '') .
                        (!empty($view) ? $view : '') . '
                                </ul>
                            </div>';
                } else {
                    return '<div class="dropdown">
                                <button class="btn btn-outline-primary btn-sm btn-wave waves-effect waves-light dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bx bx-cog fs-16"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" style="">' .
                        (!empty($view) ? $view : '') . '
                                </ul>
                            </div>';
                }
            })
            ->editColumn('status_kredit', function ($query) {
                return '<h6><span class="badge bg-' . setStatusKreditBadge($query->status_kredit) . '">' . $query->status_kredit . '</span></h6>';
            })
            ->editColumn('status_kirim_barang', function ($query) {
                return '<h6><span class="badge bg-' . setStatusKirimBarangBadge($query->status_kirim_barang) . '">' . $query->status_kirim_barang . '</span></h6>';
            })
            ->editColumn('qty', function ($query) {
                return '<a href="javascript:void(0)" id="id_kredit_nasabah" data-toggle="tooltip" title="Detail" data-id="' . $query->id . '"><u>' . $query->qty . '</u></a>';
            })
            ->rawColumns(['action'])
            ->escapeColumns([])
            ->make(true);
    }

    public function data_lunas(Request $request)
    {
        $query = ViewKreditNasabah::periode()->where('status_kredit', 'Lunas')->orderBy('tgl_incoming', 'DESC');

        return datatables($query)
            ->addIndexColumn()
            ->addColumn('action', function ($query) {
                // if ($query->status_lunas == 'Belum Lunas' || $query->status_kirim_barang == 'Belum Dikirim') {
                if (canAccess(['kredit nasabah update'])) {
                    // $update = '
                    //     <li>
                    //         <a class="edit dropdown-item border-bottom" href="javascript:void(0);" data-toggle="tooltip" data-id="' . $query->id . '">
                    //             <i class="bx bx-edit-alt fs-20"></i> ' . __("Perbarui") . '
                    //         </a>
                    //     </li>
                    // ';
                    $update = '
                            <li>
                                <a class="edit dropdown-item border-bottom" href="' . route('kreditnasabah.edit', $query) . '" data-toggle="tooltip" data-id="' . $query->id . '">
                                    <i class="bx bx-edit-alt fs-20"></i> ' . __("Perbarui") . '
                                </a>
                            </li>
                        ';
                }
                // } else {
                //     $update = '
                //             <li>
                //                 <a class="dropdown-item border-bottom">
                //                     <i class="bx bx-minus-circle fs-20"></i> ' . __("Tidak Ada Aksi") . '
                //                 </a>
                //             </li>
                //         ';
                // }
                if (canAccess(['kredit nasabah update'])) {
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
            ->editColumn('status_kredit', function ($query) {
                return '<h6><span class="badge bg-' . setStatusKreditBadge($query->status_kredit) . '">' . $query->status_kredit . '</span></h6>';
            })
            ->editColumn('status_kirim_barang', function ($query) {
                return '<h6><span class="badge bg-' . setStatusKirimBarangBadge($query->status_kirim_barang) . '">' . $query->status_kirim_barang . '</span></h6>';
            })
            ->editColumn('qty', function ($query) {
                return '<a href="javascript:void(0)" id="id_kredit_nasabah" data-toggle="tooltip" title="Detail" data-id="' . $query->id . '"><u>' . $query->qty . '</u></a>';
            })
            ->rawColumns(['action'])
            ->escapeColumns([])
            ->make(true);
    }

    public function show_detail(string $id)
    {
        $kredit_detail = DB::table('kredit_detail')
            ->where('id_kredit_nasabah', $id)
            ->orderBy('id', 'ASC')
            ->get();
        return response()->json($kredit_detail);
    }

    public function detail_data($filter)
    {
        switch ($filter) {
            case 'nasabah':
                $query = ViewKreditNasabah::periode()->orderBy('tgl_incoming', 'DESC');
                // $query = DB::table('view_kredit_nasabah')
                //             ->orderBy('tgl_incoming', 'DESC')
                //             ->get();
                break;
            case 'kredit':
                $query = ViewKreditNasabah::periode()->orderBy('tgl_incoming', 'DESC');
                // $query = DB::table('view_kredit_nasabah')
                //             ->orderBy('tgl_incoming', 'DESC')
                //             ->get();
                break;
            case 'keuntungan':
                $query = ViewKreditNasabah::periode()->orderBy('tgl_incoming', 'DESC');
                // $query = DB::table('view_kredit_nasabah')
                //             ->orderBy('tgl_incoming', 'DESC')
                //             ->get();
                break;
            case 'sudah-lunas':
                $query = ViewKreditNasabah::periode()->where('status_kredit', '=', 'Lunas')->orderBy('tgl_incoming', 'DESC');
                // $query = DB::table('view_kredit_nasabah')
                //             ->where('status_lunas', 'Lunas')
                //             ->orderBy('tgl_incoming', 'DESC')
                //             ->get();
                break;
            case 'belum-lunas':
                $query = ViewKreditNasabah::periode()->where('status_kredit', '=', 'Berjalan')->orderBy('tgl_incoming', 'DESC');
                // $query = DB::table('view_kredit_nasabah')
                //             ->where('status_lunas', 'Berjalan')
                //             ->orderBy('tgl_incoming', 'DESC')
                //             ->get();
                break;
            default:
                $query = "";
        }

        return datatables($query)
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }
}
