<div class="sidebar-wrapper sidebar-theme">

    <div id="dismiss" class="d-lg-none"><i class="flaticon-cancel-12"></i></div>

    <nav id="sidebar">

        <ul class="navbar-nav theme-brand flex-row  text-center">
            <li class="nav-item theme-logo">
                <a href="index.html">
                    <img src="assets/img/90x90.jpg" class="navbar-logo" alt="logo">
                </a>
            </li>
            <li class="nav-item theme-text">
                <a href="index.html" class="nav-link">Koperasi </a>
            </li>
        </ul>

        <ul class="list-unstyled menu-categories" id="accordionExample">
            @role('admin')
                <li class="menu">
                    <a href="{{ route('admin.dashboard') }}"
                        aria-expanded="{{ Request::routeIs('admin.dashboard') ? 'true' : 'false' }}"
                        class="dropdown-toggle">
                        <div class="">
                            <i data-feather="grid"></i>
                            <span> Dashboard</span>
                        </div>
                    </a>
                </li>
                <li class="menu">
                    <a href="{{ route('manage-user.index') }}" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <i data-feather="users"></i>
                            <span> Manage User</span>
                        </div>
                    </a>
                </li>
                
                <li class="menu">
                    <a href="{{ route('admin.metadata.manage_metadata') }}"
                        aria-expanded="{{ Request::routeIs('manage_meta_data') ? 'true' : 'false' }}"
                        class="dropdown-toggle">
                        <div class="">
                            <i data-feather="settings"></i>
                            <span> Manage Meta Data</span>
                        </div>
                    </a>
                </li>
                <li class="menu">
                    <a href="#submenu" data-toggle="collapse"
                        aria-expanded="{{ Request::routeIs('admin.payment.main.index') ? 'true' : 'false' }}"
                        class="dropdown-toggle collapsed ">
                        <div class="">
                            <i data-feather="dollar-sign"></i>
                            <span> Pembayaran</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="submenu list-unstyled collapse" id="submenu" data-parent="#accordionExample"
                        style="">
                        <li>
                            <a href="{{ route('admin.payment.main.index') }}"> Simpanan Pokok </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.payment.monthly.index') }}"> Simpanan Wajib </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.payment.other.index') }}"> Simpanan Sukarela </a>
                        </li>
                    </ul>
                </li>
                <li class="menu">
                    <a href="{{ route('admin.piutang.index') }}" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <i data-feather="clipboard"></i>
                            <span> Piutang</span>
                        </div>
                    </a>
                </li>
                <li class="menu">
                    <a href="{{ route('admin.withdraw.index') }}" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <i data-feather="credit-card"></i>
                            <span> Manage Penarikan Dana</span>
                        </div>
                    </a>
                </li>
            @endrole


            @role('user')
                <li class="menu">
                    <a href="#" aria-expanded="true" class="dropdown-toggle">
                        <div class="">
                            <i data-feather="grid"></i>
                            <span> Dashboard</span>
                        </div>
                    </a>
                </li>
                <li class="menu">
                    <a href="#submenu" data-toggle="collapse"
                        aria-expanded="{{ Request::routeIs('admin.payment.main.index') ? 'true' : 'false' }}"
                        class="dropdown-toggle collapsed ">
                        <div class="">
                            <i data-feather="dollar-sign"></i>
                            <span> History Pembayaran</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="submenu list-unstyled collapse" id="submenu" data-parent="#accordionExample"
                        style="">
                        <li>
                            <a href="{{ route('admin.payment.main.index') }}">Pembayaran Simpanan Pokok </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.payment.monthly.index') }}">Pembayaran Simpanan Wajib </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.payment.other.index') }}">Pembayaran Simpanan Sukarela </a>
                        </li>
                    </ul>
                    
                    
                </li>
            @endrole

        </ul>
    </nav>
</div>
