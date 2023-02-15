@extends('customer_layout')
@section('content')
    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="{{ route('customer.home') }}">Trang chủ</a></li>
                    <li class="active">Thông tin thanh toán</li>
                </ol>
            </div>
            <!--/breadcrums-->

            <div class="shopper-informations">
                @php
                    $carts = Cart::content();
                @endphp
                <div class="row">
                    <div class="col-sm-12 col-md-5 clearfix">
                        <div class="bill-to">
                            <p>Địa chỉ nhận hàng</p>
                            <div class="form-one">
                                <form method="post" action="{{ route('customer.process_checkout') }}">
                                    @csrf
                                    <div class="checkout-group">
                                        <label for="">Tên người nhận</label>
                                        <input type="text" name="name_receiver" class="form-control"
                                            placeholder="Họ và tên người nhận" value="{{$shipping_info->name_receiver ?? null}}">
                                    </div>
                                    <div class="checkout-group">
                                        <label for="">Sđt người nhận</label>
                                        <input type="text" name="phone_receiver" class="form-control"
                                            placeholder="Số điện thoại người nhận" value="{{$shipping_info->phone_receiver ?? null}}">
                                    </div>
                                    <div class="checkout-group">
                                        <label for="">Địa chỉ người nhận</label>
                                        <input type="text" name="address_receiver" class="form-control"
                                            placeholder="Địa chỉ người nhận" value="{{$shipping_info->address_receiver ?? null}}">
                                    </div>
                                    <div class="checkout-group">
                                        <label for="">Lời nhắn</label>
                                        <input type="text" name="note" class="form-control"
                                            placeholder="Lưu ý Người bán">
                                    </div>
                                    <input type="submit" value="Thanh toán" class="btn btn-primary btn-sm">
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-7">
                        <div class="review-payment">
                            <h2>Xem lại giỏ hàng</h2>
                        </div>
                        <div class="table-responsive cart_info">
                            <table class="table table-condensed">
                                <thead>
                                    <tr class="cart_menu">
                                        <td class="image">Hình ảnh</td>
                                        <td class="description">Tên sản phẩm</td>
                                        <td class="price">Giá</td>
                                        <td class="quantity">Số lượng</td>
                                        <td class="total">Tổng tiền</td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($carts as $cart)
                                        <tr>
                                            <td class="cart_product">
                                                <a href=""><img
                                                        src="{{ asset('uploads/products/' . $cart->options->image) }}"
                                                        alt="" width="50" height="50"></a>
                                            </td>
                                            <td class="cart_description">
                                                <h4><a href="">{{ $cart->name }}</a></h4>
                                                <p>ID: {{ $cart->id }}</p>
                                            </td>
                                            <td class="cart_price">
                                                <p>{{ number_format($cart->price, 0, ',', '.') }}</p>
                                            </td>
                                            <td class="cart_quantity">
                                                <div class="cart_quantity_button">
                                                    {{-- <a class="cart_quantity_down" href="{{}}"> - </a>
                                        <input class="cart_quantity_input" type="text" name="quantity"
                                            value="{{ $cart->qty }}" autocomplete="off" size="2">
                                        <a class="cart_quantity_up" href=""> + </a> --}}

                                                    <form method="post" action="{{ route('customer.update_qty_cart') }}">
                                                        @csrf
                                                        <input type="hidden" name="rowId" value="{{ $cart->rowId }}">
                                                        <input class="cart_quantity_input" type="number" name="qty"
                                                            value="{{ $cart->qty }}" min="1">
                                                        <input type="submit" value="Cập nhập"
                                                            class="btn btn-default btn-sm">
                                                    </form>

                                                </div>
                                            </td>
                                            <td class="cart_total">
                                                <p class="cart_total_price">
                                                    {{ number_format($cart->price * $cart->qty, 0, ',', '.') }}
                                                </p>
                                            </td>
                                            <td class="cart_delete">
                                                <a class="cart_quantity_delete"
                                                    href="{{ route('customer.delete__item_cart', $cart->rowId) }}"><i
                                                        class="fa fa-times"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/#cart_items-->
@endsection
