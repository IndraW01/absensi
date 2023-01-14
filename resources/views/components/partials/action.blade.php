<a href="{{ route('master.'. $route . '.edit', [$route => $data]) }}" class="edit btn btn-warning btn-sm"><i
        class="fas fa-pen fa-fw"></i>
    Edit</a>

<form action="{{ route('master.'. $route . '.destroy', [$route => $data]) }}" method="POST"
    id="destroy{{ $title }}-{{ $data }}" class="d-inline">
    @csrf
    @method('DELETE')
    <button type="button" class="btn btn-danger btn-sm" onclick="delete{{ $title }}('{{ $data }}')"><i
            class="fas fa-trash fa-fw"></i>
        Hapus</button>
</form>

@if ($route === 'role')
<a href="{{ route('master.role.editRolePermission', ['role' => $param]) }}" class="btn btn-warning btn-sm"><i
        class="fas fa-pen fa-fw"></i> Edit Role Permission</a>
@endif
