<div class="col-sm-12 col-md-3">
    <div class="left-sidebar">
        <h2>Danh mục sản phẩm</h2>
        <div class="panel-group category-products" id="accordian">
            <!--category-productsr-->
            @foreach ($categories_product as $category_product)
                <div class="panel panel-default">
                    <a href="{{ route('customer.category_product_selected', $category_product->slug) }}"
                        class="panel-heading">{{ $category_product->name }}</a>
                </div>
            @endforeach
        </div>
        <!--/category-products-->

        <div class="brands_products">
            <!--brands_products-->
            <h2>Thương hiệu sản phẩm</h2>

            <div class="brands-name">
                @foreach ($brands_product as $brand_product)
                    <div class="panel-default"><a
                            href="{{ route('customer.brand_product_selected', $brand_product->slug) }}"
                            class="panel-heading">{{ $brand_product->name }}</a></div>
                @endforeach
            </div>
        </div>
        <!--/brands_products-->

        {{-- <div class="price-range">
            <!--price-range-->
            <h2>Price Range</h2>
            <div class="well text-center">
                <input type="text" class="span2" value="" data-slider-min="0" data-slider-max="600"
                    data-slider-step="5" data-slider-value="[250,450]" id="sl2"><br />
                <b class="pull-left">$ 0</b> <b class="pull-right">$ 600</b>
            </div>
        </div> --}}
        <!--/price-range-->
    </div>
</div>
