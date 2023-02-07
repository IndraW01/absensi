<x-app-layout title="Absen - Detail My Absen">
    <h1 class="h3 mb-4 text-gray-800">Show My Absen</h1>

    <div class="row">
        <div class="col-md-8">
            <!-- Basic Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Show My Absen</h6>
                </div>
                <div class="card-body">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-md-5">
                            <div class="mb-3">
                                <p>Foto Absen Masuk</p>
                                <img class="img-thumbnail img-profile"
                                    src="{{ asset('storage/' . $userAbsen->foto_absen_masuk ) }}" width="300"
                                    height="300">
                            </div>
                            <div>
                                <p>Foto Absen Pulang</p>
                                {!! $userAbsen->foto_absen_pulang ? '<img class="img-thumbnail img-profile"
                                    src="'. asset('storage/' . $userAbsen->foto_absen_pulang) .'" width="300"
                                    height="300">' : '<span class="badge badge-warning">Belum Absen Pulang</span>' !!}
                            </div>
                        </div>
                        <div class="col-md-7">
                            <ul>
                                <li>Tanggal : {{ $userAbsen->tanggal }}</li>
                                <li>Jam Masuk : {{ $userAbsen->jam_masuk}}</li>
                                <li>Telat Masuk : {!! $userAbsen->telat_masuk == '00:00:00' ? '<span
                                        class="badge badge-success">Tepat Waktu Masuk</span>' : '<span
                                        class="badge badge-warning">Telat Absen ('. $userAbsen->telat_masuk .')</span>'
                                    !!}</li>
                                <li>Latitude Absen Masuk : {{ $userAbsen->latitude_absen_masuk }} </li>
                                <li>Longitude Absen Masuk : {{ $userAbsen->longitude_absen_masuk }}</li>
                                <li>Jarak Masuk : {{ $userAbsen->jarak_masuk . ' Meter' }}</li>
                                <li>Jam Pulang : {!! $userAbsen->jam_pulang ?? '<span class="badge badge-warning">Belum
                                        Absen
                                        Pulang</span>' !!}</li>
                                <li>Pulang Cepat: {!! $userAbsen->pulang_cepat ? ($userAbsen->pulang_cepat == '00:00:00'
                                    ?
                                    '<span class="badge badge-success">Tepat Waktu Pulang</span>' : '<span
                                        class="badge badge-warning">Pulang Cepat ('. $userAbsen->pulang_cepat
                                        .')</span>') :
                                    '<span class="badge badge-warning">Belum Absen
                                        Pulang</span>' !!}
                                </li>
                                <li>Latitude Absen Pulang : {!! $userAbsen->latitude_absen_pulang ?? '<span
                                        class="badge badge-warning">Belum Absen Pulang</span>'!!} </li>
                                <li>Longitude Absen Pulang : {!! $userAbsen->longitude_absen_pulang ?? '<span
                                        class="badge badge-warning">Belum Absen Pulang</span>'!!} </li>
                                <li>Jarak Pulang : {!! $userAbsen->jarak_pulang ? $userAbsen->jarak_pulang . ' Meter' :
                                    '<span class="badge badge-warning">Belum Absen Pulang</span>' !!} </li>
                                <li>Status: {{ $userAbsen->status}}</li>
                            </ul>
                        </div>
                    </div>
                    <a href="{{ route('absen.myAbsen') }}" class="btn btn-warning mt-2"><i
                            class="fas fa-long-arrow-alt-left"></i> Kembali</a>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
