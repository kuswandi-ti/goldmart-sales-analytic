<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingEmailUpdateRequest extends FormRequest
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
            'mail_type' => ['required'],
            'mail_host' => ['required'],
            'mail_username' => ['required'],
            'mail_password' => ['required'],
            'mail_encryption' => ['required'],
            'mail_port' => ['required', 'numeric'],
            'mail_from_address' => ['required', 'email'],
            'mail_from_name' => ['required'],
        ];
    }
}
