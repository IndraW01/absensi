<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon">
            <i class="fas fa-clipboard"></i>
        </div>
        <div class="sidebar-brand-text mx-3">ABSENSI</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Master
    </div>

    <!-- Nav Item - Master Menu -->
    <li
        class="nav-item {{ (request()->routeIs('master.user.*') ? 'active' : request()->routeIs('master.role.*')) ? 'active' : (request()->routeIs('master.permission.*') ? 'active' : (request()->routeIs('master.shift.*') ? 'active' : (request()->routeIs('master.lokasi.*') ? 'active' : (request()->routeIs('master.status.*') ? 'active' : (request()->routeIs('master.jabatan.*') ? 'active' : (request()->routeIs('master.cuti.format.*') ? 'active' : '')))))) }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
            aria-controls="collapseTwo">
            <i class="fas fa-th-list"></i>
            <span>Master</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Data Master</h6>
                <a class="collapse-item {{ request()->routeIs('master.user.*') ? 'active' : '' }}"
                    href="{{ route('master.user.index') }}">Users</a>
                <a class="collapse-item {{ request()->routeIs('master.role.*') ? 'active' : '' }}"
                    href="{{ route('master.role.index') }}">Roles</a>
                <a class="collapse-item {{ request()->routeIs('master.permission.*') ? 'active' : '' }}"
                    href="{{ route('master.permission.index') }}">Permissions</a>
                <a class="collapse-item {{ request()->routeIs('master.shift.*') ? 'active' : '' }}"
                    href="{{ route('master.shift.index') }}">Shift</a>
                <a class="collapse-item {{ request()->routeIs('master.lokasi.*') ? 'active' : '' }}"
                    href="{{ route('master.lokasi.index') }}">Lokasi</a>
                <a class="collapse-item {{ request()->routeIs('master.status.*') ? 'active' : '' }}"
                    href="{{ route('master.status.index') }}">Status</a>
                <a class="collapse-item {{ request()->routeIs('master.jabatan.*') ? 'active' : '' }}"
                    href="{{ route('master.jabatan.index') }}">Jabatan</a>
                <a class="collapse-item {{ request()->routeIs('master.cuti.format.*') ? 'active' : '' }}"
                    href="{{ route('master.cuti.format.index') }}">Cuti Format</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Absen -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="far fa-clipboard"></i>
            <span>Absen</span></a>
    </li>

    <!-- Nav Item - History Absen -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-clipboard-list"></i>
            <span>History Absen</span></a>
    </li>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
