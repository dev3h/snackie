-   [https://ckeditor.com/ckeditor-4/download/]
-   Tích vào Easy image -> bản 72 plugin rồi down về
-   giải nén sau đó chuyển thư mục vào trong `public/backend`
-   Vào `admin_layout` và link js vào: `ckeditor.js`. Sau đó thì tạo thêm 1 script để khởi tạo ckeditor

```js
<script>
    CKEDITOR.replaceClass = 'ckeditor'; CKEDITOR.config.height = 400;
</script>
```

-   cái replaceClass là nó sẽ tìm những cái class tên là ckeditor và thay thế bằng ckeditor để dùng được các tính năng của ckeditor, nó chỉ hữu dụng cho thằng textarea
