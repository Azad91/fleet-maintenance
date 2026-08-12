<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ComplaintStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'bus_id' => 'required|exists:buses,id',
            'yer' => 'nullable|string|in:yol,qaraj',
            'surucu_adi' => 'nullable|string|max:255',
            'shikayet' => 'nullable|array',
            'shikayet.*' => 'nullable|string|max:1000',
            'sikayet_tipi' => 'nullable|in:qezali,texniki_xidmet,nasazliq',
            'bildirilme_tarix' => 'nullable|date',
            'bildirilme_saat' => 'nullable|date_format:H:i',
            'is_baslama_tarix' => 'nullable|date',
            'is_baslama_saat' => 'nullable|date_format:H:i',
            'is_bitme_tarix' => 'nullable|date',
            'is_bitme_saat' => 'nullable|date_format:H:i',
            'status' => 'required|in:gözləmədə,işdə,həll olundu',
            'km' => 'nullable|integer|min:0',
            'qeyd' => 'nullable|string',
            'kim_is_gorub' => 'nullable|string|max:255',
        ];
    }
}
