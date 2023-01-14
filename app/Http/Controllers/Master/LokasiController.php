<?php

namespace App\Http\Controllers\Master;

use App\Models\Lokasi;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\DatatableTrait;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class LokasiController extends Controller
{
    use DatatableTrait;

    public function index()
    {
        return view('master.lokasi.index');
    }

    public function datatableLokasis(Request $request)
    {
        if ($request->ajax()) {
            return $this->getLokasis();
        }
    }

    public function create()
    {
        return view('master.lokasi.create');
    }

    public function store(Request $request)
    {
        $validateLokasi = $request->validate([
            'name' => ['required'],
            'slug' => ['required', Rule::unique('lokasis', 'slug')],
            'latitude_kantor' => ['required'],
            'longitude_kantor' => ['required'],
            'radius' => ['required']
        ]);

        $lokasi = Lokasi::create($validateLokasi);

        Alert::success('Berhasil', 'Lokasi ' . $lokasi->name . ' berhasil ditambahkan');
        return redirect()->route('master.lokasi.index');
    }

    public function edit(Lokasi $lokasi)
    {
        return view('master.lokasi.edit', ['lokasi' => $lokasi]);
    }

    public function update(Request $request, Lokasi $lokasi)
    {
        $validateLokasi = $request->validate([
            'name' => ['required'],
            'slug' => ['required', Rule::unique('lokasis', 'slug')->ignore($lokasi->id)],
            'latitude_kantor' => ['required'],
            'longitude_kantor' => ['required'],
            'radius' => ['required']
        ]);

        $lokasi->update($validateLokasi);

        Alert::success('Berhasil', 'Lokasi ' . $lokasi->name . ' berhasil diubah');
        return redirect()->route('master.lokasi.index');
    }

    public function destroy(Lokasi $lokasi)
    {
        $lokasi->delete();

        Alert::success('Berhasil', 'Lokasi ' . $lokasi->name . ' berhasil dihapus');
        return redirect()->route('master.lokasi.index');
    }

    public function slug(Request $request)
    {
        if ($request->action && Lokasi::query()->where('slug', $request->name)->where('id', $request->id)->exists()) {
            return response()->json($request->name);
        } else if (Lokasi::query()->where('slug', $request->name)->exists()) {
            return response()->json(Str::slug($request->name . '-' . random_int(0, 100)));
        } else {
            return response()->json(Str::slug($request->name));
        }
    }
}
