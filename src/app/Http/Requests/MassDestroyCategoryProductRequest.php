<?php

namespace App\Http\Requests;

use Gate;
use App\Models\CategoryProduct;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCategoryProductRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('categoryproduct_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:categoryproducts,id',
        ];
    }
}
