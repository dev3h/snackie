@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">Thêm danh mục sản phẩm</header>
            <div class="panel-body">
                <div class="position-center">
                    <form role="form" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên danh mục sản phẩm</label>
                            <input type="text" name="category_product_name" class="form-control" id="exampleInputEmail1" placeholder="tên danh mục sản phẩm" />
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả danh mục sản phẩm</label>
                            <textarea name="category_product_desc" style="resize: none" rows="8" class="form-control" id="exampleInputPassword1" placeholder="mô tả danh mục sản phẩm"></textarea>
                        </div>
                        <div class="form-group">
                             <label for="exampleInputPassword1">Hiển thị</label>
                            <select class="form-control input-sm m-bot15">
                                <option>Ẩn</option>
                                <option>Hiển thị</option>
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

