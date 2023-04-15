@extends('customer_layout')
@section('content')
    @push('capcha')
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endpush
    <section id="form">
        <!--form-->
        {{-- <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 col-md-5 col-lg-5">
                    @include('pages.customer.auth.login')
                </div>
                <div class="col-sm-1">
                    <h2 class="or">hoặc</h2>
                </div>
                <div class="col-sm-12 col-md-5 col-lg-5"">
                    @include('pages.customer.auth.register')
                </div>
            </div>
        </div> --}}
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#tab-login">Đăng nhập</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#tab-register">Đăng ký</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="tab-login">
                @include('pages.customer.auth.login')
            </div>
            <div class="tab-pane fade" id="tab-register">
                @include('pages.customer.auth.register')
            </div>
        </div>
    </section>
    <!--/form-->
@endsection
