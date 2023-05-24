@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">Sửa {{ $messageName }}</header>
            <div class="panel-body">
                 @php
                    $message = session()->get('message');
                    if($message) {
                        echo '<span class="text-alert">'.$message.'</span>';
                        session()->put('message', null);
                    }
                @endphp
                <div class="position-center">
                    <form role="form" method="post" action="{{route( $asRoute . '.update', $each)}}">
                        @csrf
                         @method('PUT')
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên đăng nhập</label>
                            <input type="text" name="username" value="{{$each->username}}" class="form-control" id="exampleInputEmail1" placeholder="tên đăng nhập" />
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên hiển thị</label>
                            <input type="text" name="displayname" value="{{$each->displayname}}" class="form-control" id="exampleInputEmail1" placeholder="tên hiển thị" />
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email</label>
                            <input type="text" name="email" value="{{$each->email}}" class="form-control" id="exampleInputEmail1" placeholder="email" />
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Sdt</label>
                            <input type="text" name="phone" value="{{$each->phone}}" class="form-control" id="exampleInputEmail1" placeholder="sdt" />
                        </div>
                        <div class="form-group">
                                <label for="exampleInputPassword1">Quyền</label>
                                <select name="status" class="form-select">
                                    @foreach ($arrRole as $key => $value)
                                        <option value={{ $value }}
                                        @if ($each->role == $value)
                                            selected
                                        @endif
                                        >{{ $key }}</option>
                                    @endforeach
                                </select>
                            </div>
                        <button type="submit" class="btn btn-info">Cập nhập</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
 @push('ckeditor_js')
      <script type="text/javascript" src="{{ asset('backend/ckeditor/ckeditor.js') }}"></script>
      <script>
        CKEDITOR.replaceClass = 'ckeditor'
        CKEDITOR.config.height = 200;
      </script>
    @endpush
@endsection

