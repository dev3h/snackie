## share

-   [button share facebook](https://developers.facebook.com/docs/plugins/share-button/)
-   Khi nào up lên domain thì nhớ thay vào cái

```html
<meta property="og:url" content="https://www.your-domain.com/your-page.html" />
```

-   Bấm nút lấy mã
-   Copy code ở bước 1 vào `customer_layout.blade.php`
-   Sau đó cop code ở bước 2 vào chỗ mà mình muốn chèn cái nút share facebook vào. ở đây mình paste vào `product_detail.blade.php`. Sửa link ở href có cái chữ `u`

---

## like

-   [button like](https://developers.facebook.com/docs/plugins/like-button)
-   Khi nào up lên host thì lúc đăng nhập với facebook thì nó sẽ hiện được số lượt like, còn bên localhost thì khi bấm qua sản phẩm khác rồi bấm lại sản phẩm đó thì nó bị reset lại số lượt like
---
## bình luận
- [comment](https://developers.facebook.com/docs/plugins/comments)
