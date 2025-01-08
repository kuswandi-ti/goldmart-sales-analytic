<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TipeBarangRequest extends FormRequest
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
                    'id_brand' => ['required', 'string', 'max:255'],
                    'nama' => ['required', 'string', 'max:255', 'unique:tipe_barang,id'],
                ];
                break;

            case 'PATCH':
            case 'PUT':
                $tipebarang_id = $this->route('tipebarang');
                return [
                    'id_brand' => ['required', 'string', 'max:255', 'unique:tipe_barang,id,' . $tipebarang_id],
                    'nama' => ['required', 'string', 'max:255'],
                ];
                break;
        }
    }
}
