@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
<div class="panel panel-default">
    <div class="panel-heading">Liệt kê {{$messageName}}</div>
  
    <div class="table-responsive">
        @php
            $message = session()->get('message');
            if($message) {
                echo '<span class="text-alert">'.$message.'</span>';
                session()->put('message', null);
            }
        @endphp
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th>Tên đăng nhập</th>
            <th>Tên hiển thị</th>
            <th>Email</th>
            <th>Quyền</th>
            <th>Trạng thái</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
            @foreach ($data as $each)
              <tr>
                <td>{{$each->username}}</td>
                <td>{{$each->displayname}}</td>
                <td>{{$each->email}}</td>
                <td>{{$each->role_name}}</td>
                <td>
                    @if ($each->status == 1)
                        <a href="{{route( $asRoute . '.inactive', $each->id)}}" class='btn btn-success' title="kích hoạt"><span class='fa fa-unlock'></span></a>
                    @else
                        <a href="{{route( $asRoute . '.active', $each->id)}}" class='btn btn-danger' title="khóa"><span class='fa fa-lock'></span></a>
                    @endif
                </td>
                <td>
                    <div class="button-group">
                        <a href="{{route( $asRoute . '.edit', $each)}}" class="active table-button" ui-toggle-class="" title="sửa">
                            <i class="fa fa-pencil-square-o text-success text-active"></i>
                        </a>
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

