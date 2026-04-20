<?php

namespace App\Http\Requests;

use Gate;
use App\Models\CategoryProduct;
use Illuminate\Http\Response;
use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryProductRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('categoryproduct_create');
    }

    public function rules()
    {
        return [

        ];
    }
}
