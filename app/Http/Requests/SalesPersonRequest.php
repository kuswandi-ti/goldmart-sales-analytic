<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalesPersonRequest extends FormRequest
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
        switch ($this->method()) {
            case 'POST':
                return [
                    'nama' => ['required', 'string', 'max:255'],
                    'nik' => ['required', 'string', 'max:50', 'unique:sales_person,nik'],
                ];
                break;

            case 'PATCH':
            case 'PUT':
                return [
                    'nama' => ['required', 'string', 'max:255'],
                    'nik' => ['required', 'string', 'max:50', 'unique:sales_person,nik,' . $this->salesperson->id],
                ];
                break;
        }
    }
}
