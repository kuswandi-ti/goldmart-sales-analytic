<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingGeneralUpdateRequest extends FormRequest
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
            'company_name' => ['required', 'string', 'max:255'],
            'site_title_2' => ['required', 'string', 'max:255'],
            'company_email' => ['required', 'string', 'max:255'],
        ];
    }
}
