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
                                    <td class="cart_product">
                                        <a href=""><img src="{{ asset('uploads/products/' . $each['image']) }}"
                                                alt="" width="50" height="50"></a>
                                    </td>
                                    <td class="cart_description">
                                        <h4><a href="">{{ $each['name'] }}</a></h4>
                                        <p>ID: {{ $each['id'] }}</p>
                                    </td>
                                    <td class="cart_price">
                                        <p>{{ number_format($each['price'], 0, ',', '.') }}</p>
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

                                            {{-- <form method="post" action="{{ route('customer.update_qty_cart') }}">
                                                @csrf
                                                <input type="hidden" name="rowId" value="{{ $cart->rowId }}">
                                                <input class="cart_quantity_input" type="number" name="qty"
                                                    value="{{ $cart->qty }}" min="1">
                                                <input type="submit" value="Cập nhập" class="btn btn-default btn-sm">
                                            </form> --}}

                                        </div>
                                    </td>
                                    <td class="cart_total">
                                        <p class="cart_total_price">
                                            {{ number_format($price_products, 0, ',', '.') }}
                                        </p>
                                    </td>
                                    <td class="cart_delete">
                                        <button class="cart_quantity_delete btn-delete" data-id="<?php echo $id ?>"><i class="fa fa-times"></i></button>
                                        {{-- <a class="cart_quantity_delete"
                                            href="{{ route('customer.delete__item_cart', $cart->rowId) }}"><i
                                                class="fa fa-times"></i></a> --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <section id="do_action">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="total_area">
                                    <ul>
                                        <li>Tạm tính <span>{{ number_format($subtotal, 0, ',', '.') }}</span></li>
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
        <script>
            $(document).ready(function() {
                $(".btn-update-quantity").click(function() {
                    let btn = $(this);
                    let id = btn.data("id");
                    let type = parseInt(btn.data("type"));
                    $.ajax({
                        url: "{{ route('customer.update_qty_cart') }}",
                        type: "get",
                        data: {
                            id,
                            type,
                        },
                    }).done(function(res) {
                        const cartQuantity = $("#cart-quantity");
                        let parent_tr = btn.parents("tr");
                        let price = parent_tr.find(".span-price").text();

                        price = price.replace(".", "");
                        let quantity = parent_tr.find(".span-quantity").val();
                        if (type == 1) {
                            quantity++;
                        } else {
                            quantity--;
                        }

                        if (quantity === 0) {
                            parent_tr.remove();
                        } else {
                            parent_tr.find(".span-quantity").val(quantity);
                            let sum = price * quantity;

                            sum = sum.toLocaleString("vi-VN", {
                                currency: "VND",
                            });

                            parent_tr.find(".span-sum").text(sum);
                        }
                        getTotal();
                        if (res.data != null) {
                            $.trim(cartQuantity.text(res.data));
                        }
                    });
                });
                $(".btn-delete").click(function() {
                    let btn = $(this);
                    let id = btn.data("id");
                    $.ajax({
                        url: "{{route('customer.delete__item_cart')}}",
                        type: "get",
                        data: {
                            id,
                        },
                    }).done(function(res) {
                        const cartQuantity = $("#cart-quantity");
                        btn.parents("tr").remove();
                        getTotal();
                        if (res.data != null) {
                            $.trim(cartQuantity.text(res.data));
                        }
                    });
                });
            });

            function getTotal() {
                let total = 0;
                let payment = 0;
                let shipping = 20000;

                $(".span-sum").each(function() {
                    let sum = $(this).text();
                    sum = sum.replaceAll(".", "");
                    console.log("sum", sum);
                    total += parseInt(sum);
                });
                payment = total + shipping;

                total = total.toLocaleString("vi-VN", {
                    currency: "VND",
                });

                payment = payment.toLocaleString("vi-VN", {
                    currency: "VND",
                });
                $("#span-total").text(total);
                $("#span-payment").text(payment);
            }
        </script>
    @endpush

@endsection
