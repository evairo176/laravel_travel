<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('dashboard.admin')}}">
        <div class="sidebar-brand-text mx-3">Nomads Admin</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?= ($currentsubmenu == 'dashboard') ? 'active' : '' ?>">
        <a class="nav-link" href="{{route('dashboard.admin')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Master Data</span>
        </a>
        <div id="collapseTwo" class="collapse <?= ($currentmenu == 'dashboard') ? 'show' : '' ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded text-left">
                <a class="collapse-item <?= ($currentsubmenu == 'travelpackages') ? 'active' : '' ?>" href="{{url('/admin/travel-packages')}}"><i class="fas fa-plane-departure"></i><span> Paket Travel</span></a>
                <a class="collapse-item <?= ($currentsubmenu == 'transactions') ? 'active' : '' ?>" href="{{url('/admin/transactions')}}"><i class="fas fa-money-check-alt"></i><span> Transaksi</span></a>
                <a class="collapse-item <?= ($currentsubmenu == 'topup_transaction') ? 'active' : '' ?>" href="{{url('/admin/topup-transactions')}}"><i class="fas fa-money-check-alt"></i><span> Top up Transaksi</span></a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->