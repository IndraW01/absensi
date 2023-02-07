<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Services\UploadFotoService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileController extends Controller
{
    private UploadFotoService $uploadFileService;

    public function __construct()
    {
        $this->uploadFileService = new UploadFotoService;
    }

    public function index()
    {
        return view('profile.index', [
            'user' => Auth::user(),
        ]);
    }

    public function update(Request $request, User $user)
    {
        $validateUser = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'max:255', Rule::unique('users')->ignore($user), 'regex:/^\S*$/u'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user)],
            'password' => ['required', 'min:3'],
            'tempat_lahir' => ['nullable'],
            'tanggal_lahir' => ['nullable', 'date'],
            'alamat' => ['nullable', 'max:255'],
            'telepon' => ['nullable'],
            'status' => ['nullable', Rule::in(['Menikah', 'Belum Menikah'])],
            'jenis_kelamin' => ['nullable', Rule::in(['Laki-Laki', 'Perempuan'])],
            'foto' => ['nullable', 'image', 'max:2048', 'mimes:png,jpg,jpeg'],
        ]);

        DB::beginTransaction();
        try {
            // Update User
            $user->update(Arr::only($validateUser, ['name', 'username', 'email', 'password']));

            // Update User Detail
            $validUserDetail = Arr::only($validateUser, ['tempat_lahir', 'tanggal_lahir', 'alamat', 'telepon', 'status', 'jenis_kelamin']);

            if ($request->has('foto')) {
                if ($fotoUser = $user->userDetail->foto) {
                    Storage::delete('public/profile/' . $fotoUser);
                }
                $namaFoto = $this->uploadFileService->upload($request->file('foto'));
                $validUserDetail['foto'] = $namaFoto;
            }

            $user->userDetail()->update($validUserDetail);

            DB::commit();

            Alert::success('Berhasil', 'Profile berhasil diubah');
            return redirect()->route('profile');
        } catch (Exception $message) {
            DB::rollBack();

            if ($request->has('foto') && isset($namaFoto)) {
                Storage::delete('public/profile/' . $namaFoto);
            }

            Log::error('Pesan Error Update Profile ' . $message->getMessage() . ' Line ' . $message->getLine());

            Alert::error('Gagal', 'Profile gagal diubah');
            return redirect()->route('profile');
        }
    }
}
