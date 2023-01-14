<x-app-layout title="Master - Edit Permission">
    <h1 class="h3 mb-4 text-gray-800">Edit Permission</h1>

    <div class="row">
        <div class="col-lg-6">
            <!-- Basic Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Edit Permission {{ $permission->name }}</h6>
                </div>
                <div class="card-body">
                    <form method="POST"
                        action="{{ route('master.permission.update', ['permission' => $permission->name]) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name', $permission->name) }}">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-pen fa-fw"></i>
                            Edit</button>
                        <a href="{{ route('master.permission.index') }}" class="btn btn-warning"><i
                                class="fas fa-long-arrow-alt-left"></i>
                            Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
