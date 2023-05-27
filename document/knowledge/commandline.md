**Tạo controller**

```php
php artisan make:controller TênController
```

-   Quy ước đặt tên controller: viết hoa chữ cái đầu tiên của từng từ
    **Tạo migration**

```php
php artisan make:migration create_TênBảng_table
```

-   Sau thi thêm các cột thì chạy lệnh thêm các table tạo trong `migrations` vào trong db

```php
php artisan migrate
```

**Tạo eloquent model**

```php
php artisan make:model Course -a
```

-   model thì không có `s`
-   `-a` là tạo tất cả các file liên quan đến model
-   Nó sẽ tạo các file `model`, `factory`, `migration`, `seeder`, `controller`
