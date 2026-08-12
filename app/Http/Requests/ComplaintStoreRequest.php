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

    public function messages(): array
    {
        return [
            'bus_id.required' => 'Avtobus seçilməlidir.',
            'bus_id.exists' => 'Seçilən avtobus mövcud deyil.',
            'yer.required' => 'Yer seçilməlidir.',
            'yer.in' => 'Yer yalnız "yol" və ya "qaraj" ola bilər.',
            'shikayet.*.max' => 'Hər şikayət 1000 simvoldan çox ola bilməz.',
            'sikayet_tipi.in' => 'Şikayət tipi düzgün seçilməyib.',
            'bildirilme_tarix.date' => 'Bildirilme tarix düzgün formatda deyil.',
            'bildirilme_saat.date_format' => 'Bildirilme saat HH:MM formatında olmalıdır.',
            'is_baslama_tarix.date' => 'İşə başlama tarix düzgün formatda deyil.',
            'is_baslama_saat.date_format' => 'İşə başlama saat HH:MM formatında olmalıdır.',
            'is_bitme_tarix.date' => 'İşin bitdiyi tarix düzgün formatda deyil.',
            'is_bitme_saat.date_format' => 'İşin bitdiyi saat HH:MM formatında olmalıdır.',
            'status.required' => 'Status seçilməlidir.',
            'status.in' => 'Status düzgün seçilməyib.',
            'km.integer' => 'KM tam ədəd olmalıdır.',
            'km.min' => 'KM 0 - dan kiçik ola bilməz.',
            'kim_is_gorub.max' => 'Kim iş görüb 255 simvoldan çox ola bilməz.',
        ];
    }
}
