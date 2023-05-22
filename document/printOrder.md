# 1: Install

-   [laravel-dompdf](https://github.com/barryvdh/laravel-dompdf)

```bash
composer require barryvdh/laravel-dompdf
```

-   In `config/app.php`, trong mảng `providers` thêm dòng sau:

```php
Barryvdh\DomPDF\ServiceProvider::class,
```

- Tạo alias cho `PDF` trong mảng `aliases`:

```php
'PDF' => Barryvdh\DomPDF\Facade::class,
```