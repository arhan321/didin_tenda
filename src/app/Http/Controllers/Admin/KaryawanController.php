<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\Karyawan;
use App\Models\Position;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\StoreDataKaryawanRequest;
use App\Http\Requests\UpdateDataKaryawanRequest;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyDataKaryawanRequest;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class KaryawanController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('karyawan_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $karyawans = Karyawan::with(['position'])->get();

        return view('admin.karyawans.index', compact('karyawans'));
    }

    public function create()
    {
        abort_if(Gate::denies('karyawan_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $positions = Position::all()->pluck('nama_posisi', 'id')->prepend(trans('global.pleaseSelect'), '');
        $positionsWithSalaries = Position::all()->pluck('total_gaji', 'id'); // Gaji berdasarkan posisi
        
        // Mengirimkan ke view
        return view('admin.karyawans.create', compact('positions', 'positionsWithSalaries'));
    }

    public function store(StoreDataKaryawanRequest $request)
    {
        // Cari gaji berdasarkan posisi
        $position = Position::find($request->input('position_id'));
        $gaji = $position->total_gaji;
    
        // Buat karyawan baru dengan gaji otomatis dari posisi
        $karyawan = new Karyawan();
        $karyawan->nama_karyawan = $request->input('nama_karyawan');
        $karyawan->position_id = $request->input('position_id');
        $karyawan->gaji = $gaji; // Simpan gaji dari position
        $karyawan->alamat = $request->input('alamat');
        $karyawan->no_telp = $request->input('no_telp');
        $karyawan->email = $request->input('email');
        $karyawan->jenis_kelamin = $request->input('jenis_kelamin');
        $karyawan->tanggal_lahir = $request->input('tanggal_lahir');
        $karyawan->tempat_lahir = $request->input('tempat_lahir');
        $karyawan->status = $request->input('status'); // Simpan status karyawan
    
        $karyawan->save();
    
        // Proses media upload jika ada gambar yang diupload
        if ($request->input('image', false)) {
            $karyawan->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }
    
        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $karyawan->id]);
        }
    
        return redirect()->route('admin.karyawans.index');
    }
    
    

    public function edit(Karyawan $karyawan)
    {
        abort_if(Gate::denies('karyawan_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $positions = Position::all()->pluck('nama_posisi', 'id')->prepend(trans('global.pleaseSelect'), '');
        $positionsWithSalaries = Position::all()->pluck('total_gaji', 'id'); // Gaji berdasarkan posisi
        
        $karyawan->load('position');
        
        return view('admin.karyawans.edit', compact('karyawan', 'positions', 'positionsWithSalaries'));
    }

    public function update(UpdateDataKaryawanRequest $request, Karyawan $karyawan)
    {
        // Cari gaji berdasarkan posisi
        $position = Position::find($request->input('position_id'));
        $gaji = $position->total_gaji;
    
        // Update karyawan dengan gaji otomatis dari posisi
        $karyawan->update([
            'nama_karyawan' => $request->input('nama_karyawan'),
            'position_id' => $request->input('position_id'),
            'gaji' => $gaji, // Update gaji berdasarkan posisi
            'alamat' => $request->input('alamat'),
            'no_telp' => $request->input('no_telp'),
            'email' => $request->input('email'),
            'jenis_kelamin' => $request->input('jenis_kelamin'),
            'tanggal_lahir' => $request->input('tanggal_lahir'),
            'tempat_lahir' => $request->input('tempat_lahir'),
            'status' => $request->input('status'), // Update status karyawan
        ]);
    
        // Proses media upload jika ada gambar yang diupload
        if ($request->input('image', false)) {
            if (!$karyawan->image || $request->input('image') !== $karyawan->image->file_name) {
                if ($karyawan->image) {
                    $karyawan->image->delete();
                }
                $karyawan->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
            }
        } elseif ($karyawan->image) {
            $karyawan->image->delete();
        }
    
        return redirect()->route('admin.karyawans.index');
    }
    
    

    public function show(Karyawan $karyawan)
    {
        abort_if(Gate::denies('karyawan_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $karyawan->load('position');

        return view('admin.karyawans.show', compact('karyawan'));
    }

    public function destroy(Karyawan $karyawan)
    {
        abort_if(Gate::denies('karyawan_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $karyawan->delete();

        return back();
    }

    public function massDestroy(MassDestroyDataKaryawanRequest $request)
    {
        $karyawans = Karyawan::find(request('ids'));

        foreach ($karyawans as $karyawan) {
            $karyawan->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('karyawan_create') && Gate::denies('karyawan_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model = new Karyawan();
        $model->id = $request->input('crud_id', 0);
        $model->exists = true;
        $media = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
