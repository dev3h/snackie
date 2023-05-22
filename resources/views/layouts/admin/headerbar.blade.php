 <header class="header fixed-top clearfix">
     <!--logo start-->
     <div class="brand">
         <a href="{{ route('admin.dashboard') }}" class="logo">ADMIN</a>
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
                 <a data-bs-toggle="dropdown" aria-expanded="false">
                     <img alt="" src="{{ asset('backend/images/2.png') }}">
                     <span class="username">
                         @php
                             $name = session()->get('admin_name');
                             if ($name) {
                                 echo $name;
                             }
                         @endphp
                     </span>
                     <b class="caret"></b>
                 </a>
                 <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                     <li><a class="dropdown-item" href="#">Thông tin</a></li>
                     <li><a class="dropdown-item" href="{{ route('admin.logout') }}">Đăng xuất</a></li>
                 </ul>
             </li>
             <!-- user login dropdown end -->
         </ul>
         <!--search & user info end-->
     </div>
 </header>
