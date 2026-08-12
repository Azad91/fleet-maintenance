<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WarehouseStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kod' => 'required|unique:warehouses,kod',
            'ad' => 'required|string|max:255',
            'miqdar' => 'required|integer|min:0',
            'olcu_vahidi' => 'nullable|string|max:50',
            'qiymet' => 'nullable|numeric|min:0',
        ];
    }
}
