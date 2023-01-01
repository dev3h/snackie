 <header class="header fixed-top clearfix">
    <!--logo start-->
    <div class="brand">
        <a href="{{route('dashboard')}}" class="logo">ADMIN</a>
        <div class="sidebar-toggle-box">
            <div class="fa fa-bars"></div>
        </div>
    </div>
    <!--logo end-->
    <div class="top-nav clearfix">
        <!--search & user info start-->
        <ul class="nav pull-right top-menu">
            <li>
                <input type="text" class="form-control search" placeholder=" Search" />
            </li>
            <!-- user login dropdown start-->
            <li class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <img alt="" src="{{asset('backend/images/2.png')}}">
                    <span class="username">John Doe</span>
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu extended logout">
                    <li><a href="#"><i class=" fa fa-suitcase"></i>Thông tin</a></li>
                    <li><a href="#"><i class="fa fa-cog"></i>Cài đặt</a></li>
                    <li><a href="login.html"><i class="fa fa-key"></i>Đăng xuất</a></li>
                </ul>
            </li>
            <!-- user login dropdown end -->
        </ul>
        <!--search & user info end-->
    </div>
</header>
