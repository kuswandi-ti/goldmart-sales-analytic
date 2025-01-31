<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'max:255', 'unique:users,email'],
                    'nik' => ['required', 'string', 'max:255', 'unique:users,nik'],
                    'password' => ['required', 'string', 'max:255'],
                    'sales_person' => ['required', 'numeric'],
                    'role' => ['required'],
                ];
                break;

            case 'PATCH':
            case 'PUT':
                return [
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'max:255', 'unique:users,email,' . $this->user->id],
                    'nik' => ['required', 'string', 'max:255', 'unique:users,nik,' . $this->user->id],
                    'sales_person' => ['required', 'numeric'],
                    'role' => ['required'],
                ];
                break;
        }
    }
}
