@extends('customer_layout')
@push('share_facebook')
    <meta property="og:image" content="{{ $facebook_share_img }}" />
    <meta property="og:site_name" content="http://127.0.0.1:8000/" />
    <meta property="og:description" content="{{ $facebook_share_description }}" />
    <meta property="og:title" content="{{ $facebook_share_title }}" />
    <meta property="og:url" content="{{ $facebook_share_url }}" />
    <meta property="og:type" content="website" />
@endpush
@push('fancy-box-css')
    <link rel="stylesheet" href="{{ asset('frontend/css/jquery.fancybox.min.css') }}" type="text/css" />
@endpush
@push('light-slider-css')
    <link rel="stylesheet" href="{{ asset('frontend/css/lightslider.min.css') }}" type="text/css" />
@endpush
@section('content')
    <div class="col-sm-12">
        <div class="product-details">
            <!--product-details-->
            <div class="row">
                <div class="col-sm-12 col-md-5">
                    <div class="demo">
                        <ul id="lightSlider">
                            <li data-thumb="{{ asset('uploads/products/' . $details_product->product_image) }}">
                                <img src="{{ asset('uploads/products/' . $details_product->product_image) }}" />
                            </li>
                            <li data-thumb="https://picsum.photos/1000/1000">
                                <img src="https://picsum.photos/1000/1000" />
                            </li>
                        </ul>
                    </div>

                </div>
                <div class="col-sm-12 col-md-7">
                    <div class="product-information">
                        <form class="add-to-cart-form">
                            <!--/product-information-->
                            <h2>{{ $details_product->product_name }}</h2>

                            <p>Mã sản phẩm: {{ $details_product->product_id }}</p>
                            <div class="d-flex">
                                {{-- star --}}
                                <div>
                                    <span>5</span>
                                    <i class="fa fa-star text-warning"></i>
                                </div>
                                {{-- sold --}}
                                <div class="ms-5">
                                    <span>{{ $details_product->product_sold }}</span>
                                    <span>đã bán</span>
                                </div>
                            </div>
                            <h4 class="text-danger mt-2">đ{{ number_format($details_product->product_price) }}</h4>
                            <p><b>Thương hiệu:</b> {{ $details_product->brand_name }}</p>
                            <p><b>Danh mục:</b> {{ $details_product->category_name }}</p>
                            {{-- <a href=""><img src="{{ asset('frontend/images/share.png') }}" class="share img-responsive"
                            alt="" /></a> --}}
                            <div class="flex-row">
                                <div class="fb-share-button" data-href="{{ $url_canonical }}" data-layout=""
                                    data-size=""><a target="_blank"
                                        href="https://www.facebook.com/sharer/sharer.php?u={{ $url_canonical }}&amp;src=sdkpreparse"
                                        class="fb-xfbml-parse-ignore">Chia sẻ</a></div>
                                <div class="fb-like" data-href="{{ $url_canonical }}" data-width="" data-layout=""
                                    data-action="" data-size="" data-share="false"></div>
                            </div>
                            <div class="my-3">
                                <span>Số lượng: </span>
                                <input name="qty" class="cart_quantity_input w-25" type="number" min="1"
                                    value="1" />
                                <span class="ms-2">
                                    <span>{{ $details_product->product_quantity }}</span>
                                    <span>sản phẩm có sẵn</span>
                                </span>
                            </div>

                            <div>
                                <button class="btn btn-fefault cart add-to-cart"
                                    value="{{ $details_product->product_id }}">
                                    <i class="fa fa-shopping-cart"></i>
                                    Thêm giỏ hàng
                                </button>
                            </div>
                        </form>
                    </div>
                    <!--/product-information-->
                </div>
            </div>
        </div>
        <!--/product-details-->


        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#tab-des">Mô tả sản phẩm</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#tab-detail">Chi tiết sản phẩm</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#tab-review">Đánh giá sản phẩm</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="tab-des">
                <p>{!! $details_product->product_des !!}</p>
            </div>
            <div class="tab-pane fade" id="tab-detail">
                <p>{!! $details_product->product_content !!}</p>
            </div>
            <div class="tab-pane fade" id="tab-review">
                <div class="fb-comments" data-href="{{ $url_canonical }}" data-width="" data-numposts="5">
                </div>
            </div>
        </div>
        <!--/category-tab-->

        <div class="recommended_items">
            <!--recommended_items-->
            <h2 class="title text-center">Sản phẩm liên quan</h2>


            @if (count($related_products) > 0)
                @foreach ($related_products as $related)
                    <div class="col-sm-4">
                        <div class="card" style="width: 18rem;">
                            <a href="{{ route('customer.product_detail', $related->slug) }}">
                                <img src="{{ asset('uploads/products/' . $related->image) }}" class="card-img-top"
                                    alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $related->name }}</h5>
                                    <p class="card-text">đ{{ number_format($related->price) }}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach

                {{-- <div class="item active">
                @foreach ($related_products as $related)
                    <div class="col-sm-4">
                        <div class="product-image-wrapper">
                            <div class="single-products">
                                <div class="productinfo text-center">
                                    <img src="{{ asset('uploads/products/' . $related->image) }}"
                                        alt="" />
                                    <h2>{{ number_format($related->price) }}</h2>
                                    <p>{{ $related->name }}</p>
                                    <button type="button" class="btn btn-default add-to-cart"><i
                                            class="fa fa-shopping-cart"></i>Thêm giỏ hàng</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="item">
                <div class="col-sm-4">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <img src="{{ asset('frontend/images/recommend2.jpg') }}" alt="" />
                                <h2>$56</h2>
                                <p>Easy Polo Black Edition</p>
                                <button type="button" class="btn btn-default add-to-cart"><i
                                        class="fa fa-shopping-cart"></i>Thêm giỏ hàng</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
                {{-- </div> --}}

        </div>
    @else
        <h3>Không có sản phẩm nào</h3>
        @endif
    </div>
    </div>
    <!--/recommended_items-->

    @push('fancy-box-js')
        <script src="{{ asset('frontend/js/jquery.fancybox.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                $("a#single_image").fancybox();
            });
        </script>
    @endpush
    @push('light-slider-js')
        <script src="{{ asset('frontend/js/lightslider.min.js') }}"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#lightSlider').lightSlider({
                    gallery: true,
                    item: 1,
                    loop: true,
                    slideMargin: 0,
                    thumbItem: 9
                });
            });
        </script>
    @endpush
    @push('add-to-cart')
        {{-- <script src="{{ asset('frontend/js/ajax/addToCart.js') }}"></script> --}}
        @include('pages.customer.ajaxBlade.addToCart')
    @endpush
@endsection
