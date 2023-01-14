<?php

namespace App\Http\Controllers\Master;

use App\Models\Status;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\DatatableTrait;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class StatusController extends Controller
{
    use DatatableTrait;

    public function index()
    {
        return view('master.status.index');
    }

    public function datatableStatus(Request $request)
    {
        if ($request->ajax()) {
            return $this->getStatus();
        }
    }

    public function create()
    {
        return view('master.status.create');
    }

    public function store(Request $request)
    {
        $validateStatus = $request->validate([
            'name' => ['required'],
            'slug' => ['required', Rule::unique('statuses', 'slug')],
        ]);

        $status = Status::create($validateStatus);

        Alert::success('Berhasil', 'Status ' . $status->name . ' berhasil ditambahkan');
        return redirect()->route('master.status.index');
    }

    public function edit(Status $status)
    {
        return view('master.status.edit', ['status' => $status]);
    }

    public function update(Request $request, Status $status)
    {
        $validateStatus = $request->validate([
            'name' => ['required'],
            'slug' => ['required', Rule::unique('statuses', 'slug')->ignore($status->id)],
        ]);

        $status->update($validateStatus);

        Alert::success('Berhasil', 'Status ' . $status->name . ' berhasil diubah');
        return redirect()->route('master.status.index');
    }

    public function destroy(Status $status)
    {
        $status->delete();

        Alert::success('Berhasil', 'Status ' . $status->name . ' berhasil dihapus');
        return redirect()->route('master.status.index');
    }

    public function slug(Request $request)
    {
        if ($request->action && Status::query()->where('slug', $request->name)->where('id', $request->id)->exists()) {
            return response()->json($request->name);
        } else if (Status::query()->where('slug', $request->name)->exists()) {
            return response()->json(Str::slug($request->name . '-' . random_int(0, 100)));
        } else {
            return response()->json(Str::slug($request->name));
        }
    }
}
