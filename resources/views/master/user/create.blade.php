<x-app-layout title="Master - Tambah User">
    <h1 class="h3 mb-4 text-gray-800">Tambah User</h1>

    <div class="row">
        <div class="col-lg">
            <!-- Basic Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tambah User User</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('master.user.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="name">Name<sup>*</sup></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name') }}">
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
                                        id="username" name="username" value="{{ old('username') }}">
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
                                        id="email" name="email" value="{{ old('email') }}">
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
                                        id="password" name="password" value="{{ old('password') }}">
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
                                    <select class="custom-select" id="jabatan_id" name="jabatan_id">
                                        @foreach ($jabatans as $jabatan)
                                        <option value="{{ $jabatan->id }}" @selected(old('jabatan_id')===$jabatan->
                                            id)>{{ $jabatan->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('jabatan_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="lokasi_id">lokasi_id</label>
                                    <select class="custom-select" id="lokasi_id" name="lokasi_id">
                                        @foreach ($lokasis as $lokasi)
                                        <option value="{{ $lokasi->id }}" @selected(old('lokasi_id')===$lokasi->
                                            id)>{{ $lokasi->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('lokasi_id')
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
                                    <label for="tempat_lahir">Tempat Lahir</label>
                                    <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror"
                                        id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}">
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
                                        id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}">
                                    @error('tanggal_lahir')
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
                                    <label for="foto">Foto</label>
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
                                        id="telepon" name="telepon" value="{{ old('telepon') }}">
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
                                        <option value="Menikah" @selected(old('status'))>Menikah</option>
                                        <option value="Belum Menikah" @selected(old('status'))>Belum Menikah</option>
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
                                        <option value="Laki-Laki" @selected(old('jenis_kelamin'))>Laki-Laki</option>
                                        <option value="Perempuan" @selected(old('jenis_kelamin'))>Perempuan</option>
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
                                    <label for="alamat">Alamat</label>
                                    <textarea class="form-control" id="alamat" name="alamat"
                                        rows="2">{{ old('alamat') }}</textarea>
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
                                    <input type="number" class="form-control @error('cuti') is-invalid @enderror"
                                        id="cuti" name="cuti" value="{{ old('cuti', $cutiFormat->cuti) }}" min="1">
                                    @error('cuti')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="cuti_bersama">Cuti Bersama</label>
                                    <input type="number"
                                        class="form-control @error('cuti_bersama') is-invalid @enderror"
                                        id="cuti_bersama" name="cuti_bersama"
                                        value="{{ old('cuti_bersama', $cutiFormat->cuti_bersama) }}" min="1">
                                    @error('cuti_bersama')
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
                                    <label for="cuti_menikah" class="float-left">Cuti Menikah</label>
                                    <input type="number"
                                        class="form-control @error('cuti_menikah') is-invalid @enderror"
                                        id="cuti_menikah" name="cuti_menikah"
                                        value="{{ old('cuti_menikah', $cutiFormat->cuti_menikah) }}" min="1">
                                    @error('cuti_menikah')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="cuti_melahirkan">Cuti Melahirkan</label>
                                    <input type="number"
                                        class="form-control @error('cuti_melahirkan') is-invalid @enderror"
                                        id="cuti_melahirkan" name="cuti_melahirkan"
                                        value="{{ old('cuti_melahirkan', $cutiFormat->cuti_melahirkan) }}" min="1">
                                    @error('cuti_melahirkan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-plus-circle fa-fw"></i>
                            Tambah</button>
                        <a href="{{ route('master.user.index') }}" class="btn btn-warning"><i
                                class="fas fa-long-arrow-alt-left"></i> Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
