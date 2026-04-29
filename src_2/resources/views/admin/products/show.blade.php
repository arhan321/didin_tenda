@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.product.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.products.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.product.fields.id') }}
                        </th>
                        <td>
                            {{ $product->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.product.fields.image') }}
                        </th>
                        <td>
                            @if($product->image)
                                <a href="{{ $product->image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $product->image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.product.fields.name') }}
                        </th>
                        <td>
                            {{ $product->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.product.fields.category') }}
                        </th>
                        <td>
                            {{ App\Models\Product::CATEGORY_SELECT[$product->category] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.product.fields.description') }}
                        </th>
                        <td>
                            {{ $product->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.product.fields.tahun') }}
                        </th>
                        <td>
                            {{ $product->tahun }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.product.fields.warna') }}
                        </th>
                        <td>
                            {{ $product->warna }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.product.fields.tipe') }}
                        </th>
                        <td>
                            {{ $product->tipe }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.product.fields.mesin') }}
                        </th>
                        <td>
                            {{ $product->mesin }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.product.fields.cc') }}
                        </th>
                        <td>
                            {{ $product->cc }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.product.fields.pajak') }}
                        </th>
                        <td>
                            {{ $product->pajak }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.product.fields.transmition') }}
                        </th>
                        <td>
                            {{ App\Models\Product::TRANSMITION[$product->transmition] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.product.fields.price') }}
                        </th>
                        <td>
                            {{ $product->price ? number_format($product->price, 2, ',', '.') : '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.product.fields.stock') }}
                        </th>
                        <td>
                            {{ $product->stock }}
                        </td>
                    </tr>
                 
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.products.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection