@extends('admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <div class="panel-body">
                    @php
                        $message = session()->get('message');
                        if ($message) {
                            echo '<span class="text-alert">' . $message . '</span>';
                            session()->put('message', null);
                        }
                    @endphp
                    <div class="card">
                        <h5 class="card-header text-center">
                            Thêm {{ $messageName }}
                        </h5>
                        <div class="card-body">
                            <form role="form" method="post" action="{{ route($asRoute . '.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên đăng nhập</label>
                                <input type="text" name="username" class="form-control" id="exampleInputEmail1"
                                    placeholder="tên đăng nhập" />
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên hiển thị</label>
                                <input type="text" name="displayname" class="form-control" id="exampleInputEmail1"
                                    placeholder="tên hiển thị" />
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email</label>
                                <input type="text" name="email" class="form-control" id="exampleInputEmail1"
                                    placeholder="email" />
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Mật khẩu</label>
                                <input type="text" name="password" class="form-control" id="exampleInputEmail1"
                                    placeholder="password" />
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Sđt</label>
                                <input type="text" name="phone" class="form-control" id="exampleInputEmail1"
                                    placeholder="phone" />
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Quyền</label>
                                <select name="status" class="form-select">
                                    @foreach ($arrRole as $key => $value)
                                        <option value={{ $value }}>{{ $key }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Trạng thái</label>
                                <select name="status" class="form-select">
                                    <option value="0">Khóa</option>
                                    <option value="1">Kích hoạt</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-info mt-2">Thêm</button>
                        </form>
                        </div>
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
