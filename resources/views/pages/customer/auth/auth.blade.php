@extends('customer_layout')
@section('content')
@push('capcha')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endpush
<section id="form">
    <!--form-->
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                @include('pages.customer.auth.login')
            </div>
            <div class="col-sm-1">
                <h2 class="or">hoặc</h2>
            </div>
            <div class="col-sm-12">
                @include('pages.customer.auth.register')
            </div>
        </div>
    </div>
</section>
<!--/form-->
@endsection
