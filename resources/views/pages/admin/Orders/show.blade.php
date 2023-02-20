@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">Thông tin khách hàng</div>
            <div class="table-responsive">
                @php
                    $message = session()->get('message');
                    if ($message) {
                        echo '<span class="text-alert">' . $message . '</span>';
                        session()->put('message', null);
                    }
                @endphp
                <table class="table table-striped b-t b-light">
                    <thead>
                        <tr>
                            <th>Tên khách hàng</th>
                            <th>Số điện thoại</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $order_by_id->customer_name }}</td>
                            <td>{{ $order_by_id->customer_phone }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <br><br>
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">Thông tin vận chuyển</div>
            <div class="table-responsive">
                @php
                    $message = session()->get('message');
                    if ($message) {
                        echo '<span class="text-alert">' . $message . '</span>';
                        session()->put('message', null);
                    }
                @endphp
                <table class="table table-striped b-t b-light">
                    <thead>
                        <tr>
                            <th>Tên người nhận</th>
                            <th>Địa chỉ</th>
                            <th>Số điện thoại</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $order_by_id->name_receiver }}</td>
                            <td>{{ $order_by_id->address_receiver }}</td>
                            <td>{{ $order_by_id->phone_receiver }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <br><br>
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">Chi tiết {{ $messageName }}</div>
            <div class="table-responsive">
                @php
                    $message = session()->get('message');
                    if ($message) {
                        echo '<span class="text-alert">' . $message . '</span>';
                        session()->put('message', null);
                    }
                @endphp
                <table class="table table-striped b-t b-light">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Giá</th>
                            <th>Tổng tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order_products as $order_product)
                            <tr>
                                <td>{{$order_product->name}}</td>
                                <td>{{$order_product->quantity}}</td>
                                <td>{{number_format($order_product->price)}}</td>
                                <td>{{number_format($order_product->quantity * $order_product->price)}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
