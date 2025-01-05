<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
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
            'email' => ['required', 'email', 'max:255'],
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
        if (!Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }
    }
}
