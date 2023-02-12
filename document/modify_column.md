- Thay đổi kiểu dữ liệu của một cột trong một bảng
```bash
php artisan make:migration alter_change_column_total_price_in_orders_table
```
- Trong file `2023_02_12_231547_alter_change_column_total_price_in_orders_table`
```php
public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->text('total_price')->change();
        });
    }
```
- Sau đó chạy `php artisan migrate`
- Lỗi yêu cầu cài đặt `doctrine/dbal`
```bash
composer require doctrine/dbal
```
- sau khi cài đặt mà báo lỗi `Class 'Doctrine\DBAL\Driver\PDOMySql\Driver' not found` thì trong `composer.json` đổi phiên bản của `doctrine/dbal` thành `"doctrine/dbal": "^2.0"`, sau đó chạy `composer update`
