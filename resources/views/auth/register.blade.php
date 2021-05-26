<!doctype html>
<html lang="en">

<!-- Mirrored from iqonic.design/themes/instadash/html/backend/auth-sign-in.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 22 Mar 2021 04:22:39 GMT -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    @include('layouts._partials._style')
</head>
<body class=" ">
<!-- loader Start -->
<div id="loading">
    <div id="loading-center">
    </div>
</div>
<!-- loader END -->

<div class="wrapper">
    <section class="login-content">
        <div class="container h-100">
            <div class="row align-items-center justify-content-center h-100">
                <div class="col-12">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <h2 class="mb-2">Sign Up</h2>
                            <p>Enter your personal details and start journey with us.</p>
                            <form action="{{route('register')}}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="floating-label form-group">
                                            <input class="floating-input form-control" type="text" name="name"
                                                   value="{{old('name')}}"
                                                   placeholder=" ">
                                            <label>Name</label>
                                            @error('name')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>

                                    </div>

                                    <div class="col-lg-6">
                                        <div class="floating-label form-group">
                                            <input class="floating-input form-control" type="email" name="email"
                                                   value="{{old('email')}}"
                                                   placeholder=" ">
                                            <label>Email</label>
                                            @error('email')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="col-lg-6">
                                        <div class="floating-label form-group">
                                            <input class="floating-input form-control" type="text" name="phone"
                                                   value="{{old('phone')}}"
                                                   placeholder=" ">
                                            <label>Phone No.</label>
                                            @error('phone')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="col-lg-6">
                                        <div class="floating-label form-group">
                                            <input class="floating-input form-control" type="password" name="password"
                                                   placeholder=" ">
                                            <label>Password</label>
                                            @error('password')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="col-lg-6">
                                        <div class="floating-label form-group">
                                            <input class="floating-input form-control" type="password"
                                                   name="re_password" placeholder=" ">
                                            <label>Confirm Password</label>
                                            @error('re_password')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>

                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Sign Up</button>
                                <p class="mt-3">
                                    Already have an Account <a href="{{route('login')}}" class="text-primary">Sign
                                        In</a>
                                </p>
                            </form>
                        </div>
                        <div class="col-lg-6 mb-lg-0 mb-4 mt-lg-0 mt-4">
                            <img src="{{asset('web_assets/images/login/01.png')}}" class="img-fluid w-80" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@include('layouts._partials._script')
</body>

</html>
