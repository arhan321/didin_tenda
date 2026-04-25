<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\Test;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class TestController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('test_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tests = Test::all();

        return view('admin.tests.index', compact('tests'));
    }

    public function create()
    {
        abort_if(Gate::denies('test_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.tests.create');
    }

    public function store()
    {
        Test::create([
            'nama' => request()->input('nama'),
            'umur' => request()->input('umur'),
        ]);

        return redirect()->route('admin.tests.index');
    }

    public function edit(Test $test)
    {
        abort_if(Gate::denies('test_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.tests.edit', compact('test'));
    }

    public function update(Test $test)
    {
        $test->update([
            'nama' => request()->input('nama'),
            'umur' => request()->input('umur'),
        ]);

        return redirect()->route('admin.tests.index');
    }

    public function show(Test $test)
    {
        abort_if(Gate::denies('test_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.tests.show', compact('test'));
    }

    public function destroy(Test $test)
    {
        abort_if(Gate::denies('test_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $test->delete();

        return back();
    }

    public function massDestroy()
    {
        $tests = Test::whereIn('id', request('ids', []))->get();

        foreach ($tests as $test) {
            $test->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}