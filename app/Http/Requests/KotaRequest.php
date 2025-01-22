<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KotaRequest extends FormRequest
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
                    'nama' => ['required', 'string', 'max:255', 'unique:kota,nama'],
                ];
                break;

            case 'PATCH':
            case 'PUT':
                return [
                    'nama' => ['required', 'string', 'max:255', 'unique:kota,nama,' . $this->kota->id],
                ];
                break;
        }
    }
}
