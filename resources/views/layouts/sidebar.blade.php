<header class="header-mobile d-block d-lg-none">
            <div class="header-mobile__bar">
                <div class="container-fluid">
                    <div class="header-mobile-inner">
                        <a class="logo" href="index.html">
                            <img src="{{ asset('theme/images/icon/911inform.png') }}" alt="CoolAdmin" />
                        </a>
                        <button class="hamburger hamburger--slider" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <?php echo $role = Auth::user()->role_type; ?>
            <nav class="navbar-mobile">
                <div class="container-fluid">
                    <ul class="navbar-mobile__list list-unstyled">
                        @if($role == 'super_admin')
                        <li class="active">
                            <a href="{{ route('admin-dashboard') }}">
                                <i class="fas fa-calendar-alt"></i>User List</a>
                        </li>
                        @endif
                        <!-- <li>
                            <a href="{{ route('routeopertion') }}">
                                <i class="fas fa-chart-bar"></i>Route Action</a>
                        </li> -->
                        <li>
                            <a href="{{ route('route-list') }}">
                                <i class="fas fa-table"></i>Route List</a>
                        </li>
                        <li>
                            <a href="{{ route('device-info') }}">
                                <i class="fas fa-desktop"></i>Route Table</a>
                        </li>  
                        <li>
                            <a href="{{ route('open-vpn') }}">
                                <i class="far fa-check-square"></i>Open VPN</a>
                        </li>
                        <li>
                            <a href="{{ route('ip-info') }}">
                                <i class="far fa-check-square"></i>IP Table</a>
                        </li> 
                        <li>
                            <a href="{{ route('ip-rules') }}">
                                <i class="far fa-check-square"></i>IP Rules</a>
                        </li>
                        <li>
                            <a href="{{ route('wan-interface') }}">
                                <i class="fas fa-copy"></i>Config WAN InterFace</a>
                        </li>
                        <li>
                            <a href="{{ route('interface-details') }}">
                                <i class="fas fa-copy"></i>InterFace Details</a>
                        </li>
                                              
                    </ul>
                </div>
            </nav>
        </header>
<aside class="menu-sidebar d-none d-lg-block">
            <div class="logo">
                <a href="#">
                    <img src="{{ asset('theme/images/icon/911inform.png') }}" alt="Cool Admin" />
                </a>
            </div>
            <div class="menu-sidebar__content js-scfrollbar1">
                <nav class="navbar-sidebar">
                    <ul class="list-unstyled navbar__list">
                        @if($role == 'super_admin')
                        <li class="{{ request()->is('admin-dashboard') ? 'active' : '' }}"> 
                            <a href="{{ route('admin-dashboard') }}">
                                <i class="fas fa-calendar-alt"></i>User List</a>
                        </li>
                        @endif 
                        <!-- <li>
                            <a href="{{ route('routeopertion') }}">
                                <i class="fas fa-chart-bar"></i>Route Action</a>
                        </li> -->
                        <li class="{{ request()->is('route-list') ? 'active' : '' }}"> 
                            <a href="{{ route('route-list') }}">
                                <i class="fas fa-table"></i>Route List</a>
                        </li>
                        <li class="{{ request()->is('device-info') ? 'active' : '' }}">
                            <a href="{{ route('device-info') }}">
                                <i class="fas fa-desktop"></i>Route Table</a>
                        </li>
                        <li class="{{ request()->is('open-vpn') ? 'active' : '' }}">
                            <a href="{{ route('open-vpn') }}">
                                <i class="far fa-check-square"></i>Open VPN</a>
                        </li>
                        <li class="{{ request()->is('ip-info') ? 'active' : '' }}">
                            <a href="{{ route('ip-info') }}">
                                <i class="far fa-check-square"></i>IP Table</a>
                        </li> 
                         <li class="{{ request()->is('ip-rules') ? 'active' : '' }}">
                            <a href="{{ route('ip-rules') }}">
                                <i class="far fa-check-square"></i>IP Rules</a>
                        </li>

                        <li class="{{ request()->is('wan-interface') ? 'active' : '' }}">
                            <a href="{{ route('wan-interface') }}">
                                <i class="fas fa-copy"></i>Config WAN InterFace</a>
                        </li>

                         <li class="{{ request()->is('interface-details') ? 'active' : '' }}">
                            <a href="{{ route('interface-details') }}">
                                <i class="fas fa-copy"></i>InterFace Details</a>
                        </li>
                                             
                    </ul>
                </nav>
            </div>
        </aside>