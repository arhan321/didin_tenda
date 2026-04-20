<?php

namespace App\Http\Requests;

use Gate;
use App\Models\OrderDitempat;
use Illuminate\Http\Response;
use Illuminate\Foundation\Http\FormRequest;

class StoreMakanditempatRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('order_create');
    }

    public function rules()
    {
        return [
            // 'nama_pemesan' => 'required|string',
            // 'product' => 'required|array',
            // 'product.*' => 'exists:products,id',
            // 'qty' => 'required|array',
            // 'qty.*' => 'required|integer|min:1',
            // 'price' => 'required|integer|min:0',
            // 'jam_pesan' => 'nullable|date_format:H:i',
            // 'tanggal_pesan' => 'nullable|date',
        ];
    }
}
