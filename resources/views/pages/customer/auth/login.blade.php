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
    <p>hoặc</p>

    <div style="display: flex; gap: 20px">
        <a href="{{ route('customer.socialite_redirect', 'github') }}"><i class="fa fa-github"></i></a>
        <a href="{{ route('customer.socialite_redirect', 'facebook') }}"><i class="fa fa-facebook"></i></a>
    </div>
    </ul>
</div>
<!--/login form-->
