<div class="iq-sidebar  sidebar-default ">
    <div class="iq-sidebar-logo d-flex align-items-center justify-content-between">
        <a href="{{url('/home')}}" class="header-logo">
            <img src="{{ asset('web_assets/images/logo.png') }}" class="img-fluid rounded-normal light-logo"
                 alt="logo">
            <img src="{{ asset('web_assets/images/logo-white.png') }}"
                 class="img-fluid rounded-normal darkmode-logo" alt="logo">
        </a>
        <div class="iq-menu-bt-sidebar">
            <i class="las la-bars wrapper-menu"></i>
        </div>
    </div>
    <div class="data-scrollbar" data-scroll="1">
        <nav class="iq-sidebar-menu">
            <ul id="iq-sidebar-toggle" class="iq-menu">
                <li class=" ">
                    <a href="{{url('/home')}}" class="collapsed">
                        <i class="las la-home"></i><span>Home</span>
                    </a>
                </li>
                <li class=" ">
                    <a href="{{url('/friends')}}" class="collapsed">
                        <i class="las la-heart"></i><span>Followers</span>
                    </a>
                </li>
                <li class=" ">
                    <a href="{{url('/suggests')}}" class="collapsed">
                        <i class="las la-user-friends"></i><span>Suggest Followers</span>
                    </a>
                </li>
                @role('admin')
                <li class=" ">
                    <a href="#admin" class="collapsed" data-toggle="collapse" aria-expanded="false">
                        <i class="las la-chart-pie iq-arrow-left"></i><span>Admin</span>
                        <i class="las la-angle-right iq-arrow-right arrow-active"></i>
                        <i class="las la-angle-down iq-arrow-right arrow-hover"></i>
                    </a>
                    <ul id="admin" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li class=" ">
                            <a href="{{route('manager-users.index')}}">
                                <i class="fas fa-users"></i><span>Manager Users</span>
                            </a>
                        </li>
                        <li class=" ">
                            <a href="{{route('divisions.index')}}">
                                <i class="fas fa-box"></i><span>Manager Divisions</span>
                            </a>
                        </li>
                        <li class=" ">
                            <a href="{{route('positions.index')}}">
                                <i class="fas fa-boxes"></i><span>Manager Position</span>
                            </a>
                        </li>
                        <li class=" ">
                            <a href="{{route('user-division.index')}}">
                                <i class="fas fa-users-cog"></i><span>Manager User Division</span>
                            </a>
                        </li>
                        <li class=" ">
                            <a href="{{route('user-report.index')}}">
                                <i class="fas fa-file-word"></i><span>Manager User Report</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endrole
                @role('user')
                <li class=" ">
                    <a href="#user" class="collapsed" data-toggle="collapse" aria-expanded="false">
                        <i class="las la-chart-pie iq-arrow-left"></i><span>User</span>
                        <i class="las la-angle-right iq-arrow-right arrow-active"></i>
                        <i class="las la-angle-down iq-arrow-right arrow-hover"></i>
                    </a>
                    <ul id="user" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li class=" ">
                            <a href="{{route('user-reports.index')}}">
                                <i class="las la-user"></i><span>My Reports</span>
                            </a>
                        </li>
                        <li class=" ">
                            <a href="{{route('report-division')}}">
                                <i class="las la-user"></i><span>List Reports</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endrole
                @hasallroles('manager|user')
                <li class=" ">
                    <a href="#manager" class="collapsed" data-toggle="collapse" aria-expanded="false">
                        <i class="las la-chart-pie iq-arrow-left"></i><span>Manager</span>
                        <i class="las la-angle-right iq-arrow-right arrow-active"></i>
                        <i class="las la-angle-down iq-arrow-right arrow-hover"></i>
                    </a>
                    <ul id="manager" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li class=" ">
                            <a href="{{route('users.index')}}">
                                <i class="las la-tools"></i><span>Manager User Division</span>
                            </a>
                        </li>
                        <li class=" ">
                            <a href="{{route('reports.index')}}">
                                <i class="las la-tools"></i><span>Manage Report</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endhasallroles
            </ul>
        </nav>
        {{--        <div id="sidebar-bottom" class="position-relative sidebar-bottom">--}}
        {{--            <div class="card bg-primary rounded">--}}
        {{--                <div class="card-body">--}}
        {{--                    <div class="sidebarbottom-content">--}}
        {{--                        <div class="image"><img src="{{ asset('web_assets/images/layouts/side-bkg.png') }}"--}}
        {{--                                                class="img-fluid" alt="side-bkg"></div>--}}
        {{--                        <h5 class="mb-3 text-white mt-3">Did you Know ?</h5>--}}
        {{--                        <p class="mb-0 text-white">You can add additional user in your Account's Settings</p>--}}
        {{--                        <button type="button" class="btn bg-light  mt-3"><i class="fas fa-plus-square"></i> New--}}
        {{--                            Program--}}
        {{--                        </button>--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </div>--}}
        <div class="p-3"></div>
    </div>
</div>
