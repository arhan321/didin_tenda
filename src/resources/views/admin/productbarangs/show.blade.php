@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.productbarang.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                {{-- Tombol kembali ke list --}}
                <a class="btn btn-default" href="{{ route('admin.productbarangs.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    {{-- ID Produk --}}
                    <tr>
                        <th>
                            {{ trans('cruds.productbarang.fields.id') }}
                        </th>
                        <td>
                            {{ $productbarang->id }}
                        </td>
                    </tr>
                    {{-- Nama Produk --}}
                    <tr>
                        <th>
                            {{ trans('cruds.productbarang.fields.name') }}
                        </th>
                        <td>
                            {{ $productbarang->name }}
                        </td>
                    </tr>
                    {{-- Harga Beli --}}
                    <tr>
                        <th>
                            {{ trans('cruds.productbarang.fields.harga_beli') }}
                        </th>
                        <td>
                            {{-- Menampilkan format harga, contoh: Rp 10.000,00 --}}
                            Rp {{ number_format($productbarang->harga_beli, 2, ',', '.') }}
                        </td>
                    </tr>
                    {{-- Harga Jual --}}
                    <tr>
                        <th>
                            {{ trans('cruds.productbarang.fields.harga_jual') }}
                        </th>
                        <td>
                            Rp {{ number_format($productbarang->harga_jual, 2, ',', '.') }}
                        </td>
                    </tr>
                    {{-- Stock --}}
                    <tr>
                        <th>
                            {{ trans('cruds.productbarang.fields.stock') }}
                        </th>
                        <td>
                            {{ $productbarang->stock }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                {{-- Tombol kembali ke list (duplikat di bawah) --}}
                <a class="btn btn-default" href="{{ route('admin.productbarangs.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
