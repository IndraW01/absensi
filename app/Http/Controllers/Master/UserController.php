<?php

namespace App\Http\Controllers\Master;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\DatatableTrait;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    use DatatableTrait;

    public function index()
    {
        return view('master.user.index');
    }

    public function show(User $user)
    {
        return view('master.user.show', ['user' => $user->load(['userDetail'])]);
    }

    public function datatableUsers(Request $request)
    {
        if ($request->ajax()) {
            return $this->getUsers();
        }
    }

    public function editUserRole(User $user)
    {
        return view('master.user.edit-user-role', [
            'user' => $user,
            'userRole' => $user->getRoleNames()->first(),
            'roles' => Role::get()
        ]);
    }

    public function updateUserRole(Request $request, User $user)
    {
        $validateRole = $request->validate(['role' => ['required', Rule::exists('roles', 'name')]]);
        $user->syncRoles($validateRole);

        Alert::success('Berhasil', 'User Role berhasil diubah');
        return redirect()->route('master.user.index');
    }
}
