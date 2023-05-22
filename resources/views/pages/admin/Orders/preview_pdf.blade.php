<html>

<head>
    <style>
        * {
            font-family: DejaVu Sans !important;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid black;
        }
    </style>
</head>

<body>
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">Thông tin vận chuyển</div>
            <div class="table-responsive">
                <table class="table table-striped b-t b-light">
                    <thead>
                        <tr>
                            <th>Tên người nhận</th>
                            <th>Địa chỉ</th>
                            <th>Số điện thoại</th>
                            <th>Phương thức thanh toán</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $order_shipping->name_receiver }}</td>
                            <td>{{ $order_shipping->address_receiver }}</td>
                            <td>{{ $order_shipping->phone_receiver }}</td>
                            <td>{{ $paymentMethod }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <br><br>
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">Chi tiết đơn hàng</div>
            <div class="table-responsive">
                <table class="table table-striped b-t b-light">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Trong kho</th>
                            <th>Số lượng đặt</th>
                            <th>Giá</th>
                            <th>Tổng tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order_products as $order_product)
                            <tr>
                                <td>{{ $order_product->product_name }}</td>
                                <td>{{ $order_product->product_quantity }}</td>
                                <td>{{ $order_product->order_quantity }}</td>
                                <td>{{ number_format($order_product->product_price) }}</td>
                                <td>{{ number_format($order_product->product_price * $order_product->order_quantity) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
