@if ($route == 'user')
<a href="{{ route('master.user.show', ['user' => $param]) }}" class="edit btn btn-success btn-sm"><i
        class="fas fa-eye fa-fw"></i> Show
</a>
<a href="{{ route('master.user.editUserRole', ['user' => $param]) }}" class="edit btn btn-info btn-sm"><i
        class="fas fa-pen fa-fw"></i> Edit Role
</a>
@endif

@if ($route === 'role')
<a href="{{ route('master.role.editRolePermission', ['role' => $param]) }}" class="btn btn-info btn-sm"><i
        class="fas fa-pen fa-fw"></i> Edit Role Permission</a>
@endif

<a href="{{ route('master.'. $route . '.edit', [$route => $data]) }}" class="edit btn btn-warning btn-sm"><i
        class="fas fa-pen fa-fw"></i> Edit</a>

<form action="{{ route('master.'. $route . '.destroy', [$route => $data]) }}" method="POST"
    id="destroy{{ $title }}-{{ $data }}" class="d-inline">
    @csrf
    @method('DELETE')
    <button type="button" class="btn btn-danger btn-sm" onclick="delete{{ $title }}('{{ $data }}')"><i
            class="fas fa-trash fa-fw"></i> Hapus</button>
</form>
