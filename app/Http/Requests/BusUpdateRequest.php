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
            'bus_project' => 'nullable|string|max:255',
            'vin'         => 'nullable|string|max:17',
            'uzunluq'     => 'nullable|numeric|min:0',
            'xett_no'     => 'nullable|string|max:255',
            'dqn'         => 'required|unique:buses,dqn,' . $busId,
            'motor_no'    => 'nullable|string|max:255',
            'aktiv'       => 'nullable|boolean',
        ];
    }
}
