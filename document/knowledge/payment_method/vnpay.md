- [vnpay](https://sandbox.vnpayment.vn/apis/docs/huong-dan-tich-hop/)

- Đầu tiên ta sẽ đăng ký một tài khoản test ở tab `Đăng ký test`. Tên web và đia chỉ url thì chúng ta nhập đại cũng được, (url không nhận localhost) (vd: url: abc.xyz), nhưng email thì
- Sau khi xác nhận mail thì nó sẽ gửi cho chúng ta hướng dẫn. Chúng ta sẽ quan tâm đến `vnp_TmnCode` và `vnp_HashSecret` để sử dụng trong quá trình tích hợp
-Sau đó copy code và paste vào function paymentMethod trong `checkoutController.php`. Ta sẽ thêm cái TmnCode và HashSecret vừa nhận ở mail vào