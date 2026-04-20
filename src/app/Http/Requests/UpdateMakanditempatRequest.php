<?php

namespace App\Http\Requests;

use Gate;
use App\Models\OrderDitempat;
use Illuminate\Http\Response;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMakanditempatRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('order_edit');
    }

    public function rules()
    {
        return [
            // 'title' => [
            //     'string',
            //     'required',
            // ],
            // 'image' => [
            //     'required',
            // ],
        ];
    }
}
