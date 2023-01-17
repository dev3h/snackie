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
                        <form role="form" method="post" action="{{ route('product.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên {{ $messageName }}</label>
                                <input type="text" name="name" class="form-control" id="exampleInputEmail1"
                                    placeholder="tên {{ $messageName }}" />
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Giá {{ $messageName }}</label>
                                <input type="text" name="price" class="form-control" id="exampleInputEmail1"
                                    placeholder="giá {{ $messageName }}" />
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Ảnh {{ $messageName }}</label>
                                <input type="file" name="image" class="form-control" id="exampleInputEmail1" />
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Mô tả {{ $messageName }}</label>
                                <textarea name="description" style="resize: none" rows="8" class="form-control" id="exampleInputPassword1"
                                    placeholder="mô tả {{ $messageName }}"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Nội dung {{ $messageName }}</label>
                                <textarea name="content" style="resize: none" rows="8" class="form-control" id="exampleInputPassword1"
                                    placeholder="nội dung {{ $messageName }}"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Danh mục {{ $messageName }}</label>
                                <select name="category_id" class="form-control input-sm m-bot15">
                                    @foreach ($categories_product as $category_product)
                                        <option value="{{ $category_product->id }}">{{ $category_product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Thương hiệu {{ $messageName }}</label>
                                <select name="brand_id" class="form-control input-sm m-bot15">
                                    @foreach ($brands_product as $brand_product)
                                        <option value="{{ $brand_product->id }}">{{ $brand_product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Hiển thị</label>
                                <select name="status" class="form-control input-sm m-bot15">
                                    <option value="0">Ẩn</option>
                                    <option value="1">Hiển thị</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-info">Thêm</button>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
