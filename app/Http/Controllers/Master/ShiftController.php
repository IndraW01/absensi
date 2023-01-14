<?php

namespace App\Http\Controllers\Master;

use App\Models\Shift;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\DatatableTrait;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;

class ShiftController extends Controller
{
    use DatatableTrait;

    public function index()
    {
        return view('master.shift.index');
    }

    public function datatableShifts(Request $request)
    {
        if ($request->ajax()) {
            return $this->getShifts();
        }
    }

    public function create()
    {
        return view('master.shift.create');
    }

    public function store(Request $request)
    {
        $validateShift = $request->validate([
            'name' => ['required'],
            'slug' => ['required', Rule::unique('shifts', 'slug')],
            'jam_masuk' => ['required'],
            'jam_keluar' => ['required'],
        ]);

        $shift = Shift::create($validateShift);

        Alert::success('Berhasil', 'Shift ' . $shift->name . ' berhasil ditambahkan');
        return redirect()->route('master.shift.index');
    }

    public function edit(Shift $shift)
    {
        return view('master.shift.edit', ['shift' => $shift]);
    }

    public function update(Request $request, Shift $shift)
    {
        $validateShift = $request->validate([
            'name' => ['required'],
            'slug' => ['required', Rule::unique('shifts', 'slug')->ignore($shift->id)],
            'jam_masuk' => ['required'],
            'jam_keluar' => ['required'],
        ]);

        $shift->update($validateShift);

        Alert::success('Berhasil', 'Shift ' . $shift->name . ' berhasil diubah');
        return redirect()->route('master.shift.index');
    }

    public function destroy(Shift $shift)
    {
        $shift->delete();

        Alert::success('Berhasil', 'Shift ' . $shift->name . ' berhasil dihapus');
        return redirect()->route('master.shift.index');
    }

    public function slug(Request $request)
    {
        if ($request->action && Shift::query()->where('slug', $request->name)->where('id', $request->id)->exists()) {
            return response()->json($request->name);
        } else if (Shift::query()->where('slug', $request->name)->exists()) {
            return response()->json(Str::slug($request->name . '-' . random_int(0, 100)));
        } else {
            return response()->json(Str::slug($request->name));
        }
    }
}
