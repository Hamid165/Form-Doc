<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tanggal_peninjauan'   => 'required|date',
            'periode_peninjauan'   => 'required|string|max:255',
            'pelaksana_peninjauan' => 'required|string|max:255',
            'lokasi_peninjauan'    => 'required|string|max:255',
            'obyek_peninjauan'     => 'required|string|max:255',
            'deskripsi_sistem'     => 'required|string',
            'analisa'              => 'required|string',
            'tindak_lanjut'        => 'required|string',
        ];
    }
}