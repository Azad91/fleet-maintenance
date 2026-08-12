<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BusStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'xett_no' => 'nullable|string|max:255',
            'dqn' => 'required|unique:buses,dqn',
            'km' => 'nullable|integer|min:0',
        ];
    }
}
