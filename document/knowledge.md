```php
<a href="{{URL::to('trang-chu')}}" class="active">Home</a>
```

-   `URL::to()` là một hàm của Laravel, nó sẽ trả về đường dẫn tuyệt đối của trang web. Ví dụ: `http://localhost:8000/trang-chu`

## section, yield, extends

-   `@section`: dùng để định nghĩa một section
-   `@yield`: dùng để hiển thị nội dung của section
-   `@extends`: dùng để kế thừa từ một file khác
- Để có thể hiển thị được trang home khi cắt giao diện, hiển thị phần content khi dùng section và dùng yield để gọi nội dung của section thì ta sẽ tạo một controller. 
- Vd: HomeController.php có hàm index để gọi view `home.blade.php`. Sau khi gọi thì nó chạy qua extends `master.blade.php` và hiển thị nội dung của section `content` bằng yield.

```php


