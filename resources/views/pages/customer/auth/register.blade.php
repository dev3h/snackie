<div class="signup-form">
    <!--sign up form-->
    <h2>Đăng ký</h2>
    <form action="{{ route('customer.process_register') }}" method="post">
        @csrf
        <label for="">Tên</label>
        <input type="text" name="name" placeholder="tên" />
        <label for="">Email</label>
        <input type="email" name="email" placeholder="Email" />
        <label for="">Số điện thoại</label>
        <input type="text" name="phone" placeholder="Số điện thoại" />
        <label for="">Mật khẩu</label>
        <input type="password" name="password" placeholder="mật khẩu" />
        <button type="submit" class="btn btn-default">Đăng ký</button>
    </form>
</div>
<!--/sign up form-->
