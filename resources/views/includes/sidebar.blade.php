<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion " style="height: 100%" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ URL::to('/') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    @role('admin')
        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">
            <a class="nav-link" href="{{ URL::to('/') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>
    @endrole
    <hr class="sidebar-divider">
    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ URL::to('/checkin') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Check In</span></a>
    </li>

    <hr class="sidebar-divider">
    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ URL::to('/member') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Quản Lý Member</span></a>
    </li>

    <hr class="sidebar-divider">
    <!-- Nav Item - Dashboard -->
    @role('admin')
        <li class="nav-item active">
            <a class="nav-link" href="{{ URL::to('/staff') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Quản Lý Staff</span></a>
        </li>

        <hr class="sidebar-divider">
        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">
            <a class="nav-link" href="{{ route('inout.index') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Quản Lý In/Out</span></a>
        </li>

        <hr class="sidebar-divider d-none d-md-block">
    @endrole
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
