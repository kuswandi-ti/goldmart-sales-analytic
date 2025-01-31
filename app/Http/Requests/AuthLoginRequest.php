<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class AuthLoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            // 'email' => ['required', 'email', 'max:255'],
            'email' => ['required', 'max:255'],
            'password' => ['required'],
        ];
    }

    // public function failedValidation(Validator $validator)
    // {
    //     throw new HttpResponseException(response()->json([
    //         'success'   => false,
    //         'message'   => 'Validation errors',
    //         'data'      => $validator->errors()
    //     ]));
    // }

    // public function messages()
    // {
    //     return [
    //         'email.required' => __('Email harus diisi'),
    //         'email.email' => __('Format email tidak valid'),
    //         'email.max' => __('Maksimal email adalah 255 karakter'),
    //         'email.exists' => __('Email tidak terdaftar'),
    //         'password.required' => __('Password harus diisi'),
    //     ];
    // }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $login_name = filter_var($this->input("email"), FILTER_VALIDATE_EMAIL) ? "email" : "nik";

        $this->merge([
            $login_name => $this->input("email")
        ]);

        if (! Auth::attempt($this->only($login_name, 'password'), $this->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        } else {
            $query = User::select(
                'users.id_sales_person AS id_sales_person',
                'users.kode_sales AS kode_sales',
                'users.nama_sales AS nama_sales',
                'sales_person.id_store AS id_store',
                'sales_person.kode_store AS kode_store',
                'sales_person.nama_store AS nama_store',
                'sales_person.kota_store AS kota_store'
            )
                ->leftJoin('sales_person', 'users.id_sales_person', '=', 'sales_person.id')
                ->where('users.email', $this->email)
                ->first();
            if (!$query) {
                $query = User::select(
                    'users.id_sales_person AS id_sales_person',
                    'users.kode_sales AS kode_sales',
                    'users.nama_sales AS nama_sales',
                    'sales_person.id_store AS id_store',
                    'sales_person.kode_store AS kode_store',
                    'sales_person.nama_store AS nama_store',
                    'sales_person.kota_store AS kota_store'
                )
                    ->leftJoin('sales_person', 'users.id_sales_person', '=', 'sales_person.id')
                    ->where('users.nik', $this->email)
                    ->first();
            }

            Session::put([
                'sess_id_sales_person' => $query['id_sales_person'],
                'sess_kode_sales' => $query['kode_sales'],
                'sess_nama_sales' => $query['nama_sales'],
                'sess_id_store' => $query['id_store'],
                'sess_kode_store' => $query['kode_store'],
                'sess_nama_store' => $query['nama_store'],
                'sess_kota_store' => $query['kota_store'],
            ]);
        }

        // if (!Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
        //     throw ValidationException::withMessages([
        //         'email' => trans('auth.failed'),
        //     ]);
        // } else {
        //     $query = User::select(
        //         'users.id_sales_person AS id_sales_person',
        //         'users.kode_sales AS kode_sales',
        //         'users.nama_sales AS nama_sales',
        //         'sales_person.id_store AS id_store',
        //         'sales_person.kode_store AS kode_store',
        //         'sales_person.nama_store AS nama_store',
        //         'sales_person.kota_store AS kota_store'
        //     )
        //         ->leftJoin('sales_person', 'users.id_sales_person', '=', 'sales_person.id')
        //         ->where('users.email', $this->email)
        //         ->first();

        //     Session::put([
        //         'sess_id_sales_person' => $query['id_sales_person'],
        //         'sess_kode_sales' => $query['kode_sales'],
        //         'sess_nama_sales' => $query['nama_sales'],
        //         'sess_id_store' => $query['id_store'],
        //         'sess_kode_store' => $query['kode_store'],
        //         'sess_nama_store' => $query['nama_store'],
        //         'sess_kota_store' => $query['kota_store'],
        //     ]);
        // }
    }
}
