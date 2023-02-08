@extends('customer_layout')
@section('content')
<section id="form">
    <!--form-->
    <div class="container">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-1">
                @include('pages.customer.auth.login')
            </div>
            <div class="col-sm-1">
                <h2 class="or">hoặc</h2>
            </div>
            <div class="col-sm-4">
                @include('pages.customer.auth.register')
            </div>
        </div>
    </div>
</section>
<!--/form-->
@endsection
