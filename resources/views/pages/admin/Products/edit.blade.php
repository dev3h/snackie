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
                        <form role="form" method="post" action="{{ route($asRoute . '.update', $each) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên {{ $messageName }}</label>
                                <input type="text" value="{{ $each->name }}" name="name" class="form-control"
                                    id="exampleInputEmail1" placeholder="tên {{ $messageName }}" />
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Giá {{ $messageName }}</label>
                                <input type="text" value="{{ $each->price }}" name="price" class="form-control"
                                    id="exampleInputEmail1" placeholder="giá {{ $messageName }}" />
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Ảnh {{ $messageName }}</label>
                                <input type="file" name="image" class="form-control" id="exampleInputEmail1" />
                                <label for="">Ảnh cũ</label>
                                <img src="{{ asset('uploads/products/' . $each->image) }}" height="100" alt="">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Mô tả {{ $messageName }}</label>
                                <textarea name="description" style="resize: none" rows="8" class="form-control" id="exampleInputPassword1"
                                    placeholder="mô tả {{ $messageName }}">{{ $each->description }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Nội dung {{ $messageName }}</label>
                                <textarea name="content" style="resize: none" rows="8" class="form-control" id="exampleInputPassword1"
                                    placeholder="nội dung {{ $messageName }}">{{ $each->content }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Danh mục {{ $messageName }}</label>
                                <select name="category_id" class="form-control input-sm m-bot15">
                                    @foreach ($categories_product as $category_product)
                                        <option value="{{ $category_product->id }}"
                                            @if ($category_product->id == $each->category_id) selected @endif>{{ $category_product->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Thương hiệu {{ $messageName }}</label>
                                <select name="brand_id" class="form-control input-sm m-bot15">
                                    @foreach ($brands_product as $brand_product)
                                        <option value="{{ $brand_product->id }}"
                                            @if ($brand_product->id == $each->brand_id) selected @endif>{{ $brand_product->name }}
                                        </option>
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
@endsection
