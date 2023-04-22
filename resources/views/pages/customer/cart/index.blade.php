@extends('customer_layout')
@section('content')
    <section id="cart_items">
        <div class="container">
            <nav aria-label="breadcrumb" class="mt-5">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('customer.home') }}">{{ __('frontpage.home') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$title}}</li>
                </ol>
            </nav>
            @php
                $customer_id = session()->get('customer_id');
                $carts = session()->get('cart');
                $cart_customer = $carts[$customer_id] ?? null;
            @endphp
            @if ($cart_customer != null)
                <div class="table-responsive mb-3">
                    <table class="table table-hover table-bordered table-condensed">
                        <thead>
                            <tr class="cart_menu">
                                <td></td>
                                <td>Hình ảnh</td>
                                <td>Tên sản phẩm</td>
                                <td>Giá</td>
                                <td>Số lượng</td>
                                <td>Tổng tiền</td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total = 0;
                                $subtotal = 0;
                            @endphp
                            @foreach ($cart_customer as $id => $each)
                                @php
                                    
                                    $price_products = $each['price'] * $each['quantity'];
                                    $subtotal += $price_products;
                                @endphp
                                <tr>
                                    <td><input value="{{ $id }}" type="checkbox" class="form-check-input cart-checkbox"
                                            name="cart-checkbox"></td>
                                    <td>
                                        <a href=""><img src="{{ asset('uploads/products/' . $each['image']) }}"
                                                alt="" width="50" height="50"></a>
                                    </td>
                                    <td>
                                        <p>{{ $each['name'] }}</p>
                                        <span>ID: {{ $each['id'] }}</sp>
                                    </td>
                                    <td>
                                        <p class="span-price">{{ number_format($each['price'], 0, ',', '.') }}</p>
                                    </td>
                                    <td>
                                        <div class="cart_quantity_button">
                                            <form class="d-flex">
                                                <button type="button" class="btn-update-quantity"
                                                    data-id="<?php echo $id; ?>" data-type='0'> - </button>
                                                <input class="cart_quantity_input span-quantity" type="text"
                                                    name="quantity" value="{{ $each['quantity'] }}" autocomplete="off"
                                                    size="2">
                                                <button type='button' class="btn-update-quantity"
                                                    data-id="<?php echo $id; ?>" data-type='1'> + </button>
                                            </form>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="cart_total_price span-sum">
                                            {{ number_format($price_products, 0, ',', '.') }}
                                        </p>
                                    </td>
                                    <td>
                                        <button class="cart_quantity_delete btn-delete btn" data-id="{{ $id }}"><i
                                                class="fa fa-times"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <caption>
                            <button class="btn-delete-by-nums-checkbox btn">Xóa (<span
                                    class="delete-num-rows">0</span>)</button>
                            <button class="btn-delete-all-cart btn">Xóa tất cả</button>
                        </caption>
                    </table>
                </div>

                <section id="do_action">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12 d-flex flex-column align-items-end">
                                <div class="coupon-container">
                                    <form class="coupon-form" method="post">
                                        @csrf
                                        <table>
                                            <tr>
                                                <td>
                                                    <div class="coupon-input-group">
                                                        <input type="text" class="form-control coupon-product"
                                                            placeholder="nhập mã giảm giá" name="coupon" />
                                                        <span class="btn-delete-coupon">x</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button class="btn" name="check_coupon">
                                                        Áp dụng
                                                    </button>
                                                </td>
                                            </tr>
                                        </table>
                                    </form>
                                </div>
                                <div class="table-responsive mt-3">
                                    <table class="table table-sm table-borderless table-total" style="max-width: 250px">
                                        <tbody>
                                            <tr>
                                                <td>Tạm tính</td>
                                                <td class="sub-total">{{ number_format($subtotal, 0, ',', '.') }}</td>
                                            </tr>
                                            <tr>
                                                <td>Thuế</td>
                                                <td>Không có</td>
                                            </tr>
                                            <tr>
                                                <td>Phí vẫn chuyển</td>
                                                <td>Miễn phí</td>
                                            </tr>
                                            <tr>
                                                <td>Tổng thanh toán</td>
                                                <td class="total-payment">{{ number_format($subtotal, 0, ',', '.') }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                {{-- <a href="{{route('customer.payment-method')}}">vnpay</a> --}}
                                <a class="check_out" href="{{ route('customer.checkout') }}">Mua
                                        hàng</a>
                                {{-- <div class="total_area">
                                    <ul>
                                        <li>Tạm tính <span
                                                class="span-total">{{ number_format($subtotal, 0, ',', '.') }}</span></li>
                                        <li>
                                            <span class="span-coupon">
                                                @if (session()->has('coupon'))
                                                    @foreach (session()->get('coupon') as $key => $cou)
                                                        @if ($cou['coupon_type'] == 0)
                                                            Mã giảm: {{ $cou['coupon_detail'] }} %
                                                            <p>
                                                                @php
                                                                    $total_coupon = ($subtotal * $cou['coupon_detail']) / 100;
                                                                    echo number_format($total_coupon, 0, ',', '.');
                                                                @endphp
                                                            </p>
                                                            <p>{{ number_format($subtotal - $total_coupon, 0, ',', '.') }}
                                                            </p>
                                                        @else
                                                            Mã giảm:
                                                            {{ number_format($cou['coupon_detail'], 0, ',', '.') }} đ
                                                            <p>{{ number_format($subtotal - $cou['coupon_detail'], 0, ',', '.') }}
                                                            </p>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    Không có
                                                @endif
                                            </span>
                                        </li>
                                        </li>
                                        <li>Thuế <span></span></li>
                                        <li>Phí vận chuyển <span>Miễn phí</span></li>
                                        <li>Tổng thanh toán <span></span></li>
                                    </ul>
                                    <a class="btn btn-default check_out" href="{{ route('customer.checkout') }}">Mua
                                        hàng</a>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </section>
                <!--/#do_action-->
            @else
                <h2>Giỏ hàng trống</h2>
            @endif
        </div>
    </section>
    <!--/#cart_items-->
    @push('update-quantity-cart')
        @include('pages.customer.ajaxBlade.CartHandler')
    @endpush

@endsection
