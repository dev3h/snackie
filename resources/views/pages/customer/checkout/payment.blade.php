@extends('customer_layout')
@section('content')
    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="{{ route('customer.home') }}">Trang chủ</a></li>
                    <li class="active">Thanh toán</li>
                </ol>
            </div>
            <!--/breadcrums-->

            <div class="shopper-informations">
                @php
                    $carts = Cart::content();
                @endphp
                <div class="row">
                    <div class="col-sm-12">
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

            <div>
                <h3>Phương thức thanh toán</h3>
               <form action="{{route('customer.order')}}" method="post">
                @csrf
                    <div class="payment-options">
                        <span>
                            <label><input type="radio" name="method" value="1">Thẻ tín dụng</label>
                        </span>
                        <span>
                            <label><input type="radio" name="method" value="2">Thanh toán khi nhận hàng</label>
                        </span>
                        <span>
                            <label><input type="radio" name="method">Thẻ ghi nợ</label>
                        </span>
                    </div>
                     <input type="submit" value="Đặt hàng" class="btn btn-primary btn-sm">
               </form >
            </div>
        </div>
    </section>
    <!--/#cart_items-->
@endsection
