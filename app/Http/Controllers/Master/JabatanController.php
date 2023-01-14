<?php

namespace App\Http\Controllers\Master;

use App\Models\Jabatan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\DatatableTrait;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class JabatanController extends Controller
{
    use DatatableTrait;

    public function index()
    {
        return view('master.jabatan.index');
    }

    public function datatableJabatans(Request $request)
    {
        if ($request->ajax()) {
            return $this->getJabatans();
        }
    }

    public function create()
    {
        return view('master.jabatan.create');
    }

    public function store(Request $request)
    {
        $validateJabatan = $request->validate([
            'name' => ['required'],
            'slug' => ['required', Rule::unique('jabatans', 'slug')],
        ]);

        $jabatan = Jabatan::create($validateJabatan);

        Alert::success('Berhasil', 'Jabatan ' . $jabatan->name . ' berhasil ditambahkan');
        return redirect()->route('master.jabatan.index');
    }

    public function edit(Jabatan $jabatan)
    {
        return view('master.jabatan.edit', ['jabatan' => $jabatan]);
    }

    public function update(Request $request, Jabatan $jabatan)
    {
        $validateJabatan = $request->validate([
            'name' => ['required'],
            'slug' => ['required', Rule::unique('jabatans', 'slug')->ignore($jabatan->id)],
        ]);

        $jabatan->update($validateJabatan);

        Alert::success('Berhasil', 'Jabatan ' . $jabatan->name . ' berhasil diubah');
        return redirect()->route('master.jabatan.index');
    }

    public function destroy(Jabatan $jabatan)
    {
        $jabatan->delete();

        Alert::success('Berhasil', 'Jabatan ' . $jabatan->name . ' berhasil dihapus');
        return redirect()->route('master.jabatan.index');
    }

    public function slug(Request $request)
    {
        if ($request->action && Jabatan::query()->where('slug', $request->name)->where('id', $request->id)->exists()) {
            return response()->json($request->name);
        } else if (Jabatan::query()->where('slug', $request->name)->exists()) {
            return response()->json(Str::slug($request->name . '-' . random_int(0, 100)));
        } else {
            return response()->json(Str::slug($request->name));
        }
    }
}
