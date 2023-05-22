@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">Liệt kê {{ $messageName }}</div>

            <div class="table-responsive">
                @php
                    if (session()->has('success')) {
                        echo '<span class="text-alert">' . session('success') . '</span>';
                    }
                @endphp
                <table class="table table-striped b-t b-light">
                    <thead>
                        <tr>
                            <th>Tên người đặt</th>
                            <th>Tổng đơn hàng</th>
                            <th>Tình trạng</th>
                            <th>Thời gian đặt hàng</th>
                            <th style="width:30px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->customer_name }}</td>
                                <td>{{ number_format($order->total_price) }}</td>
                                <td>{{ $order->status_name }}</td>
                                <td>{{ $order->created_at }}</td>
                                <td></td>
                                <td>
                                    <div class="button-group">
                                        <a href="{{ route($asRoute . '.show', $order) }}" class="active table-button"
                                            ui-toggle-class="" title="xem">
                                            <i class="fa fa-eye text-success text-active"></i>
                                        </a>
                                        <form action="{{ route($asRoute . '.destroy', $order) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                onclick="return confirm('Bạn có chắc muốn xóa {{ $messageName }} này không?')"
                                                class="active table-button" ui-toggle-class="" title="xóa">
                                                <i class="fa fa-times text-danger text"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <footer class="panel-footer">
                <div class="row">
                    <div class="col-sm-5 text-center">
                        <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
                    </div>
                    <div class="col-sm-7 text-right text-center-xs">
                        <ul class="pagination pagination-sm m-t-none m-b-none">
                            <li><a href=""><i class="fa fa-chevron-left"></i></a></li>
                            <li><a href="">1</a></li>
                            <li><a href="">2</a></li>
                            <li><a href="">3</a></li>
                            <li><a href="">4</a></li>
                            <li><a href=""><i class="fa fa-chevron-right"></i></a></li>
                        </ul>
                    </div>
                </div>
            </footer>
        </div>
    </div>
@endsection
