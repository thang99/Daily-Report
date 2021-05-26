<!doctype html>
<html lang="en">

<!-- Mirrored from iqonic.design/themes/instadash/html/backend/pages-error.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 22 Mar 2021 04:22:48 GMT -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>403</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="http://iqonic.design/themes/instadash/html/assets/images/favicon.ico"/>
@include('layouts._partials._style')
<body class=" ">
<!-- loader Start -->
<div id="loading">
    <div id="loading-center">
    </div>
</div>
<!-- loader END -->

<div class="wrapper">
    <div class="container">
        <div class="row no-gutters height-self-center">
            <div class="col-sm-12 text-center align-self-center">
                <div class="iq-error position-relative">
                    <img src="{{asset('web_assets/images/error/02.png')}}" class="img-fluid iq-error-img" alt="">
                    <h2 class="mb-0 mt-4">Oops! Some thing wrong.</h2>
                    <p>The requested page dose not exist.</p>
                    <a class="btn btn-primary d-inline-flex align-items-center mt-3" href="{{route('home.index')}}"><i
                            class="ri-home-4-line"></i>Back to Home</a>
                </div>
            </div>
        </div>
    </div>
</div>

@include('layouts._partials._script')
</body>

<!-- Mirrored from iqonic.design/themes/instadash/html/backend/pages-error.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 22 Mar 2021 04:22:49 GMT -->
</html>
