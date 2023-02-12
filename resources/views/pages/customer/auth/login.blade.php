<div class="login-form">
    <!--login form-->
    <h2>Đăng nhập</h2>
    <form action="{{ route('customer.process_login') }}" method="post">
        @csrf
        <label for="">Email</label>
        <br>
        <input type="email" name="email" placeholder="email" />
        <label for="">Mật khẩu</label>
        <br>
        <input type="password" name="password" placeholder="mật khẩu" />
        <span>
            <input type="checkbox" class="checkbox">
            Ghi nhớ đăng nhập
        </span>
        <button type="submit" class="btn btn-default">Đăng nhập</button>
    </form>
</div>
<!--/login form-->
