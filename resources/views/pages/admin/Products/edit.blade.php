@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">Sửa thương hiệu sản phẩm</header>
            <div class="panel-body">
                 @php
                    $message = session()->get('message');
                    if($message) {
                        echo '<span class="text-alert">'.$message.'</span>';
                        session()->put('message', null);
                    }
                @endphp
                <div class="position-center">
                    <form role="form" method="post" action="{{route('brand_product.update', $each)}}">
                        @csrf
                         @method('PUT')
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên thương hiệu sản phẩm</label>
                            <input type="text" name="name" value="{{$each->name}}" class="form-control" id="exampleInputEmail1" placeholder="tên thương hiệu sản phẩm" />
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả thương hiệu sản phẩm</label>
                            <textarea name="description" style="resize: none" rows="8" class="form-control" id="exampleInputPassword1" placeholder="mô tả thương hiệu sản phẩm">{{$each->description}}</textarea>
                        </div>
                        <button type="submit" class="btn btn-info">Cập nhập</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection

