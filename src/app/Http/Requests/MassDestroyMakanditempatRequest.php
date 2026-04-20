<?php

namespace App\Http\Requests;

use Gate;
use App\Models\OrderDitempat;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyMakanditempatRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('order_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:orderditempats,id',
        ];
    }
}
