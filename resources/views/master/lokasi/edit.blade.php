<x-app-layout title="Master - Edit Lokasi">
    <h1 class="h3 mb-4 text-gray-800">Edit Lokasi</h1>

    <div class="row">
        <div class="col-lg-6">
            <!-- Basic Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Edit Lokasi {{ $lokasi->name }}</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('master.lokasi.update', ['lokasi' => $lokasi->slug]) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name', $lokasi->name) }}">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="slug">Slug</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug"
                                name="slug" value="{{ old('slug', $lokasi->slug) }}" readonly>
                            @error('slug')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="latitude_kantor">Latitude Kantor</label>
                            <input type="text" class="form-control @error('latitude_kantor') is-invalid @enderror"
                                id="latitude_kantor" name="latitude_kantor"
                                value="{{ old('latitude_kantor', $lokasi->latitude_kantor) }}">
                            @error('latitude_kantor')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="longitude_kantor">Longitude Kantor</label>
                            <input type="text" class="form-control @error('longitude_kantor') is-invalid @enderror"
                                id="longitude_kantor" name="longitude_kantor"
                                value="{{ old('longitude_kantor', $lokasi->longitude_kantor) }}">
                            @error('longitude_kantor')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="radius">Radius</label>
                            <input type="text" class="form-control @error('radius') is-invalid @enderror" id="radius"
                                name="radius" value="{{ old('radius', $lokasi->radius) }}">
                            @error('radius')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-pen fa-fw"></i>
                            Edit</button>
                        <a href="{{ route('master.lokasi.index') }}" class="btn btn-warning"><i
                                class="fas fa-long-arrow-alt-left"></i> Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('costum-js')
    <script>
        const inputName = document.getElementById('name');
        const inputSlug = document.getElementById('slug');

        inputName.addEventListener('change', async function() {
            const slugResponse = await fetch(`{{ route('master.lokasi.slug') }}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({name: this.value, action: "update", id: "{{ $lokasi->id }}" })
            })
                .then(response => response.json());

            const slug = await slugResponse;

            inputSlug.value = slug;
        });
    </script>
    @endpush

</x-app-layout>
