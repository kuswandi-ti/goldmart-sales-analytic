<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
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
                    'permission_name' => ['required', 'string', 'max:255', 'unique:permissions,name'],
                    'group_name' => ['required', 'string', 'max:255'],
                ];
                break;

            case 'PATCH':
            case 'PUT':
                $permission_id = $this->route('permission');
                return [
                    'permission_name' => ['required', 'string', 'max:255', 'unique:permissions,name,' . $permission_id],
                    'group_name' => ['required', 'string', 'max:255'],
                ];
                break;
        }
    }
}
