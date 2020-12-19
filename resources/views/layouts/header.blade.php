<header class="header-desktop">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="header-wrap">
                            <div class="header-button">
                            <div class="header-button">
                                <!--  -->
                                <div class="noti-wrap">
                                    <a href="#" class="btn btn-info" id="refresh">
                                      <i class="fa fa-refresh" aria-hidden="true"></i> Refresh
                                    </a>
                                </div>
                               <div class="account-wrap">
                                    <div class="account-item clearfix js-item-menu">
                                        <div class="content">
                                            <a class="js-acc-btn" href="#">{{ ucfirst(Auth::user()->name) }}</a>
                                        </div>
                                        <div class="account-dropdown js-dropdown">
                                            <div class="info clearfix">
                                                <div class="content">
                                                    <h5 class="name">
                                                        <a href="#">{{ ucfirst(Auth::user()->name) }}</a>
                                                    </h5>
                                                    <span class="email">{{ Auth::user()->email }}</span>
                                                </div>
                                            </div>                                            
                                            <div class="account-dropdown__footer">
                                                <a href="{{ route('logout') }}">
                                                    <i class="zmdi zmdi-power"></i>Logout</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>