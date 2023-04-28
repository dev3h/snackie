@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">Liệt kê {{ $messageName }}</div>
            <div class="row w3-res-tb">
                <div class="col-sm-5 m-b-xs">
                    <select class="input-sm form-control w-sm inline v-middle">
                        <option value="0">Bulk action</option>
                        <option value="1">Delete selected</option>
                        <option value="2">Bulk edit</option>
                        <option value="3">Export</option>
                    </select>
                    <button class="btn btn-sm btn-default">Apply</button>
                </div>
                <div class="col-sm-4">
                </div>
                <div class="col-sm-3">
                    <div class="input-group">
                        <input type="text" class="input-sm form-control" placeholder="Search">
                        <span class="input-group-btn">
                            <button class="btn btn-sm btn-default" type="button">Go!</button>
                        </span>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                @php
                    if (session()->has('success')) {
                        echo '<span class="text-alert">' . session('success') . '</span>';
                    }
                @endphp
                <table class="table table-striped b-t b-light">
                    <thead>
                        <tr>
                            <th style="width:20px;">
                                <label class="i-checks m-b-none">
                                    <input type="checkbox"><i></i>
                                </label>
                            </th>
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
                                <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label>
                                </td>
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
