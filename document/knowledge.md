## Route

```php
<a href="{{URL::to('trang-chu')}}" class="active">Home</a>
```

-   `URL::to()` là một hàm của Laravel, nó sẽ trả về đường dẫn tuyệt đối của trang web. Ví dụ: `http://localhost:8000/trang-chu`
-   Chúng ta có thể viết ngắn gọn hơn bằng cách dùng `route()` thay cho `URL::to()`. Ví dụ: `route('trang-chu')`

```php
<a href="{{route('trang-chu')}}" class="active">Home</a>
```

-   Dùng khi đặt tên cho route

```php
Route::get('trang-chu', function(){
    return view('home');
})->name('trang-chu');
```

## section, yield, extends

-   `@section`: dùng để định nghĩa một section
-   `@yield`: dùng để hiển thị nội dung của section
-   `@extends`: dùng để kế thừa từ một file khác

```php
@extends('customer_layout')
@section('content')
    <div class="container">
    </div>
@endsection
```

-   In `home`

```php
@yield('content')
```

-   Để có thể hiển thị được trang home khi cắt giao diện, hiển thị phần content khi dùng `@section` và dùng `@yield` để gọi nội dung của `@section` thì ta sẽ tạo một `controller`.
-   Vd: HomeController.php có hàm index để gọi view `home.blade.php`. Sau khi gọi thì nó chạy qua extends `master.blade.php` và hiển thị nội dung của section `content` bằng yield.
