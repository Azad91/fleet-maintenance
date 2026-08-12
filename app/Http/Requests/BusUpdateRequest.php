<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BusUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $busId = $this->route('bus');

        return [
            'xett_no' => 'nullable|string|max:255',
            'dqn' => 'required|unique:buses,dqn,' . $busId,
            'km' => 'nullable|integer|min:0',
        ];
    }
}
