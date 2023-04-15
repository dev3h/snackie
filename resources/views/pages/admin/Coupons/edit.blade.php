@extends('admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">Sửa {{ $messageName }}</header>
                <div class="panel-body">
                    @php                        
                        $message = session()->get('message');
                        if ($message) {
                            echo '<span class="text-alert">' . $message . '</span>';
                            session()->put('message', null);
                        }
                    @endphp
                    <div class="position-center">
                        <form role="form" method="post" action="{{ route($asRoute . '.update', $each) }}">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên {{ $messageName }}</label>
                                <input type="text" name="name" value="{{ $each->name }}" class="form-control"
                                    id="exampleInputEmail1" placeholder="tên {{ $messageName }}" />
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">{{ $messageName }}</label>
                                <input type="text" name="code" value="{{ $each->code }}" class="form-control"
                                    id="exampleInputEmail1" placeholder="{{ $messageName }}" />
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Số lượng {{ $messageName }}</label>
                                <input type="text" name="quantity" value="{{ $each->quantity }}" class="form-control"
                                    id="exampleInputEmail1" placeholder="số lượng {{ $messageName }}" />
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Loại {{ $messageName }}</label>
                                <select name="type" class="form-control input-sm m-bot15">
                                    @foreach ($arrCouponType as $option => $value)
                                        <option value="{{ $value }}"
                                            @if ($each->type == $value) selected @endif>{{ $option }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Số % hoặc số tiền giảm</label>
                                <input type="text" value="{{ $each->detail }}" name="detail" class="form-control" id="exampleInputEmail1"
                                    placeholder="Số % hoặc số tiền giảm" />
                            </div>
                            <button type="submit" class="btn btn-info">Cập nhập</button>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
