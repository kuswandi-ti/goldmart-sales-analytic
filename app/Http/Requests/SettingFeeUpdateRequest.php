<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingFeeUpdateRequest extends FormRequest
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
            'fee_loan_regular' => ['required', 'numeric'],
            'fee_loan_funding' => ['required', 'numeric'],
            'fee_loan_social' => ['required', 'numeric'],
        ];
    }
}
