<?php

namespace App\Http\Requests;

use Gate;
use App\Models\DataKaryawan;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyDataKaryawanRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('karyawan_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:data_karyawans,id',
        ];
    }
}
