<!doctype html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login</title>

    @include('layouts._partials._style')
</head>
<body class=" ">
<!-- loader Start -->
<div id="loading">
    <div id="loading-center">
    </div>
</div>
<!-- loader END -->
<div>
    <div class="wrapper">
        <section class="login-content">
            <div class="container h-100">
                <div class="row align-items-center justify-content-center h-100">
                    <div class="col-12 " id="app">
                        {{--                    <div class="row align-items-center">--}}
                        {{--                        <div class="col-lg-6">--}}
                        {{--                            <h2 class="mb-2">Sign In</h2>--}}
                        {{--                            <p>To Keep connected with us please login with your personal info.</p>--}}
                        {{--                            <form action="{{ route('login') }}" method="post">--}}
                        {{--                                @csrf--}}
                        {{--                                <div class="row">--}}
                        {{--                                    <div class="col-lg-12">--}}
                        {{--                                        <div class="floating-label form-group">--}}
                        {{--                                            <input--}}
                        {{--                                                class="floating-input form-control @error('email') is-invalid @enderror"--}}
                        {{--                                                name="email" value="{{ old('email') }}" required autocomplete="email"--}}
                        {{--                                                autofocus--}}
                        {{--                                                type="email" placeholder=" ">--}}
                        {{--                                            <label>Email</label>--}}
                        {{--                                        </div>--}}
                        {{--                                        @error('email')--}}
                        {{--                                        <span class="invalid-feedback" role="alert">--}}
                        {{--                                            <strong>{{ $message }}</strong>--}}
                        {{--                                        </span>--}}
                        {{--                                        @enderror--}}
                        {{--                                    </div>--}}
                        {{--                                    <div class="col-lg-12">--}}
                        {{--                                        <div class="floating-label form-group">--}}
                        {{--                                            <input class="floating-input form-control" name="password" type="password"--}}
                        {{--                                                   placeholder=" ">--}}
                        {{--                                            <label>Password</label>--}}
                        {{--                                        </div>--}}
                        {{--                                        @error('password')--}}
                        {{--                                        <span class="invalid-feedback" role="alert">--}}
                        {{--                                            <strong>{{ $message }}</strong>--}}
                        {{--                                        </span>--}}
                        {{--                                        @enderror--}}
                        {{--                                    </div>--}}
                        {{--                                    <div class="col-lg-6">--}}
                        {{--                                        <div class="custom-control custom-checkbox mb-3">--}}
                        {{--                                            <input type="checkbox" class="custom-control-input" name="remember"--}}
                        {{--                                                   id="customCheck1" {{ old('remember') ? 'checked' : '' }}>--}}
                        {{--                                            --}}{{--                                            <label class="custom-control-label" for="customCheck1">Remember Me</label>--}}
                        {{--                                        </div>--}}
                        {{--                                    </div>--}}

                        {{--                                </div>--}}
                        {{--                                <button type="submit" class="btn btn-primary">Sign In</button>--}}
                        {{--                                <p class="mt-3">--}}
                        {{--                                    Or login with--}}
                        {{--                                </p>--}}
                        {{--                                <a class="google-plus" href="{{ route('social.login', ['provider' => 'google']) }}"> <i--}}
                        {{--                                        class="lab la-google-plus-square font-size-50  text-danger"></i></a>--}}
                        {{--                                --}}{{--                                <a class="facebook"--}}
                        {{--                                --}}{{--                                   href="{{ route('social.login', ['provider' => 'facebook']) }}"> <i--}}
                        {{--                                --}}{{--                                        class="lab la-facebook-square font-size-50  text-primary"></i></a>--}}

                        {{--                            </form>--}}
                        {{--                        </div>--}}
                        {{--                        <div class="col-lg-6 mb-lg-0 mb-4 mt-lg-0 mt-4">--}}
                        {{--                            <img src="{{asset('web_assets/images/login/01.png')}}" class="img-fluid w-80" alt="">--}}
                        {{--                        </div>--}}
                        {{--                    </div>--}}
                        <auth-login></auth-login>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<script src="{{asset('js/app.js')}}"></script>
@include('layouts._partials._script')

</body>

</html>
