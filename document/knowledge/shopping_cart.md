-   [https://packagist.org/packages/bumbummen99/shoppingcart]

```bash
composer require bumbummen99/shoppingcart
```

-   `use Gloudemans\Shoppingcart\Facades\Cart;`
-   Chúng ta sẽ tạo những trường này, không được thạy đổi vì nó là cố định của package
    -   id
    -   qty
    -   name
    -   price
    -   weight: nêu sản phẩm không có weight thì vẫn phải khai báo vào, nếu không sẽ bị lỗi
