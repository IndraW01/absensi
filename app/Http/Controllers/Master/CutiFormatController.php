<?php

namespace App\Http\Controllers\Master;

use App\Models\CutiFormat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class CutiFormatController extends Controller
{
    public function index()
    {
        $cutiFormat = CutiFormat::query()->first();
        return view('master.cutiFormat.index', ['cutiFormat' => $cutiFormat]);
    }

    public function edit(Request $request, CutiFormat $cutiFormat)
    {
        $validateCutiFormat = $request->validate([
            'cuti' => ['required', 'numeric', 'integer', 'min:1'],
            'cuti_bersama' => ['required', 'numeric', 'integer', 'min:1'],
            'cuti_menikah' => ['required', 'numeric', 'integer', 'min:1'],
            'cuti_melahirkan' => ['required', 'numeric', 'integer', 'min:1'],
        ]);

        $cutiFormat->update($validateCutiFormat);

        Alert::success('Berhasil', 'Cuti berhasil diformat');
        return redirect()->route('master.cuti.format.index');
    }
}
