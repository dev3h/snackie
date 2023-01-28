@extends('customer_layout')
@section('content')
    <div class="product-details">
        <!--product-details-->
        <div class="col-sm-5">
            <div class="view-product">
                <img src="{{ asset('uploads/products/' . $details_product->image) }}" alt="" />
                <h3>ZOOM</h3>
            </div>
            <div id="similar-product" class="carousel slide" data-ride="carousel">

                <!-- Wrapper for slides -->
                <div class="carousel-inner">
                    <div class="item active">
                        <a href=""><img src="{{ asset('frontend/images/similar1.jpg') }}" alt=""></a>
                        <a href=""><img src="{{ asset('frontend/images/similar2.jpg') }}" alt=""></a>
                        <a href=""><img src="{{ asset('frontend/images/similar3.jpg') }}" alt=""></a>
                    </div>
                    <div class="item">
                        <a href=""><img src="{{ asset('frontend/images/similar2.jpg') }}" alt=""></a>
                        <a href=""><img src="{{ asset('frontend/images/similar1.jpg') }}" alt=""></a>
                        <a href=""><img src="{{ asset('frontend/images/similar3.jpg') }}" alt=""></a>
                    </div>
                </div>

                <!-- Controls -->
                <a class="left item-control" href="#similar-product" data-slide="prev">
                    <i class="fa fa-angle-left"></i>
                </a>
                <a class="right item-control" href="#similar-product" data-slide="next">
                    <i class="fa fa-angle-right"></i>
                </a>
            </div>

        </div>
        <div class="col-sm-7">
            <div class="product-information">
                <!--/product-information-->
                <img src="{{ asset('frontend/images/new.jpg') }}" class="newarrival" alt="" />
                <h2>{{ $details_product->name }}</h2>
                <p>Mã sản phẩm: {{ $details_product->id }}</p>
                <img src="{{ asset('frontend/images/rating.png') }}" alt="" />
                <span>
                    <span>{{ number_format($details_product->price) }}đ</span>
                    <label>Số lượng:</label>
                    <input type="number" min="1" value="1" />
                    <button type="button" class="btn btn-fefault cart">
                        <i class="fa fa-shopping-cart"></i>
                        Thêm giỏ hàng
                    </button>
                </span>
                <p><b>Tình trạng:</b> Còn hàng</p>
                <p><b>Điều kiện:</b> Mới 100%</p>
                <p><b>Thương hiệu:</b> {{ $details_product->brand_name }}</p>
                <p><b>Danh mục:</b> {{ $details_product->category_name }}</p>
                <a href=""><img src="{{ asset('frontend/images/share.png') }}" class="share img-responsive"
                        alt="" /></a>
            </div>
            <!--/product-information-->
        </div>
    </div>
    <!--/product-details-->

    <div class="category-tab shop-details-tab">
        <!--category-tab-->
        <div class="col-sm-12">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#details" data-toggle="tab">Mô tả sản phẩm</a></li>
                <li><a href="#companyprofile" data-toggle="tab">Chi tiết sản phẩm</a></li>
                <li><a href="#reviews" data-toggle="tab">Đánh giá</a></li>
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane fade active in" id="details">
                <p>{!! $details_product->description !!}</p>
            </div>

            <div class="tab-pane fade" id="companyprofile">
                <p>{!! $details_product->content !!}</p>
            </div>

            <div class="tab-pane fade" id="reviews">
                <div class="col-sm-12">
                    <ul>
                        <li><a href=""><i class="fa fa-user"></i>EUGEN</a></li>
                        <li><a href=""><i class="fa fa-clock-o"></i>12:41 PM</a></li>
                        <li><a href=""><i class="fa fa-calendar-o"></i>31 DEC 2014</a></li>
                    </ul>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore
                        et dolore magna aliqua.Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                        aliquip ex ea commodo consequat.Duis aute irure dolor in reprehenderit in voluptate velit esse
                        cillum dolore eu fugiat nulla pariatur.</p>
                    <p><b>Write Your Review</b></p>

                    <form action="#">
                        <span>
                            <input type="text" placeholder="Your Name" />
                            <input type="email" placeholder="Email Address" />
                        </span>
                        <textarea name=""></textarea>
                        <b>Rating: </b> <img src="images/product-details/rating.png" alt="" />
                        <button type="button" class="btn btn-default pull-right">
                            Submit
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <!--/category-tab-->

    <div class="recommended_items">
        <!--recommended_items-->
        <h2 class="title text-center">Sản phẩm liên quan</h2>

        @if (count($related_products) > 0)
            <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    {{-- create a count when have three col in div have class is item, create new div class item  --}}
                    @php
                        $count = 0;
                    @endphp
                    @foreach ($related_products as $related)
                        @if ($count % 3 == 0)
                            <div class="item {{ $count == 0 ? 'active' : '' }}">
                        @endif
                        <div class="col-sm-4">
                            <div class="product-image-wrapper">
                                <div class="single-products">
                                    <div class="productinfo text-center">
                                        <img src="{{ asset('uploads/products/' . $related->image) }}" alt="" />
                                        <h2>{{ number_format($related->price) }}</h2>
                                        <p>{{ $related->name }}</p>
                                        <button type="button" class="btn btn-default add-to-cart"><i
                                                class="fa fa-shopping-cart"></i>Thêm giỏ hàng</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($count % 3 == 2)
                </div>
        @endif
        @php
            $count++;
        @endphp
        @endforeach
    </div>

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
    </div>
    <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
        <i class="fa fa-angle-left"></i>
    </a>
    <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
        <i class="fa fa-angle-right"></i>
    </a>
    </div>
@else
    <h3>Không có sản phẩm nào</h3>
    @endif
    </div>
    <!--/recommended_items-->
@endsection
