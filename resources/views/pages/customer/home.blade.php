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
    <div class="col-sm-12 col-md-9">
        <div class="features_items">
            <!--features_items-->
            <h2 class="title text-center">Sản phẩm mới nhất</h2>
            <div class="row">
                @foreach ($products as $product)
                    <div class="col-sm-12 col-lg-3 col-md-4">
                        <div class="card">
                            <a href="{{ route('customer.product_detail', $product->id) }}"><img
                                    src="{{ asset('uploads/products/' . $product->image) }}" height="180"
                                    class="card-img-top" style='object-fit: cover' alt="..."></a>
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p>đ{{ number_format($product->price) }}</p>
                                <form class="add-to-cart-form">
                                    <button class="btn btn-default add-to-cart btn-light" name="add-to-cart"
                                        value="{{ $product->id }}">Thêm vào giỏ hàng</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
    <!--features_items-->
    @push('add-to-cart')
        {{-- <script src="{{ asset('frontend/js/ajax/addToCart.js') }}"></script> --}}
        @include('pages.customer.ajaxBlade.addToCart')
    @endpush
@endsection
