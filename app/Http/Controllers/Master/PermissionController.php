<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Traits\DatatableTrait;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    use DatatableTrait;

    public function index()
    {
        return view('master.permission.index');
    }

    public function datatablePermissions(Request $request)
    {
        if ($request->ajax()) {
            return $this->getPermissions();
        }
    }

    public function create(Request $request)
    {
        return view('master.permission.create');
    }

    public function store(Request $request)
    {
        $validatePermission = $request->validate(['name' => ['required', 'lowercase']]);

        $permission = Permission::create($validatePermission);

        Alert::success('Berhasil', 'Permission ' . $permission->name . ' berhasil ditambahkan');
        return redirect()->route('master.permission.index');
    }

    public function edit(Permission $permission)
    {
        return view('master.permission.edit', ['permission' => $permission]);
    }

    public function update(Request $request, Permission $permission)
    {
        $validatePermission = $request->validate(['name' => ['required', 'lowercase', Rule::unique('permissions', 'name')->ignore($permission->id)]]);

        $permission->update($validatePermission);

        Alert::success('Berhasil', 'Permission ' . $permission->name . ' berhasil diubah');
        return redirect()->route('master.permission.index');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();

        Alert::success('Berhasil', 'Permission ' . $permission->name . ' berhasil dihapus');
        return redirect()->route('master.permission.index');
    }
}
