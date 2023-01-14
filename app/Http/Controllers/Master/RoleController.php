<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Traits\DatatableTrait;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    use DatatableTrait;

    public function index()
    {
        return view('master.role.index');
    }

    public function datatableRoles(Request $request)
    {
        if ($request->ajax()) {
            return $this->getRoles();
        }
    }

    public function create(Request $request)
    {
        return view('master.role.create');
    }

    public function store(Request $request)
    {
        $validateRole = $request->validate(['name' => ['required', 'lowercase']]);

        $role = Role::create($validateRole);

        Alert::success('Berhasil', 'Role ' . $role->name . ' berhasil ditambahkan');
        return redirect()->route('master.role.index');
    }

    public function edit(Role $role)
    {
        return view('master.role.edit', ['role' => $role]);
    }

    public function update(Request $request, Role $role)
    {
        $validateRole = $request->validate(['name' => ['required', 'lowercase', Rule::unique('roles', 'name')->ignore($role->id)]]);

        $role->update($validateRole);

        Alert::success('Berhasil', 'Role ' . $role->name . ' berhasil diubah');
        return redirect()->route('master.role.index');
    }

    public function destroy(Role $role)
    {
        $role->delete();

        Alert::success('Berhasil', 'Role ' . $role->name . ' berhasil dihapus');
        return redirect()->route('master.role.index');
    }

    public function editRolePermission(Role $role)
    {
        return view('master.role.edit-role-permission', [
            'role' => $role,
            'rolePermissions' => $role->permissions->pluck('name')->toArray(),
            'permissions' => Permission::get()
        ]);
    }

    public function updateRolePermission(Request $request, Role $role)
    {
        $validatePermission = $request->validate([
            'permission.*' => ['required', Rule::exists('permissions', 'name')],
            'permission' => 'required'
        ], ['permission.*.exists' => 'Permission :input yang dipilih tidak ditemukan']);

        $role->syncPermissions($validatePermission);

        Alert::success('Berhasil', 'Role ' . $role->name . ' berhasil update permission');
        return redirect()->route('master.role.index');
    }
}
