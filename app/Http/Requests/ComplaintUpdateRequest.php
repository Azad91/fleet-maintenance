<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ComplaintUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'bus_id' => 'required|exists:buses,id',
            'yer' => 'required|in:yol,qaraj',
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
            'kim_is_gorub' => 'nullable|string|max:255',
            'detallar' => 'nullable|array',
            'detallar.*.kodu' => 'nullable|string|max:255',
            'detallar.*.adi' => 'nullable|string|max:255',
            'detallar.*.depo_miqdari' => 'nullable|integer|min:0',
            'detallar.*.islenen_miqdar' => 'nullable|integer|min:0',
            'detallar.*.qeyd' => 'nullable|string',
            'detallar.*.shikayet_index' => 'nullable|integer|min:0',
        ];
    }

    public function withValidator($validator)
    {
        $validator->sometimes('surucu_adi', 'required|string|max:255', function ($input) {
            return $input->yer == 'yol';
        });

        $validator->sometimes('bildirilme_tarix', 'required|date', function ($input) {
            return $input->yer == 'yol';
        });

        $validator->sometimes('bildirilme_saat', 'required|date_format:H:i', function ($input) {
            return $input->yer == 'yol';
        });
    }
}
