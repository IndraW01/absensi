<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use App\Models\CutiFormat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'max:255', Rule::unique('users'), 'regex:/^\S*$/u'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], ['username.regex' => 'The Username Must not be Spaces']);

        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Role default User
            $user->assignRole('user');

            // Relasikan User Detail
            $userDetail =  $user->userDetail()->create(['status' => 'Belum Menikah']);

            // Relasikan User Cuti
            $cutiFomat = CutiFormat::query()->first(['cuti', 'cuti_bersama', 'cuti_menikah', 'cuti_melahirkan'])->toArray();
            $userDetail->userCuti()->create($cutiFomat);

            DB::commit();
        } catch (Exception $message) {
            DB::rollBack();

            Alert::error('Gagal', 'Registrasi anda gagal, Error: ' . $message->getMessage());
            return redirect()->route('login');
        }

        Alert::success('Berhasil', 'Registrasi anda berhasil');
        return redirect()->route('login');
    }
}
