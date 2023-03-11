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
                            <form>
                                <button type="button" class="btn btn-default add-to-cart" name="add-to-cart"
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
        <script>
            $(document).ready(function() {
                $(".add-to-cart").click(function() {
                    let id = $(this).val();
                    $.ajax({
                        url: '{{ route('customer.save_cart') }}',
                        type: "GET",
                        data: {
                            id,
                        },
                        success: function(response) {
                            const res = JSON.parse(response);
                            const cartQuantity = $("#cart-quantity");
                            if (Number(res.status) === 200) {
                                if (res.data != null) {
                                    $.trim(cartQuantity.text(res.data));
                                }
                                Swal.fire("Thành công", res.message, "success");
                            } else if (Number(res.status) === 401) {
                                location.href = res.redirect;
                            } else {
                                toastr.options.escapeHtml = true;

                                Command: toastr["error"](res.message, "Lỗi");

                                toastr.options = {
                                    closeButton: true,
                                    debug: false,
                                    newestOnTop: false,
                                    progressBar: false,
                                    positionClass: "toast-top-right",
                                    preventDuplicates: false,
                                    onclick: null,
                                    showDuration: "300",
                                    hideDuration: "1000",
                                    timeOut: "5000",
                                    extendedTimeOut: "1000",
                                    showEasing: "swing",
                                    hideEasing: "linear",
                                    showMethod: "fadeIn",
                                    hideMethod: "fadeOut",
                                };
                            }
                        },
                    });
                });
            });
        </script>
    @endpush
@endsection
