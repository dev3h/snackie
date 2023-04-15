<div class="login-form">
    <!--login form-->
    <form action="{{ route('customer.process_login') }}" method="post">
        @csrf
        <div>
            <label class="form-label" for="email-login" >Email</label>
            <input class="form-control" type="email" name="email" id="email-login" placeholder="email" />
        </div>
        <div class="mt-4">
            <label class="form-label" for="password-login" >Mật khẩu</label>
            <input class="form-control" type="password" name="password" id="password-login" placeholder="mật khẩu" />
        </div>
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
        <a href="{{ route('customer.socialite_redirect', 'google') }}"><i class="fa fa-google-plus"></i></a>
    </div>
    </ul>
</div>
<!--/login form-->
