<header>

    <div class="header_part_sm d-block d-md-none">
        <div class="container-fluid">
            <div class="row">
                <div class="col-4">
                    <div class="header_logu">
                        <a href="{{ route('dashboard') }}" class="logoo logo-largee">
                            <img src="{{ (!empty(get_setting('system_logo'))) ? url('public/uploads/logo/' . get_setting('system_logo')) : url('backend/images/fastLogo.jpeg') }}"
                                style="width: 100px; height: 50px;" alt="logo">
                        </a>
                    </div>
                </div>
                <div class="col-8">
                    <div class="header_icon">
                        <ul class="d-flex" style="list-style: none;">
                            <li>
                                <a href="#"><i class="fa-regular fa-bell"></i></a>
                            </li>

                            <li>
                                <a href="#"><i class="fa-solid fa-headphones"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fas fa-user"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--  -->

    <!--  -->
    <!-- <div class="wrapper_full header_part_sm"> 
            <div class="wrapper">
                <div class="header_item d-flex">
                    <div class="header_logu d-flex">
                        <img class="img-fluid" src="{{ asset('backend') }}/images/mobile-logu.jpg" alt="">
                        <h4>Grace Store</h4>
                    </div>
                    <div class="header_icon ">
                        <ul class="d-flex">
                            <li>
                                <a href="#"><i class="fa-regular fa-bell"></i></a>
                            </li>

                            <li>
                                <a href="#"><i class="fa-solid fa-headphones"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fas fa-user"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
            <div class="clr"></div>
        </div> -->
</header>

<!-- Start Topbar -->

