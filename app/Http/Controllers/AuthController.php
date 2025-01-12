<?php

namespace App\Http\Controllers;

use App\Models;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Mail\SendResetLinkMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthResetPasswordRequest;
use App\Http\Requests\AuthSendResetLinkRequest;

class AuthController extends Controller
{
    public function login()
    {
        Session::put('url.intended', URL::previous());

        if (!Auth::check()) {
            return view('auth.login');
        } else {
            // return redirect()->route('dashboard.index');
            return Redirect::to(Session::get('url.intended'));
        }
    }

    public function handleLogin(AuthLoginRequest $request)
    {
        $request->authenticate();

        return redirect()->route('dashboard.index');
        // return Redirect::to(Session::get('url.intended'));
    }

    public function forgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(AuthSendResetLinkRequest $request)
    {
        $token = Str::random(64);

        $user = User::where('email', $request->email)->first();
        $user->remember_token = $token;
        $user->save();

        Mail::to($request->email)->send(new SendResetLinkMail($token, $request->email));

        return redirect()->back()->with('success', __('Email telah dikirim ke alamat email Anda. Silakan periksa email Anda.'));
    }

    public function resetPassword($token)
    {
        return view('auth.reset-password', compact('token'));
    }

    public function handleResetPassword(AuthResetPasswordRequest $request)
    {
        $user = User::where([
            'email' => $request->email,
            'remember_token' => $request->token,
        ])->first();

        if (!$user) {
            return back()->with('error', __('Token is invalid !'));
        }

        $user->password = bcrypt($request->password);
        $user->remember_token = null;
        $user->save();

        return redirect()->route('login')->with('success', __('Reset kata sandi berhasil. Silakan login terlebih dahulu'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Session::flush();

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
