-   [capcha](https://www.google.com/recaptcha/admin/create)

---

## Cách tạo capcha

-   Đặt tên label -> reCAPTCHA v2 -> 'I'm not a robot' Checkbox
-   ở phần domains thêm localhost. Về sau đẩy lên server thì thêm tên domain của web -> submit
-   sau khi submit nó sẽ tạo ra được key và secret key

---

## thêm js

-   sau khi nó hiển thị key và secret key thì bấm vô `see client side integration`. Sau đó kéo xuống sẽ thấy đoạn code, copy script

---

## thêm key và secret key vào file .env

---

## cài composer captcha

```bash
composer require google/recaptcha
```

## Tạo rule
```bash
php artisan make:rule CaptchaRule
```
- Trong `app\Rules\CaptchaRule.php` thêm code
```php
use ReCaptcha\ReCaptcha;

public function passes($attribute, $value)
{
    $recaptcha = new ReCaptcha(env('CAPTCHA_SECRET'));
    $response = $recaptcha->verify($value, $_SERVER['REMOTE_ADDR']);
    return $response->isSuccess();
}

public function message()
    {
        return 'check vào ô bạn ko phải robot';	
    }
```
## Thêm giao diện captcha vào trang đăng ký
- Nếu mà nó hiển thị invalid site thì vào trang mà chúng ta vừa tạo recaptcha bấm vô setting -> tắt `verify the origin of reCAPTCHA solutions`

## trong CustomerAuthController.php
```php
use App\Rules\CapchaRule;
```
- Kiểm tra xem đã check vô captcha chưa
