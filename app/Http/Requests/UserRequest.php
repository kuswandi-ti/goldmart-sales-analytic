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
                    'password' => ['required', 'string', 'max:255'],
                    'join_date' => ['required', 'date'],
                    'role' => ['required'],
                ];
                break;

            case 'PATCH':
            case 'PUT':
                return [
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'max:255', 'unique:users,email,' . $this->user->id],
                    'join_date' => ['required', 'date'],
                    'role' => ['required'],
                ];
                break;
        }
    }
}
