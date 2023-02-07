<x-app-layout title="Master - Show User">
    <h1 class="h3 mb-4 text-gray-800">Show User</h1>

    <div class="row">
        <div class="col-md-8">
            <!-- Basic Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Show User {{ $user->name }}</h6>
                </div>
                <div class="card-body">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-6">
                            <img class="img-thumbnail img-profile"
                                src="{{ asset($user->userDetail->foto ? 'storage/profile/' . $user->userDetail->foto : 'assets/img/undraw_profile.svg') }}"
                                width="300">
                        </div>
                        <div class="col-6">
                            <ul>
                                <li>Nama : {{ $user->name }}</li>
                                <li>Username : {{ $user->username}}</li>
                                <li>Email : {{ $user->email}}</li>
                                <li>Jabatan : {!! $user->userDetail->jabatan->name ?? '<span
                                        class="badge badge-warning">Belum
                                        Update</span>'!!} </li>
                                <li>Lokasi : {!! $user->userDetail->lokasi->name ?? '<span
                                        class="badge badge-warning">Belum
                                        Update</span>'!!} </li>
                                <li>Shift : {!! $user->userDetail->shift->name ?? '<span
                                        class="badge badge-warning">Belum
                                        Update</span>'!!} </li>
                                <li>Tempat Lahir : {!! $user->userDetail->tempat_lahir ?? '<span
                                        class="badge badge-warning">Belum
                                        Update</span>'!!} </li>
                                <li>Tanggal Lahir : {!! $user->userDetail->tanggal_lahir ?? '<span
                                        class="badge badge-warning">Belum
                                        Update</span>'!!} </li>
                                <li>Jenis Kelamin : {!! $user->userDetail->jenis_kelamin ?? '<span
                                        class="badge badge-warning">Belum
                                        Update</span>'!!} </li>
                                <li>Alamat : {!! $user->userDetail->alamat ?? '<span class="badge badge-warning">Belum
                                        Update</span>'!!} </li>
                                <li>Telepon : {!! $user->userDetail->telepon ?? '<span class="badge badge-warning">Belum
                                        Update</span>'!!} </li>
                                <li>Status : {!! $user->userDetail->status ?? '<span class="badge badge-warning">Belum
                                        Update</span>'!!} </li>
                                <li>Cuti : {{ $user->userCuti->cuti}}</li>
                                <li>Cuti Bersama : {{ $user->userCuti->cuti_bersama}}</li>
                                <li>Cuti Menikah: {{ $user->userCuti->cuti_menikah}}</li>
                                <li>Cuti Melahirkan: {{ $user->userCuti->cuti_melahirkan}}</li>
                            </ul>
                        </div>
                    </div>
                    <a href="{{ route('master.user.index') }}" class="btn btn-warning mt-2"><i
                            class="fas fa-long-arrow-alt-left"></i> Kembali</a>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
