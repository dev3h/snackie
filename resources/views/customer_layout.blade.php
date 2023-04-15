<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="utf-8">

    <meta name="description" content="{{ $meta_desc }}">
    <meta name="keywords" content="{{ $meta_keywords }}" />
    <meta name="robots" content="INDEX,FOLLOW" />
    <link rel="canonical" href="{{ $url_canonical }}" />
    <meta name="author" content="">
    <link rel="icon" type="image/x-icon" href="" />
    <!-- favicon -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('frontend/images/favicon.png') }}">

    {{-- share facebook --}}
    @stack('share_facebook')

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Home | E-Shopper</title>
    <link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/prettyPhoto.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/price-range.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/sweetalert2.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/toastr.css') }}" rel="stylesheet">
    @stack('fancy-box-css')
    @stack('light-slider-css')
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>
<!--/head-->

<body>
    @include('layouts.customer.header')

    {{-- carousel --}}
    @stack('carousel')

    <section>
        <div class="container">
            <div class="row">
                {{-- sidebar --}}
                @stack('sidebar')

                {{-- content --}}
                @yield('content')
            </div>
        </div>
    </section>
    <div id="fb-root"></div>

    @include('layouts.customer.footer')

    <script src="{{ asset('frontend/js/toggleTheme.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.min.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/js/popper.min.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.scrollUp.min.js') }}"></script>
    <script src="{{ asset('frontend/js/price-range.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.prettyPhoto.js') }}"></script>
    <script src="{{ asset('frontend/js/main.js') }}"></script>
    <script src="{{ asset('frontend/js/toastr.min.js') }}"></script>
    <script src="{{ asset('frontend/js/sweetalert2.min.js') }}"></script>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v16.0"
        nonce="IHHnoIB0"></script>
    @stack('capcha')
    @stack('fancy-box-js')
    @stack('light-slider-js')
    @stack('add-to-cart')
    @stack('update-quantity-cart')
</body>

</html>
