-   Tạo **controller**

```php
php artisan make:controller TênController
```

-   Quy ước đặt tên controller: viết hoa chữ cái đầu tiên của từng từ
-   Tạo migration

```php
php artisan make:migration create_TênBảng_table
```

-   Sau thi thêm các cột thì chạy lệnh thêm các table tạo trong `migrations` vào trong db

```php
php artisan migrate
```
