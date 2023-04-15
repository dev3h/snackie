-   [localization](https://laravel.com/docs/8.x/localization#main-content)

-   In `resources/lang/en` folder, create a file `frontpage.php` and add the following code:

```php
return [
    'home' => 'home',
];
```

-   Cách dùng: `__('frontpage.home')`
-   In `config/app.php` replace `locale` with

```php
 'locales' => ['en', 'vi'],
```

-   Thêm route language vào `web.php`

```php
Route::get('/lang/{locale}', function ($locale) {
    $available_locales = config('app.locales', []);

    if (!in_array($locale, $available_locales)) {
        $locale = config('app.fallback_locale');
    }
    session()->put('locale', $locale);

     return redirect()->back();
})->name('lang');
```

-   Cài **laravel translation manager** để lưu ngôn ngữ vào session
-   [laravel translation manager](https://github.com/barryvdh/laravel-translation-manager)

```bash
composer require barryvdh/laravel-translation-manager
```

-   [localization](https://lokalise.com/blog/laravel-localization-step-by-step/)
-   Tạo 1 cái middleware localization để lưu ngôn ngữ vào session
    để luôn set lại language khi bấm thay đổi

```bash
php artisan make:middleware Localization
```

-   Then in Localization.php file, add the following code:

```php
 if (session()->has('locale')) {
            app()->:setLocale(session()->get('locale'));
        }
```

-   Phải khai bão trong kernel.php thì khi chạy qua web nó luôn chạy qua middleware này

```php
protected $middlewareGroups = [
        'web' => [
            // thêm cái này
            \App\Http\Middleware\Localization::class,
        ],
]
```
