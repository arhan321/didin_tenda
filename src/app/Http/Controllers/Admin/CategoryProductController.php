<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\CategoryProduct;
use Illuminate\Http\Request;
// use App\Charts\ProductPieChart;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryProductRequest;
use App\Http\Requests\UpdateCategoryProductRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\MassDestroyCategoryProductRequest;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class CategoryProductController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {   
        abort_if(Gate::denies('categoryproduct_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categoryproducts = CategoryProduct::with(['media'])->get();

        return view('admin.categoryproducts.index', compact('categoryproducts'));
    }

    public function create()
    {
        abort_if(Gate::denies('categoryproduct_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.categoryproducts.create');
    }

    public function store(StoreCategoryProductRequest $request)
    {
        $categoryproduct = CategoryProduct::create($request->all());

        if ($request->input('image', false)) {
            $categoryproduct->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $categoryproduct->id]);
        }

        return redirect()->route('admin.categoryproducts.index');
    }

    public function edit(CategoryProduct $categoryproduct)
    {
        abort_if(Gate::denies('categoryproduct_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.categoryproducts.edit', compact('categoryproduct'));
    }

    public function update(UpdateCategoryProductRequest $request, CategoryProduct $categoryproduct)
    {
        $categoryproduct->update($request->all());

        if ($request->input('image', false)) {
            if (! $categoryproduct->image || $request->input('image') !== $categoryproduct->image->file_name) {
                if ($categoryproduct->image) {
                    $categoryproduct->image->delete();
                }
                $categoryproduct->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
            }
        } elseif ($categoryproduct->image) {
            $categoryproduct->image->delete();
        }

        return redirect()->route('admin.categoryproducts.index');
    }

    public function show(CategoryProduct $categoryproduct)
    {
        abort_if(Gate::denies('categoryproduct_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.categoryproducts.show', compact('categoryproduct'));
    }

    public function destroy(CategoryProduct $categoryproduct)
    {
        abort_if(Gate::denies('categoryproduct_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categoryproduct->delete();

        return back();
    }

    public function massDestroy(MassDestroyCategoryProductRequest $request)
    {
        $categoryproducts = CategoryProduct::find(request('ids'));

        foreach ($categoryproducts as $categoryproduct) {
            $categoryproduct->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

}