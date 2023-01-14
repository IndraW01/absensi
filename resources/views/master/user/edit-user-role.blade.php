<x-app-layout title="Master - Edit User Role">
    <h1 class="h3 mb-4 text-gray-800">Edit User Role</h1>
    <div class="row">
        <div class="col-lg-6">
            <!-- Basic Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Edit User Role {{ $user->name }}</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('master.user.updateUserRole', ['user' => $user]) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="role">Role Name</label>
                            <select class="form-control @error('role') is-invalid @enderror" id="role" name="role">
                                @foreach ($roles as $role)
                                <option value="{{ $role->name }}" @selected($userRole==$role->name)>{{
                                    strtoupper($role->name)
                                    }}</option>
                                @endforeach
                            </select>
                            @error('role')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-pen fa-fw"></i>
                            Edit</button>
                        <a href="{{ route('master.user.index') }}" class="btn btn-warning"><i
                                class="fas fa-long-arrow-alt-left"></i> Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
