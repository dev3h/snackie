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
                    $message = session()->get('message');
                    if ($message) {
                        echo '<span class="text-alert">' . $message . '</span>';
                        session()->put('message', null);
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
                            <th>Tên sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Đã bán</th>
                            <th>Giá</th>
                            <th>Ảnh</th>
                            <th>Danh mục</th>
                            <th>Thương hiệu</th>
                            <th>Hiển thị</th>
                            <th style="width:30px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $each)
                            <tr>
                                <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label>
                                </td>
                                <td>{{ $each->name }}</td>
                                <td>{{ $each->quantity }}</td>
                                <td>{{ $each->sold }}</td>
                                <td>{{ number_format($each->price) }}</td>
                                <td><img src="{{asset('uploads/products/' . $each->image)}}" alt="" width="50" height="50"></td>
                                <td>{{$each->category_name}}</td>
                                <td>{{$each->brand_name}}</td>
                                <td>
                                    @if ($each->status == 1)
                                        <a href="{{ route( $asRoute . '.inactive', $each->id) }}"
                                            class='btn btn-success' title="hiện"><span class='fa fa-eye' ></span></a>
                                    @else
                                        <a href="{{ route( $asRoute . '.active', $each->id) }}"
                                            class='btn btn-danger' title="ẩn"><span class='fa fa-eye-slash'></span></a>
                                    @endif
                                </td>
                                <td>
                                    <div class="button-group">
                                        <a href="{{ route( $asRoute . '.edit', $each) }}" class="active table-button"
                                            ui-toggle-class="" title="sửa">
                                            <i class="fa fa-pencil-square-o text-success text-active"></i>
                                        </a>
                                        <form action="{{ route( $asRoute . '.destroy', $each) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="return confirm('Bạn có chắc muốn xóa {{ $messageName }} này không?')"
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
