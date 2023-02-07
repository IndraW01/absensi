<x-app-layout title="Profile">
    <h1 class="h3 mb-4 text-gray-800">Profile</h1>

    <div class="row">
        <div class="col-lg">
            <!-- Basic Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Profile</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('profile.update', ['user' => $user]) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="name">Name<sup>*</sup></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name', $user->name) }}">
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="username">Username<sup>*</sup></label>
                                    <input type="text" class="form-control @error('username') is-invalid @enderror"
                                        id="username" name="username" value="{{ old('username', $user->username) }}">
                                    @error('username')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="email">Email<sup>*</sup></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email', $user->email) }}">
                                    @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="password">Password<sup>*</sup></label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password" value="{{ old('password', $user->password) }}">
                                    @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="jabatan_id">Jabatan</label>
                                    <input type="text" class="form-control" id="jabatan_id"
                                        value="{{ $user->userDetail->jabatan->name }}" readonly disabled>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="lokasi_id">Lokasi</label>
                                    <input type="text" class="form-control" id="lokasi_id"
                                        value="{{ $user->userDetail->lokasi->name }}" readonly disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="tempat_lahir">Tempat Lahir</label>
                                    <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror"
                                        id="tempat_lahir" name="tempat_lahir"
                                        value="{{ old('tempat_lahir', $user->userDetail->tempat_lahir) }}">
                                    @error('tempat_lahir')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="tanggal_lahir">Tanggal Lahir</label>
                                    <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                        id="tanggal_lahir" name="tanggal_lahir"
                                        value="{{ old('tanggal_lahir', $user->userDetail->tanggal_lahir) }}">
                                    @error('tanggal_lahir')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row align-items-end">
                            <div class="col">
                                <div class="form-group">
                                    <label for="foto">Foto</label>
                                    @if ($user->userDetail->foto)
                                    <img src="{{ asset('storage/profile/' . $user->userDetail->foto) }}"
                                        alt="{{ $user->name }}" class="img-thumbnail mb-2" width="100px">
                                    @endif
                                    <input type="file" class="form-control @error('foto') is-invalid @enderror"
                                        id="foto" name="foto" value="{{ old('foto') }}">
                                    @error('foto')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="telepon">Telepon</label>
                                    <input type="text" class="form-control @error('telepon') is-invalid @enderror"
                                        id="telepon" name="telepon"
                                        value="{{ old('telepon', $user->userDetail->telepon) }}">
                                    @error('telepon')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="custom-select" id="status" name="status">
                                        <option value="Menikah" @selected(old('status', $user->userDetail->status)
                                            === 'Menikah')>Menikah</option>
                                        <option value="Belum Menikah" @selected(old('status', $user->userDetail->status)
                                            === 'Belum Menikah')>Belum Menikah</option>
                                    </select>
                                    @error('status')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="jenis_kelamin">Jenis Kelamin</label>
                                    <select class="custom-select" id="jenis_kelamin" name="jenis_kelamin">
                                        <option value="Laki-Laki" @selected(old('jenis_kelamin', $user->
                                            userDetail->jenis_kelamin) === 'Laki-Laki')>Laki-Laki</option>
                                        <option value="Perempuan" @selected(old('jenis_kelamin', $user->
                                            userDetail->jenis_kelamin) === 'Perempuan')>Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="shift_id">Shift</label>
                                    <input type="text" class="form-control" id="shift_id"
                                        value="{{ $user->userDetail->shift->name . ' (' . $user->userDetail->shift->jam_masuk->format('H:i') . '-' . $user->userDetail->shift->jam_keluar->format('H:i') . ')'}}"
                                        readonly disabled>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <textarea class="form-control" id="alamat" name="alamat"
                                        rows="1">{{ old('alamat', $user->userDetail->alamat) }}</textarea>
                                    @error('alamat')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="cuti">Cuti</label>
                                    <input type="number" class="form-control" id="cuti"
                                        value="{{ old('cuti', $user->userCuti->cuti) }}" readonly disabled>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="cuti_bersama">Cuti Bersama</label>
                                    <input type="number" class="form-control" id="cuti_bersama"
                                        value="{{ old('cuti_bersama', $user->userCuti->cuti_bersama) }}" readonly
                                        disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="cuti_menikah" class="float-left">Cuti Menikah</label>
                                    <input type="number" class="form-control" id="cuti_menikah" name="cuti_menikah"
                                        value="{{ old('cuti_menikah', $user->userCuti->cuti_menikah) }}" readonly
                                        disabled>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="cuti_melahirkan">Cuti Melahirkan</label>
                                    <input type="number" class="form-control " id="cuti_melahirkan"
                                        name="cuti_melahirkan"
                                        value="{{ old('cuti_melahirkan', $user->userCuti->cuti_melahirkan) }}" readonly
                                        disabled>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-plus-circle fa-fw"></i>
                            Edit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
