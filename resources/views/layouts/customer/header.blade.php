 <header id="header" class="sticky-top">
     <div class="container pt-1">
         <div class="row">
             <div class="col-sm-12 col-lg-3"></div>
             <div class="col-sm-12 col-lg-9">
                 <div class="d-flex justify-content-end align-items-center">

                     {{-- switch lang --}}
                     <div class="dropdown">
                         <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                             aria-expanded="false">
                             Ngôn ngữ
                         </button>
                         <ul class="dropdown-menu">
                             <li><a class="dropdown-item" href="{{ route('lang', 'vi') }}">Tiếng việt</a></li>
                             <li><a class="dropdown-item" href="{{ route('lang', 'en') }}">Tiếng anh</a></li>
                         </ul>
                     </div>
                     <label class="toggle-theme-switch ms-5">
                         <input type="checkbox" id="toggle-theme-input">
                         <span class="toggle-theme-slider"></span>
                     </label>
                     <div class="ms-5">
                         @if (session()->get('customer_id'))
                             <div><a class="link-underline-opacity-0 text-light"
                                     href="{{ route('customer.logout') }}">Đăng
                                     xuất</a>
                             </div>
                         @else
                             <div><a class="link-offset-2 link-underline link-underline-opacity-0 text-light"
                                     href="{{ route('customer.login') }}">Đăng nhập</a>
                             </div>
                         @endif
                     </div>
                 </div>
             </div>
         </div>

         <div class="row">
             <nav class="navbar navbar-expand-lg bg-body-tertiary">
                 <div class="container-fluid">
                     <a class="navbar-brand" href="{{ route('customer.home') }}">
                         <img src="{{ asset('frontend/images/logo.png') }}" alt=""
                             style="width: 100px; height: 100px" loading="lazy" />
                     </a>
                     <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                         data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                         aria-expanded="false" aria-label="Toggle navigation">
                         <span class="navbar-toggler-icon"></span>
                     </button>
                     <div class="collapse navbar-collapse" id="navbarSupportedContent">
                         <ul
                             class="navbar-nav me-auto mb-2 mb-lg-0 mx-sm-auto align-items-sm-center justify-content-md-between w-sm-100 w-lg-75">
                             <li class="nav-item">
                                 <a class="nav-link active" aria-current="page"
                                     href="{{ route('customer.home') }}">{{ __('frontpage.home') }}</a>
                             </li>
                             <li class="nav-item">
                                 <a class="nav-link" aria-current="page" href="#">{{ __('frontpage.shop') }}</a>
                             </li>
                             <li class="nav-item">
                                 <a class="nav-link" aria-current="page" href="#">{{ __('frontpage.news') }}</a>
                             </li>
                             <li class="nav-item">
                                 <a class="nav-link" aria-current="page" href="#">{{ __('frontpage.about') }}</a>
                             </li>
                             <li class="nav-item">
                                 <a class="nav-link" aria-current="page"
                                     href="#">{{ __('frontpage.contact') }}</a>
                             </li>
                         </ul>
                         <button type="button" id="search-btn" class="btn" data-bs-toggle="modal"
                             data-bs-target="#exampleModal"><i class="fa fa-search"></i></button>

                         <li class="nav-item">
                             <a type="button" href="{{ route('customer.cart') }}"
                                 class="btn btn-primary position-relative">
                                 <i class="fa fa-shopping-cart"></i>
                                 @php
                                     $customer_id = session()->get('customer_id') ?? null;
                                 @endphp
                                 @if ($customer_id)
                                     <span id="cart-quantity"
                                         class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                         @php
                                             $cart = session()->get('cart') ?? [];
                                             if (sizeof($cart) > 0) {
                                                 $cart_customer = $cart[$customer_id];
                                                 echo sizeof($cart_customer);
                                             } else {
                                                 echo 0;
                                             }
                                         @endphp
                                         <span class="visually-hidden">unread messages</span>
                                     </span>
                                 @endif

                             </a>
                         </li>
                     </div>
                 </div>
             </nav>
         </div>
     </div>
 </header>
 <div div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body">
                 <form class="d-flex flex-grow-1 search-form" role="search">
                     <input class="form-control me-2" type="search" name="q" value="{{ $search ?? '' }}"
                         placeholder="nhập tên sản phẩm" aria-label="Search">
                     <button class="btn btn-outline-success" type="submit"><i class="fa fa-search"></i></button>
                 </form>
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
             </div>
         </div>
     </div>
 </div>
