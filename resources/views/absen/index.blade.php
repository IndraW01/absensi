<x-app-layout title="Absen - Absen">
    @php
    $latitudeKantor = $userDetail->lokasi->latitude_kantor;
    $longitudeKantor = $userDetail->lokasi->longitude_kantor;
    $radius = $userDetail->lokasi->radius;
    @endphp

    @push('costum-css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
        integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
    <style>
        /* All */
        #jamSekarang {
            font-size: 1.5rem;
        }

        #formAbsenMasuk {
            margin: 10px 0 15px 0;
        }

        /* Map */
        #map {
            width: 60%;
            margin: 0 auto;
            height: 490px;
        }

        /* Webcam */
        .card-body .webcam#results {
            margin-bottom: 5px;
        }

        @media only screen and (max-width: 600px) {
            .card-body .webcam#results {
                width: 100% !important;
                height: 190px !important;
            }

            .card-body .webcam#results video {
                width: 100% !important;
                height: 190px !important;
            }

            .card-body #map {
                margin: 0;
                width: 100% !important;
                height: 200px !important;
            }
        }

        @media only screen and (max-width: 425px) {
            .card-body .webcam#results {
                width: 100% !important;
                height: 190px !important;
            }

            .card-body .webcam#results video {
                width: 100% !important;
                height: 190px !important;
            }

            .card-body #map {
                margin: 0;
                width: 100% !important;
                height: 200px !important;
            }
        }
    </style>
    @endpush
    <h1 class="h3 mb-4 text-gray-800">Absen</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Absen</h6>
        </div>
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col">
                    <h3 class="text-center">Absen Masuk</h3>
                    <div id="jamSekarang" class="text-center"></div>
                    <h4 class="text-center">Shift : {{ \Auth::user()->userDetail->shift->name }} ({{
                        \Auth::user()->userDetail->shift->jam_masuk->format('H:i')}} - {{
                        \Auth::user()->userDetail->shift->jam_keluar->format('H:i')}})</h4>
                </div>
            </div>
            <div class="webcam" id="results" style="width: 100%"></div>
            <div class="row justify-content-center">
                @if ($userAbsen)
                @if ($userAbsen->status == 'keluar')
                <input type="hidden" id="latitude" name="latitude">
                <input type="hidden" id="longitude" name="longitude">
                <div class="alert alert-success mt-md-2" role="alert">
                    Anda sudah absen hari ini
                </div>
                @else
                <form action="{{ route('absen.store') }}" id="formAbsenMasuk" method="POST">
                    @csrf
                    <input type="hidden" id="latitude" name="latitude">
                    <input type="hidden" id="longitude" name="longitude">
                    <input type="hidden" id="foto" name="foto">
                    <button type="submit" class="btn btn-warning" id="btnTakeAbsen">Absen Pulang</button>
                </form>
                @endif
                @else
                <form action="{{ route('absen.store') }}" id="formAbsenMasuk" method="POST">
                    @csrf
                    <input type="hidden" id="latitude" name="latitude">
                    <input type="hidden" id="longitude" name="longitude">
                    <input type="hidden" id="foto" name="foto">
                    <button type="submit" class="btn btn-primary" id="btnTakeAbsen">Absen Masuk</button>
                </form>
                @endif

            </div>
            <div id="map"></div>
        </div>
    </div>

    @push('costum-js')
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
        integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
    <script src="{{ url('assets/js/webcamjs/webcam.min.js') }}"></script>
    <script>
        // Jam realtime
        const waktu = () => {
            let waktu = new Date();

            setTimeout("waktu()", 1000);

            if(waktu.getMinutes() == 0) {
                document.getElementById('jamSekarang').innerHTML = `${ waktu.getHours()}:${waktu.getSeconds()}`;
            } else {
                document.getElementById('jamSekarang').innerHTML = `${ waktu.getHours()}:${waktu.getMinutes()}:${waktu.getSeconds()}`;
            }
        }

        window.setTimeout(waktu, 1000);

        // Webcam setting
        Webcam.set({
            height: 400,
            image_format: 'jpeg',
            jpeg_quality: 80,
            flip_horiz: true,
            fps: 45
        });

        Webcam.attach('.webcam');

        // Map setting
        const latitude = document.getElementById('latitude');
        const longitude = document.getElementById('longitude');

        // Mengambil lokasi user saat ini
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(successFunction, errorFunction);
        } else {
            alert('It seems like Geolocation, which is required for this page, is not enabled in your browser. Please use a browser which supports it.');
        }

        // Callback Success
        function successFunction(position) {
            const latitudeUser = -1.0148276393960074 //position.coords.latitude;
            const longitudeUser = 117.11818389857017 //position.coords.longitude;

            latitude.value = latitudeUser;
            longitude.value = longitudeUser;

            // Menampilkan Map
            let map = L.map('map').setView([latitudeUser, longitudeUser], 16);
            let googleStreets = L.tileLayer('http://{s}.google.com/vt?lyrs=m&x={x}&y={y}&z={z}',{
                maxZoom: 19,
                subdomains:['mt0','mt1','mt2','mt3']
            }).addTo(map);

            // Menampilkan Marker
            let marker = L.marker([latitudeUser, longitudeUser]).addTo(map);

            //Menampilkan Popup  di marker
            marker.bindPopup("<b>Posisi {{ \Auth()->user()->name }}</b><br> Lokasi di : {{ $userDetail->lokasi->name }}" ).openPopup();
            let popup = L.popup();
            function onMapClick(e) {
                popup
                    .setLatLng(e.latlng)
                    .setContent("You clicked the map at " + e.latlng.toString())
                    .openOn(map);
            }

            map.on('click', onMapClick);

            // Menampilkan circle
            var circle = L.circle([{{ $latitudeKantor }}, {{ $longitudeKantor }}], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: {{ $radius }}
            }).addTo(map);
        }

        // Callback error
        function errorFunction() {
        }

        // Jika button absen diklick
        @if ($userAbsen?->status != 'keluar')
        const btnTakeAbsen = document.getElementById('btnTakeAbsen');
        btnTakeAbsen.addEventListener('click', function(event) {
            event.preventDefault();

            // Menambil foto absen
            Webcam.snap( function(uriImg) {
                document.getElementById('foto').value = uriImg;
            });

            document.getElementById('formAbsenMasuk').submit();
        });
        @endif

    </script>
    @endpush
</x-app-layout>
