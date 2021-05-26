<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title_page')</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="http://iqonic.design/themes/instadash/html/assets/images/favicon.ico"/>
    @include('layouts._partials._style')
</head>

<body class="  ">
<!-- loader Start -->
<div id="loading">
    <div id="loading-center">
    </div>
</div>
<!-- loader END -->
<!-- Wrapper Start -->
<div class="wrapper" id="app">

    @include('layouts._partials._sidebar')
    @include('layouts._partials._navbar')
    <div class="content-page">
        <div class="container-fluid">
        @yield('main_content')
        <!-- Page end  -->
        </div>
    </div>
</div>
<!-- Wrapper End-->
@include('layouts._partials._footer')
<!-- Backend Bundle JavaScript -->
<script src="{{asset('js/app.js')}}"></script>
@include('layouts._partials._script')
</body>
{{--<script type="text/javascript">--}}
{{--    var count = parseInt({{--}}
{{--           Auth::user()->unreadNotifications()->count()--}}
{{--        }});--}}
{{--    window.Echo.private(`App.Models.User.{{ auth()->user()->id }}`).notification((data) => {--}}
{{--        var newNotificationHtml = `--}}
{{--        <a href="#" class="iq-sub-card">--}}
{{--                                                            <div class="media align-items-center">--}}
{{--                                                                <div class="">--}}
{{--                                                                    <img class="avatar-40 rounded-small"--}}
{{--                                                                         src="${data.avatar}"--}}
{{--                                                                         alt="01">--}}
{{--                                                                </div>--}}
{{--                                                                <div class="media-body ml-3">--}}
{{--                                                                    <h6 class="mb-0">${data.title} <small--}}
{{--                                                                            class="badge badge-success float-right">New</small>--}}
{{--                                                                    </h6>--}}
{{--                                                                    <p class="mb-0">${data.message}</p>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </a>--}}
{{--            `;--}}
{{--        count += 1;--}}
{{--        document.getElementById("countnotificationitem").innerText = count;--}}
{{--        $('.menu-notification').prepend(newNotificationHtml);--}}
{{--    })--}}
{{--</script>--}}
<!-- Mirrored from iqonic.design/themes/instadash/html/backend/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 22 Mar 2021 04:15:37 GMT -->

</html>
