@extends('customer_layout')
@section('content')
    <section id="cart_items">
        <div class="container">
            <nav aria-label="breadcrumb" class="mt-5">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('customer.home') }}">{{ __('frontpage.home') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                </ol>
            </nav>
            <!--/breadcrums-->

            <div class="shopper-informations">
                <div class="row">
                    <div class="col-sm-12 col-md-7">
                        <div class="bill-to">
                            <p>Địa chỉ nhận hàng</p>
                            <div class="form-one">
                                <form method="post" action="{{ route('customer.process_checkout') }}">
                                    @csrf
                                    <div class="checkout-group">
                                        <label for="">Tên người nhận</label>
                                        <input type="text" name="name_receiver" class="form-control"
                                            placeholder="Họ và tên người nhận"
                                            value="{{ $shipping_info->name_receiver ?? null }}">
                                    </div>
                                    <div class="checkout-group">
                                        <label for="">Sđt người nhận</label>
                                        <input type="text" name="phone_receiver" class="form-control"
                                            placeholder="Số điện thoại người nhận"
                                            value="{{ $shipping_info->phone_receiver ?? null }}">
                                    </div>
                                    <div class="checkout-group">
                                        <label for="">Địa chỉ người nhận</label>
                                        <input type="text" name="address_receiver" class="form-control"
                                            placeholder="Địa chỉ người nhận"
                                            value="{{ $shipping_info->address_receiver ?? null }}">
                                    </div>
                                    <div class="checkout-group">
                                        <label for="">Lời nhắn</label>
                                        <input type="text" name="note" class="form-control"
                                            placeholder="Lưu ý Người bán">
                                    </div>
                                    {{-- phương thức thanh toán --}}
                                    <div>
                                        <span>Phương thức thanh toán</span>
                                        @csrf
                                        <div class="payment-options">
                                            @foreach ($arrPaymentMethod as $option => $value)
                                                <span>
                                                    <label><input type="radio" class="payment-method" name="method"
                                                            value="{{ $value }}">
                                                        {{ $option }}</label>
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="list-group d-none list-payment-online">
                                        <label class="list-group-item list-group-item-action list-group-item-danger">
                                            <input class="form-check-input me-1" type="radio" name="payment_online"
                                                value="vnpay">
                                            vnpay
                                        </label>
                                        <label class="list-group-item list-group-item-action list-group-item-info">
                                            <input class="form-check-input me-1" type="radio" name="payment_online"
                                                value="momo">
                                            momo
                                        </label>
                                    </div>
                                    <input type="submit" value="Thanh toán" class="btn btn-primary btn-sm">
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-5">
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

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/#cart_items-->
    @push('checkout')
        @include('pages.customer.ajaxBlade.checkoutHandler')
    @endpush
@endsection
