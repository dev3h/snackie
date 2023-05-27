## 1: Install

-   [laravel excel](https://docs.laravel-excel.com/3.1/getting-started/installation.html)

```bash
composer require maatwebsite/excel
```

- In config/app.php

```php
'providers' => [
    ...
    Maatwebsite\Excel\ExcelServiceProvider::class,
],

'aliases' => [
    ...
    'Excel' => Maatwebsite\Excel\Facades\Excel::class,
],
```
