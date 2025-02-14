<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Traits\FileUploadTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfilePasswordUpdateRequest;
use App\Http\Requests\ProfilePersonalUpdateRequest;

class ProfileController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        // $order = Order::all();

        // return view('profile.index', compact('user', 'order'));

        return view('profile.index', compact('user'));
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProfilePersonalUpdateRequest $request, string $id)
    {
        $imagePath = $this->handleImageUpload($request, 'image', $request->old_image, 'profile');

        $user = User::findOrFail($id);

        $user->name = $request->name;
        $user->image = !empty($imagePath) ? $imagePath : $request->old_image;
        $user->updated_at = saveDateTimeNow();
        $user->updated_by = auth()->user()->name;

        $user->save();

        return redirect()->back()->with('success', __('Data profil berhasil diperbarui'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function updatePassword(ProfilePasswordUpdateRequest $request, string $id)
    {
        $user = User::findOrFail($id);
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->back()->with('success', __('Data password berhasil diperbarui'));
    }
}
