<x-app-layout title="Master - Tambah Permission">
    <h1 class="h3 mb-4 text-gray-800">Tambah Permission</h1>

    <div class="row">
        <div class="col-lg-6">
            <!-- Basic Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tambah Permission</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('master.permission.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') }}">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-plus-circle fa-fw"></i>
                            Tambah</button>
                        <a href="{{ route('master.permission.index') }}" class="btn btn-warning"><i
                                class="fas fa-long-arrow-alt-left"></i>
                            Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
