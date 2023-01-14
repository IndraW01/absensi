@if (count($roles) > 0)
@foreach ($roles as $role)
<span class="badge badge-primary text-bg-primary">{{ strtoupper($role->name) }}</span>
@endforeach
@else
-
@endif
