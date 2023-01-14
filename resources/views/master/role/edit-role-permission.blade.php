<x-app-layout title="Master - Edit Role Permission">
    <h1 class="h3 mb-4 text-gray-800">Edit Role Permission</h1>

    <div class="row">
        <div class="col-lg-6">
            <!-- Basic Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Edit Role Permission {{ $role->name }}</h6>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form method="POST" action="{{ route('master.role.updateRolePermission', ['role' => $role]) }}">
                        @csrf
                        @method('PUT')
                        <div class="row ml-1 mb-3">
                            @foreach ($permissions as $permission)
                            @if (in_array($permission->name, $rolePermissions))
                            <div class="form-check col-md-2 mb-2">
                                <input class="form-check-input" type="checkbox" value="{{ $permission->name }}"
                                    id="permission-{{ $permission->name }}" name="permission[]" checked>
                                <label class="form-check-label" for="permission-{{ $permission->name }}">
                                    {{ $permission->name }}
                                </label>
                            </div>
                            @else
                            <div class="form-check col-md-2 mb-2">
                                <input class="form-check-input" type="checkbox" value="{{ $permission->name }}"
                                    id="permission-{{ $permission->name }}" name="permission[]">
                                <label class="form-check-label" for="permission-{{ $permission->name }}">
                                    {{ $permission->name }}
                                </label>
                            </div>
                            @endif

                            @endforeach
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-pen fa-fw"></i>
                            Edit</button>
                        <a href="{{ route('master.role.index') }}" class="btn btn-warning"><i
                                class="fas fa-long-arrow-alt-left"></i> Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
