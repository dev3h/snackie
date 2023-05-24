<aside>
    <div id="sidebar" class="nav-collapse">
        <!-- sidebar menu start-->
        <div class="leftside-navigation">
            <ul class="sidebar-menu" id="nav-accordion">
                <li>
                    <a class="active" href="{{ route('admin.dashboard') }}">
                        <i class="fa fa-dashboard"></i>
                        <span>Tổng quan</span>
                    </a>
                </li>

                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Danh mục sản phẩm</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{ route('admin.category_product.create') }}">Thêm</a></li>
                        <li><a href="{{ route('admin.category_product.index') }}">Liệt kê</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Thương hiệu sản phẩm</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{ route('admin.brand_product.create') }}">Thêm</a></li>
                        <li><a href="{{ route('admin.brand_product.index') }}">Liệt kê</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Sản phẩm</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{ route('admin.product.create') }}">Thêm</a></li>
                        <li><a href="{{ route('admin.product.index') }}">Liệt kê</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Tài khoản nhân viên</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{ route('admin.employee.create') }}">Thêm</a></li>
                        <li><a href="{{ route('admin.employee.index') }}">Liệt kê</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Mã giảm giá</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{ route('admin.coupon.create') }}">Thêm</a></li>
                        <li><a href="{{ route('admin.coupon.index') }}">Liệt kê</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="{{ route('admin.order.index') }}">
                        <i class="fa fa-book"></i>
                        <span>Đơn hàng</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- sidebar menu end-->
    </div>
</aside>
