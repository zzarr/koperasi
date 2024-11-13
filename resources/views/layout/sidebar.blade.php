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
            <li class="menu">
                <a href="#" aria-expanded="true" class="dropdown-toggle">
                    <div class="">
                        <i class="ti ti-activity"></i>
                        <span> Dashhboard</span>
                    </div>
                </a>
            </li>

            <li class="menu">
                <a href="#submenu" data-toggle="collapse"
                    aria-expanded="{{ Request::routeIs('admin.payment') ? 'true' : 'false' }}"
                    class="dropdown-toggle">
                    <div class="">
                        {{-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-airplay"> --}}
                            <path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path>
                            <polygon points="12 15 17 21 7 21 12 15"></polygon>
                        </svg>
                        <span> Manajemen Pembayaran</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="submenu" data-parent="#accordionExample">
                    <li>
                        <a href="#">Simpanan Pokok</a>
                    </li>
                    <li>
                        <a href="#">Simpanan Wajib</a>
                    </li>
                    <li>
                        <a href="#">Simpanan Sukarela</a>
                    </li>
                    <li>
                        <a href="{{route('payment_piutang')}}">Piutang</a>
                    </li>
                </ul>
            </li>


        </ul>
    </nav>
</div>