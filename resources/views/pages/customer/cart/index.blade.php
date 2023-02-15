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
            <div class="table-responsive cart_info">
                <table class="table table-condensed">
                    @php
                        $carts = Cart::content();
                    @endphp
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
                                    <a href=""><img src="{{ asset('uploads/products/' . $cart->options->image) }}"
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
                                            <input type="submit" value="Cập nhập" class="btn btn-default btn-sm">
                                        </form>

                                    </div>
                                </td>
                                <td class="cart_total">
                                    <p class="cart_total_price">{{ number_format($cart->price * $cart->qty, 0, ',', '.') }}
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
    </section>
    <!--/#cart_items-->

    <section id="do_action">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="total_area">
                        <ul>
                            <li>Tạm tính <span>{{ Cart::subtotal(0, ',', '.') }}</span></li>
                            <li>Thuế <span>{{ Cart::tax(0, ',', '.') }}</span></li>
                            <li>Phí vận chuyển <span>Miễn phí</span></li>
                            <li>Tổng thanh toán <span>{{ Cart::total(0, ',', '.') }}</span></li>
                        </ul>
                        <a class="btn btn-default check_out" href="{{route('customer.checkout')}}">Mua hàng</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/#do_action-->
@endsection
