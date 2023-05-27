-   [slug](https://github.com/cviebrock/eloquent-sluggable)
-   Cài đặt:

```bash
composer require cviebrock/eloquent-sluggable
```

-   Thêm `Sluggable` trait vào model cần slug:

```php
use Cviebrock\EloquentSluggable\Sluggable;

class Product extends Model
{
    use Sluggable;

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
```

-   Lưu ý là các bảng muốn dùng slug trong database phải có cột `slug` để lưu slug của bản ghi. Khi tạo hoặc cập nhập thông tin thì slug sẽ tự động cập nhập
