@extends('customer_layout')
@section('content')
    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="{{ route('customer.home') }}">Trang chủ</a></li>
                    <li class="active">Giỏ hàng</li>
                </ol>
            </div>
            @php
                $customer_id = session()->get('customer_id');
                $carts = session()->get('cart');
                $cart_customer = $carts[$customer_id];
            @endphp
            @if (count($cart_customer) > 0)
                <div class="table-responsive cart_info">
                    <table class="table table-condensed">
                        <thead>
                            <tr class="cart_menu">
                                <td></td>
                                <td class="image">Hình ảnh</td>
                                <td class="description">Tên sản phẩm</td>
                                <td class="price">Giá</td>
                                <td class="quantity">Số lượng</td>
                                <td class="total">Tổng tiền</td>
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
                                    <td><input value="{{$id}}" type="checkbox" name="cart-checkbox" class="cart-checkbox"></td>
                                    <td class="cart_product">
                                        <a href=""><img src="{{ asset('uploads/products/' . $each['image']) }}"
                                                alt="" width="50" height="50"></a>
                                    </td>
                                    <td class="cart_description">
                                        <h4><a href="">{{ $each['name'] }}</a></h4>
                                        <p>ID: {{ $each['id'] }}</p>
                                    </td>
                                    <td class="cart_price">
                                        <p class="span-price">{{ number_format($each['price'], 0, ',', '.') }}</p>
                                    </td>
                                    <td class="cart_quantity">
                                        <div class="cart_quantity_button">
                                            <form>
                                                <button type="button" class="cart_quantity_down btn-update-quantity"
                                                    data-id="<?php echo $id; ?>" data-type='0'> - </button>
                                                <input class="cart_quantity_input span-quantity" type="text" name="quantity"
                                                    value="{{ $each['quantity'] }}" autocomplete="off" size="2">
                                                <button type='button' class="cart_quantity_up btn-update-quantity"
                                                    data-id="<?php echo $id; ?>" data-type='1'> + </button>
                                            </form>
                                        </div>
                                    </td>
                                    <td class="cart_total">
                                        <p class="cart_total_price span-sum">
                                            {{ number_format($price_products, 0, ',', '.') }}
                                        </p>
                                    </td>
                                    <td class="cart_delete">
                                        <button class="cart_quantity_delete btn-delete" data-id="{{$id}}"><i class="fa fa-times"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <button class="btn-delete-by-nums-checkbox">Xóa (<span class="delete-num-rows">0</span>)</button>
                    <button>Xóa tất cả</button>
                </div>
                <section id="do_action">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="total_area">
                                    <ul>
                                        <li>Tạm tính <span class="span-total">{{ number_format($subtotal, 0, ',', '.') }}</span></li>
                                        <li>Thuế <span></span></li>
                                        <li>Phí vận chuyển <span>Miễn phí</span></li>
                                        <li>Tổng thanh toán <span></span></li>
                                    </ul>
                                    <a class="btn btn-default check_out" href="{{ route('customer.checkout') }}">Tính mã
                                        giảm giá</a>
                                    <a class="btn btn-default check_out" href="{{ route('customer.checkout') }}">Mua
                                        hàng</a>
                                </div>
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
