<?php

namespace App\Http\Controllers\Master;

use App\Models\User;
use App\Models\Lokasi;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use App\Traits\DatatableTrait;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Models\CutiFormat;
use App\Services\UploadFotoService;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    use DatatableTrait;

    private UploadFotoService $uploadFileService;

    public function __construct()
    {
        $this->uploadFileService = new UploadFotoService;
    }

    public function index()
    {
        return view('master.user.index');
    }

    public function datatableUsers(Request $request)
    {
        if ($request->ajax()) {
            return $this->getUsers();
        }
    }

    public function create()
    {
        return view('master.user.create', [
            'jabatans' => Jabatan::query()->orderBy('name')->get(),
            'lokasis' => Lokasi::query()->orderBy('name')->get(),
            'cutiFormat' => CutiFormat::query()->first(),
        ]);
    }

    public function store(Request $request)
    {
        $validateUser = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'max:255', Rule::unique('users'), 'regex:/^\S*$/u'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')],
            'password' => ['required', Password::defaults()],
            'jabatan_id' => ['nullable', Rule::exists(Jabatan::class, 'id')],
            'lokasi_id' => ['nullable', Rule::exists(Lokasi::class, 'id')],
            'tempat_lahir' => ['nullable'],
            'tanggal_lahir' => ['nullable', 'date'],
            'alamat' => ['nullable', 'max:255'],
            'telepon' => ['nullable'],
            'status' => ['nullable', Rule::in(['Menikah', 'Belum Menikah'])],
            'jenis_kelamin' => ['nullable', Rule::in(['Laki-Laki', 'Perempuan'])],
            'foto' => ['nullable', 'image', 'max:2048', 'mimes:png,jpg,jpeg'],
            'cuti' => ['required', 'numeric', 'integer', 'min:1'],
            'cuti_bersama' => ['required', 'numeric', 'integer', 'min:1'],
            'cuti_menikah' => ['required', 'numeric', 'integer', 'min:1'],
            'cuti_melahirkan' => ['required', 'numeric', 'integer', 'min:1'],
        ]);

        DB::beginTransaction();
        try {
            $user = User::create(Arr::only($validateUser, ['name', 'username', 'email', 'password']));

            $user->assignRole('user');

            $validUserDetail = Arr::only($validateUser, ['jabatan_id', 'lokasi_id', 'tempat_lahir', 'tanggal_lahir', 'alamat', 'telepon', 'status', 'jenis_kelamin']);

            if ($request->has('foto')) {
                $namaFoto = $this->uploadFileService->upload($request->file('foto'));

                $validUserDetail['foto'] = $namaFoto;
            }

            $userDetail = $user->userDetail()->create($validUserDetail);

            $userDetail->userCuti()->create(Arr::only($validateUser, ['cuti', 'cuti_bersama', 'cuti_menikah', 'cuti_melahirkan']));

            DB::commit();

            Alert::success('Berhasil', 'User ' . $user->name . ' berhasil ditambah');
            return redirect()->route('master.user.index');
        } catch (Exception $message) {
            DB::rollBack();

            if ($request->has('foto') && isset($namaFoto)) {
                Storage::delete('public/profile/' . $namaFoto);
            }

            Log::error('Pesan Error Create User ' . $message->getMessage() . ' Line ' . $message->getLine());

            Alert::error('Gagal', 'User gagal ditambah');
            return redirect()->route('master.user.index');
        }
    }

    public function show(User $user)
    {
        return view('master.user.show', ['user' => $user->load(['userDetail', 'userCuti'])]);
    }

    public function edit(User $user)
    {
        return view('master.user.edit', [
            'user' => $user,
            'jabatans' => Jabatan::query()->orderBy('name')->get(),
            'lokasis' => Lokasi::query()->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, User $user)
    {
        $validateUser = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'max:255', Rule::unique('users')->ignore($user), 'regex:/^\S*$/u'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user)],
            'jabatan_id' => ['nullable', Rule::exists(Jabatan::class, 'id')],
            'lokasi_id' => ['nullable', Rule::exists(Lokasi::class, 'id')],
            'tempat_lahir' => ['nullable'],
            'tanggal_lahir' => ['nullable', 'date'],
            'alamat' => ['nullable', 'max:255'],
            'telepon' => ['nullable'],
            'status' => ['nullable', Rule::in(['Menikah', 'Belum Menikah'])],
            'jenis_kelamin' => ['nullable', Rule::in(['Laki-Laki', 'Perempuan'])],
            'foto' => ['nullable', 'image', 'max:2048', 'mimes:png,jpg,jpeg'],
            'cuti' => ['required', 'numeric', 'integer', 'min:1'],
            'cuti_bersama' => ['required', 'numeric', 'integer', 'min:1'],
            'cuti_menikah' => ['required', 'numeric', 'integer', 'min:1'],
            'cuti_melahirkan' => ['required', 'numeric', 'integer', 'min:1'],
        ]);

        DB::beginTransaction();
        try {
            $user->update(Arr::only($validateUser, ['name', 'username', 'email', 'password']));

            $validUserDetail = Arr::only($validateUser, ['jabatan_id', 'lokasi_id', 'tempat_lahir', 'tanggal_lahir', 'alamat', 'telepon', 'status', 'jenis_kelamin']);

            if ($request->has('foto')) {
                if ($fotoUser = $user->userDetail->foto) {
                    Storage::delete('public/profile/' . $fotoUser);
                }
                $namaFoto = $this->uploadFileService->upload($request->file('foto'));
                $validUserDetail['foto'] = $namaFoto;
            }

            $user->userDetail()->update($validUserDetail);

            $user->userCuti()->update(Arr::only($validateUser, ['cuti', 'cuti_bersama', 'cuti_menikah', 'cuti_melahirkan']));

            DB::commit();

            Alert::success('Berhasil', 'User ' . $user->name . ' berhasil diubah');
            return redirect()->route('master.user.index');
        } catch (Exception $message) {
            DB::rollBack();

            if ($request->has('foto') && isset($namaFoto)) {
                Storage::delete('public/profile/' . $namaFoto);
            }

            Log::error('Pesan Error Update User ' . $message->getMessage() . ' Line ' . $message->getLine());

            Alert::error('Gagal', 'User gagal diubah');
            return redirect()->route('master.user.index');
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

    public function destroy(User $user)
    {
        if ($foto = $user->userDetail->foto) {
            Storage::delete('public/profile/' . $foto);
        }

        $user->delete();

        Alert::success('Berhasil', 'User ' . $user->name . 'berhasil dihapus');
        return redirect()->route('master.user.index');
    }
}
