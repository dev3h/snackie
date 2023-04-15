@extends('admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">Thêm {{ $messageName }}</header>
                <div class="panel-body">
                    @php
                        $message = session()->get('message');
                        if ($message) {
                            echo '<span class="text-alert">' . $message . '</span>';
                            session()->put('message', null);
                        }
                    @endphp
                    <div class="position-center">
                        <form role="form" method="post" action="{{ route($asRoute . '.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên {{ $messageName }}</label>
                                <input type="text" name="name" class="form-control" id="exampleInputEmail1"
                                    placeholder="tên {{ $messageName }}" />
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Mã {{ $messageName }}</label>
                                <input type="text" name="code" class="form-control" id="exampleInputEmail1"
                                    placeholder="{{ $messageName }}" />
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">Số lượng {{ $messageName }}</label>
                                <input type="text" name="quantity" class="form-control" id="exampleInputEmail1"
                                    placeholder="số lượng {{ $messageName }}" />
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Loại {{ $messageName }}</label>
                                <select name="type" class="form-control input-sm m-bot15">
                                    @foreach ($arrCouponType as $option => $value)
                                        <option value="{{ $value }}"
                                            @if ($loop->first) selected @endif>{{ $option }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Số % hoặc số tiền giảm</label>
                                <input type="text" name="detail" class="form-control" id="exampleInputEmail1"
                                    placeholder="Số % hoặc số tiền giảm" />
                            </div>
                            <button type="submit" class="btn btn-info">Thêm</button>
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
