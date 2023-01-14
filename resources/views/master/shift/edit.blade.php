<x-app-layout title="Master - Edit Shift">
    <h1 class="h3 mb-4 text-gray-800">Edit Shift</h1>

    <div class="row">
        <div class="col-lg-6">
            <!-- Basic Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Edit Shift {{ $shift->name }}</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('master.shift.update', ['shift' => $shift->slug]) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name', $shift->name) }}">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="slug">Slug</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug"
                                name="slug" value="{{ old('slug', $shift->slug) }}" readonly>
                            @error('slug')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="jam_masuk" class="float-left">Jam Masuk</label>
                            <input type="time" class="form-control @error('jam_masuk') is-invalid @enderror"
                                id="jam_masuk" name="jam_masuk"
                                value="{{ old('jam_masuk', $shift->jam_masuk->format('H:i')) }}">
                            @error('jam_masuk')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="slug">Jam Keluar</label>
                            <input type="time" class="form-control @error('jam_keluar') is-invalid @enderror"
                                id="jam_keluar" name="jam_keluar"
                                value="{{ old('jam_keluar', $shift->jam_keluar->format('H:i')) }}">
                            @error('jam_keluar')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-pen fa-fw"></i>
                            Edit</button>
                        <a href="{{ route('master.shift.index') }}" class="btn btn-warning"><i
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
            const slugResponse = await fetch(`{{ route('master.shift.slug') }}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({name: this.value, action: "update", id: "{{ $shift->id }}" })
            })
                .then(response => response.json());

            const slug = await slugResponse;

            inputSlug.value = slug;
        });
    </script>
    @endpush

</x-app-layout>
