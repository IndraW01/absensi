<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Traits\DatatableTrait;
use Illuminate\Http\Request;

class AbsenController extends Controller
{
    use DatatableTrait;

    public function index()
    {
        return view('master.absen.index');
    }

    public function datatableAllAbsens(Request $request)
    {
        if ($request->ajax()) {
            if ($request->query('tanggal_awal') && $request->query('tanggal_akhir')) {
                return $this->getAllAbsen($request->query('tanggal_awal'), $request->query('tanggal_akhir'));
            } else {
                return $this->getAllAbsen();
            }
        }
    }

    public function filterAbsen(Request $request)
    {
        $request->validate([
            'tanggal_awal' => ['required', 'date'],
            'tanggal_akhir' => ['required', 'date', 'after_or_equal:tanggal_awal'],
        ]);

        return response()->json($request->all());
    }
}
