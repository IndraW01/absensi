<?php

namespace App\Traits;

use App\Models\Jabatan;
use App\Models\Lokasi;
use App\Models\Shift;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

trait DatatableTrait
{
    public function getUsers()
    {
        $users = User::query()->with('roles')->latest()->get();
        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('role', function (User $user) {
                return '<span class="badge badge-primary text-bg-primary">' . $user->getUpperNameRole() . '</span>';
            })
            ->addColumn('action', function (User $user) {
                return view('components.partials.action', ['data' => $user->username, 'param' => $user, 'route' => 'user', 'title' => 'User']);
            })
            ->rawColumns(['role', 'action'])
            ->make(true);
    }

    public function getRoles()
    {
        $roles = Role::query()->latest()->get();
        return DataTables::of($roles)
            ->addIndexColumn()
            ->addColumn('action', function (Role $role) {
                return view('components.partials.action', ['data' => $role->name, 'param' => $role, 'route' => 'role', 'title' => 'Role']);
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function getPermissions()
    {
        $permissions = Permission::query()->with('roles')->latest()->get();
        return DataTables::of($permissions)
            ->addIndexColumn()
            ->addColumn('role', function (Permission $permission) {
                return view('components.partials.tampil-role', ['roles' => $permission->roles]);
            })
            ->addColumn('action', function (Permission $permission) {
                return view('components.partials.action', ['data' => $permission->name, 'route' => 'permission', 'title' => 'Permission']);
            })
            ->rawColumns(['role', 'action'])
            ->make(true);
    }

    public function getShifts()
    {
        $shifts = Shift::query()->oldest('jam_masuk')->get();
        return DataTables::of($shifts)
            ->addIndexColumn()
            ->addColumn('action', function (Shift $shift) {
                return view('components.partials.action', ['data' => $shift->slug, 'route' => 'shift', 'title' => 'Shift']);
            })
            ->make(true);
    }

    public function getLokasis()
    {
        $lokasis = Lokasi::query()->latest()->get();
        return DataTables::of($lokasis)
            ->addIndexColumn()
            ->addColumn('action', function (Lokasi $lokasi) {
                return view('components.partials.action', ['data' => $lokasi->slug, 'route' => 'lokasi', 'title' => 'Lokasi']);
            })
            ->make(true);
    }

    public function getStatus()
    {
        $statuses = Status::query()->latest()->get();
        return DataTables::of($statuses)
            ->addIndexColumn()
            ->addColumn('action', function (Status $status) {
                return view('components.partials.action', ['data' => $status->slug, 'route' => 'status', 'title' => 'Status']);
            })
            ->make(true);
    }

    public function getJabatans()
    {
        $jabatans = Jabatan::query()->latest()->get();
        return DataTables::of($jabatans)
            ->addIndexColumn()
            ->addColumn('action', function (Jabatan $jabatan) {
                return view('components.partials.action', ['data' => $jabatan->slug, 'route' => 'jabatan', 'title' => 'Jabatan']);
            })
            ->make(true);
    }
}
