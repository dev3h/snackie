@extends('customer_layout', [
    'search' => $search,
])
@push('carousel')
    @include('layouts.customer.carousel')
@endpush
@push('sidebar')
    @include('layouts.customer.sidebar')
@endpush
@section('content')
    <div class="features_items">
        <!--features_items-->
        <h2 class="title text-center">Sản phẩm mới nhất</h2>
        @foreach ($products as $product)
            <div class="col-sm-4">
                <div class="product-image-wrapper">
                    <div class="single-products">
                        <div class="productinfo text-center">
                            <a href="{{ route('customer.product_detail', $product->id) }}">
                                <img src="{{ asset('uploads/products/' . $product->image) }}" alt="" />
                            </a>
                            <h2>{{ number_format($product->price) }}</h2>
                            <p>{{ $product->name }}</p>
                            {{-- <a href="#" class="btn btn-default add-to-cart">
                                    <i class="fa fa-shopping-cart"></i>Thêm giỏ hàng</a> --}}
                            <form class="add-to-cart-form">
                                <button class="btn btn-default add-to-cart" name="add-to-cart"
                                    value="{{ $product->id }}">Thêm vào giỏ hàng</button>
                            </form>
                        </div>
                    </div>
                    <div class="choose">
                        <ul class="nav nav-pills nav-justified">
                            <li><a href="#"><i class="fa fa-plus-square"></i>Yêu thích</a></li>
                            <li><a href="#"><i class="fa fa-plus-square"></i>So sánh</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
    <!--features_items-->
    @push('add-to-cart')
        {{-- <script src="{{ asset('frontend/js/ajax/addToCart.js') }}"></script> --}}
        @include('pages.customer.ajaxBlade.addToCart')
    @endpush
@endsection