<div class="side_redius d-none d-md-block">
    <!-- <div class="posi_absu"></div> -->
    <!-- Start row -->
    <div class="top_header topbar">
        <div class="row align-items-center" style="margin-top:-27px">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2 ms-3" style="margin-left: 15px;margin-top:42px">
                        <div class="togglebar">
                            <ul class="mb-0 list-inline">
                                <li class="list-inline-item">
                                    <div class="menubar">
                                        <a class="menu-hamburger" href="javascript:void();">
                                            <img src="{{ asset('backend') }}/images/svg-icon/collapse.svg"
                                                class="img-fluid menu-hamburger-collapse" alt="collapse">
                                            <img src="{{ asset('backend') }}/images/svg-icon/close.svg"
                                                class="img-fluid menu-hamburger-close" alt="close">
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <span style="font-weight:700;font-size:19px;text-left;color:black">Dashborad</span>
                    </div>
                    <div class="col-md-1">

                    </div>
                    <div class="col-md-7 text-right" style="margin-top:42px;margin-right:10px">
                        <div class=" text-center mt-2 font-weight-bold capital">
                            <p style="font-size: 16px; color:rgb(83, 83, 83);"> Support:
                                <span>
                                    @if(env('APP_MODE') == 'demo')
                                        01784-159071
                                    @else
                                        01901-166585 (10AM - 6PM)
                                    @endif
                                </span>
                                <span class="headers_icon"><a href="#"><i class="fa fa-phone"
                                            aria-hidden="true"></i></a></span>
                                {{-- <span class="header_icon"><a href="#"> <i
                                            class="fa fa-bell text-black"></i></a></span> --}}
                            </p>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="infobar">
                            <ul class="mb-0 list-inline">
                                <li class="list-inline-item" style="padding-top: 8px;">
                                    <div class="profilebar">
                                        <div class="dropdown">
                                            <a class="dropdown-toggle user_pro user-profile" href="#" role="button"
                                                id="profilelink" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">

                                                <img src="{{ asset('backend') }}/images/users/profile.svg"
                                                    class="img-fluid" alt="profile"><span
                                                    class="feather icon-chevron-down live-icon"></span>
                                                <span class="user-info">
                                                    <span
                                                        class="user-name text-black"><strong>{{ Auth::user()->name }}</strong></span>
                                                    <span class="user-email">{{ Auth::user()->email }}</span>
                                                </span>
                                                {{-- <i class="fa fa-angle-down text-black"
                                                    style="font-weight: 600;font-size:23px"></i> --}}
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right profile_bar"
                                                aria-labelledby="profilelink">
                                                <div class="dropdown-item">
                                                    <div class="profilename">
                                                        <h5>{{ Auth::user()->name }}</h5>
                                                        <label for="">{{ Auth::user()->email }}</label>
                                                    </div>
                                                </div>
                                                <div class="userbox mt-0">
                                                    <ul class="mb-0 list-unstyled">
                                                        @if(env('APP_MODE') != 'demo')
                                                            <li class="media dropdown-item">
                                                                <a href="{{ route('profile') }}" class="profile-icon"><img
                                                                        src="{{ asset('backend') }}/images/svg-icon/user.svg"
                                                                        class="img-fluid" alt="user">My Profile</a>
                                                            </li>
                                                        @endif
                                                        <li class="media dropdown-item">
                                                            <a href="{{ route('logout') }}"
                                                                onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                                                                class="profile-icon">
                                                                <img src="{{ asset('backend') }}/images/svg-icon/logout.svg"
                                                                    class="img-fluid" alt="logout">
                                                                Logout
                                                            </a>
                                                        </li>
                                                        <form method="POST" action="{{ route('logout') }}"
                                                            id="logout-form" style="display: none;">
                                                            @csrf
                                                        </form>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="infobar ">
                <ul class="mb-0 list-inline">
                    <li class="list-inline-item" style="padding-top: 8px;">
                        <div class="profilebar">
                            <div class="dropdown">

                                <a class="dropdown-toggle user-profile" href="#" role="button" id="profilelink"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">


                                    <img src="{{ asset('backend') }}/images/users/profile.svg" class="img-fluid"
                                        alt="profile"><span class="feather icon-chevron-down live-icon"></span>
                                    <span class="user-info">
                                        <span class="user-name text-black"><strong>{{ Auth::user()->name
                                                }}</strong></span>
                                        <span class="user-email">{{ Auth::user()->email }}</span>
                                    </span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profilelink">
                                    <div class="dropdown-item">
                                        <div class="profilename">
                                            <h5>{{ Auth::user()->name }}</h5>
                                        </div>
                                    </div>
                                    <div class="userbox">
                                        <ul class="mb-0 list-unstyled">
                                            <li class="media dropdown-item">
                                                <a href="{{ route('profile') }}" class="profile-icon"><img
                                                        src="{{ asset('backend') }}/images/svg-icon/user.svg"
                                                        class="img-fluid" alt="user">My Profile</a>
                                            </li>
                                            <li class="media dropdown-item">
                                                <a href="{{ route('logout') }}"
                                                    onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                                                    class="profile-icon">
                                                    <img src="{{ asset('backend') }}/images/svg-icon/logout.svg"
                                                        class="img-fluid" alt="logout">
                                                    Logout
                                                </a>
                                            </li>
                                            <form method="POST" action="{{ route('logout') }}" id="logout-form"
                                                style="display: none;">
                                                @csrf
                                            </form>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div> --}}
            <!-- Start col -->
            {{-- <div class="col-md-1 ms-3" style="margin-left: 20px">
                <div class="togglebar">
                    <ul class="mb-0 list-inline">
                        <li class="list-inline-item">
                            <div class="menubar">
                                <a class="menu-hamburger" href="javascript:void();">
                                    <img src="{{ asset('backend') }}/images/svg-icon/collapse.svg"
                                        class="img-fluid menu-hamburger-collapse" alt="collapse">
                                    <img src="{{ asset('backend') }}/images/svg-icon/close.svg"
                                        class="img-fluid menu-hamburger-close" alt="close">
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div> --}}
            {{-- <div class="col-md-1 col-sm-3" style="margin-left: -10px;margin-top:10px">
                <h2 style="font-weight:800;font-size:26px;text-left">Dashborad</h2>
            </div> --}}
            {{-- <div class="col-md-1"></div> --}}
            {{-- <div class="col-md-6 col-sm-6 text-end">
                <div class=" text-center mt-2 font-weight-bold capital">
                    <p style="font-size: 18px; color:rgb(83, 83, 83);"> Support:
                        <span>
                            @if(env('APP_MODE')=='demo')
                            01784-159071
                            @else
                            01901-166585 (10AM - 6PM)
                            @endif
                        </span>
                        <span class="header_icon"><a href="#"><i class="fa fa-phone" aria-hidden="true"></i></a></span>
                        <span class="header_icon"><a href="#"> <i class="fa fa-bell text-black"></i></a></span>
                    </p>
                </div>
            </div> --}}
            {{-- <div class="col-md-2">
                <div class="infobar">
                    <ul class="mb-0 list-inline">
                        <li class="list-inline-item" style="padding-top: 8px;">
                            <div class="profilebar">
                                <div class="dropdown">

                                    <a class="dropdown-toggle user-profile" href="#" role="button" id="profilelink"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">


                                        <img src="{{ asset('backend') }}/images/users/profile.svg" class="img-fluid"
                                            alt="profile"><span class="feather icon-chevron-down live-icon"></span>
                                        <span class="user-info">
                                            <span class="user-name text-black"><strong>{{ Auth::user()->name
                                                    }}</strong></span>
                                            <span class="user-email">{{ Auth::user()->email }}</span>
                                        </span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profilelink">
                                        <div class="dropdown-item">
                                            <div class="profilename">
                                                <h5>{{ Auth::user()->name }}</h5>
                                            </div>
                                        </div>
                                        <div class="userbox">
                                            <ul class="mb-0 list-unstyled">
                                                <li class="media dropdown-item">
                                                    <a href="{{ route('profile') }}" class="profile-icon"><img
                                                            src="{{ asset('backend') }}/images/svg-icon/user.svg"
                                                            class="img-fluid" alt="user">My Profile</a>
                                                </li>
                                                <li class="media dropdown-item">
                                                    <a href="{{ route('logout') }}"
                                                        onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                                                        class="profile-icon">
                                                        <img src="{{ asset('backend') }}/images/svg-icon/logout.svg"
                                                            class="img-fluid" alt="logout">
                                                        Logout
                                                    </a>
                                                </li>
                                                <form method="POST" action="{{ route('logout') }}" id="logout-form"
                                                    style="display: none;">
                                                    @csrf
                                                </form>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div> --}}

            {{--
        </div> --}}
        <!-- End col -->
    </div>
</div>
<!-- End row -->
</div>