<nav class="hk-nav hk-nav-light">
    <a href="javascript:void(0);" id="hk_nav_close" class="hk-nav-close"><span class="feather-icon"><i data-feather="x"></i></span></a>
    <div class="nicescroll-bar">
        <div class="navbar-nav-wrap">
            <div class="nav-header">
                <span>Data</span>
                <span>Data</span>
            </div>
            <ul class="navbar-nav flex-column">
                @if (auth()->user()['level'] == 'Admin')
                <li class="nav-item {{ Request::routeIs('user.index') ||
                Request::routeIs('user.create') ? 'active' : '' }}">
                    <a class="nav-link link-with-badge" href="{{ route('user.index') }}">
                        <span class="feather-icon"><i data-feather="users"></i></span>
                        <span class="nav-link-text">Pengguna</span>
                    </a>
                </li>
                @endif

                <li class="nav-item {{ Request::routeIs('master-supplier.index') ||
                    Request::routeIs('master-supplier.create') || Request::routeIs('master-supplier.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('master-supplier.index') }}" >
                        <span class="feather-icon"><i data-feather="truck"></i></span>
                        <span class="nav-link-text">Master Supplier</span>
                    </a>
                </li>

                <li class="nav-item {{ Request::routeIs('master-customer.index') ||
                    Request::routeIs('master-customer.create') || Request::routeIs('master-customer.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('master-customer.index') }}" >
                        <span class="feather-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" 
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-smile">
                            <circle cx="12" cy="12" r="10"></circle><path d="M8 14s1.5 2 4 2 4-2 4-2"></path><line x1="9" y1="9" x2="9.01" y2="9"></line>
                            <line x1="15" y1="9" x2="15.01" y2="9"></line></svg></span>
                        <span class="nav-link-text">Master Customer</span>
                    </a>
                </li>

                <li class="nav-item {{ Request::routeIs('master-product.index') ||
                    Request::routeIs('master-product.create') || Request::routeIs('master-product.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('master-product.index') }}" >
                        <span class="feather-icon"><i data-feather="shopping-bag"></i></span>
                        <span class="nav-link-text">Master Product</span>
                    </a>
                </li>

                <li class="nav-item {{ Request::routeIs('master-warehouse.index') ||
                    Request::routeIs('master-warehouse.create') || Request::routeIs('master-warehouse.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('master-warehouse.index') }}" >
                        <span class="feather-icon"><i data-feather="package"></i></span>
                        <span class="nav-link-text">Master Warehouse</span>
                    </a>
                </li>
            </ul>
            
            <hr class="nav-separator">
            <div class="nav-header">
                <span>Transaction</span>
                <span>Transaction</span>
            </div>
            <ul class="navbar-nav flex-column">
                <li class="nav-item {{ Request::routeIs('penerimaan-barang.index') ||
                    Request::routeIs('penerimaan-barang.create') || Request::routeIs('penerimaan-barang.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('penerimaan-barang.index') }}" >
                        <span class="feather-icon"><i data-feather="plus-square"></i></span>
                        <span class="nav-link-text">Penerimaan Barang</span>
                    </a>
                </li>
                <li class="nav-item {{ Request::routeIs('pengeluaran-barang.index') ||
                    Request::routeIs('pengeluaran-barang.create') || Request::routeIs('pengeluaran-barang.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('pengeluaran-barang.index') }}" >
                        <span class="feather-icon"><i data-feather="minus-square"></i></span>
                        <span class="nav-link-text">Pengeluaran Barang</span>
                    </a>
                </li>
            </ul>
            <hr class="nav-separator">
            <div class="nav-header">
                <span>Pengaturan Akun</span>
                <span>Akun</span>
            </div>
            <ul class="navbar-nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}" >
                        <span class="feather-icon"><i data-feather="log-out"></i></span>
                        <span class="nav-link-text">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div id="hk_nav_backdrop" class="hk-nav-backdrop"></div>
