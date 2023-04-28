@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">Thông tin khách hàng</div>
            <div class="table-responsive">
                @php
                    if (session()->has('success')) {
                        echo '<span class="text-alert">' . session('success') . '</span>';
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
        <form method='post' action="{{ route($asRoute . '.update', $order_by_id) }}" class="order-status-select">
            @csrf
            @method('PUT')
            <select name="status" @if ($order_by_id->status == 3) disabled @endif>
                @foreach ($arrOrderStatus as $option => $value)
                    <option value="{{ $value }}" {{ $value == $order_by_id->status ? 'selected' : '' }}>
                        {{ $option }}
                    </option>
                @endforeach
            </select>
            <input type="hidden" name="order_id" value="{{ $order_by_id->id }}">
            <button type="submit" class="btn btn-primary" @if ($order_by_id->status == 3) disabled @endif>Cập
                nhật</button>
        </form>
        <div class="panel panel-default">
            <div class="panel-heading">Chi tiết {{ $messageName }}</div>
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
@endsection
