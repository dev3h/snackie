<div class="card login-form">
    <!--login form-->
    <div class="card-body">
        <form action="{{ route('customer.process_login') }}" method="post">
            @csrf
            <div>
                <label class="form-label" for="email-login">Email</label>
                <input class="form-control" type="email" name="email" id="email-login" placeholder="email" />
            </div>
            <div class="mt-4">
                <label class="form-label" for="password-login">Mật khẩu</label>
                <input class="form-control" type="password" name="password" id="password-login"
                    placeholder="mật khẩu" />
            </div>
            <span class="d-flex align-items-center mt-2">
                <input type="checkbox" class="checkbox">
                <span>Ghi nhớ đăng nhập</span>
            </span>
            <button type="submit" class="btn btn-default mt-4">Đăng nhập</button>
        </form>
    </div>
    <div class="card-footer">
        <p>hoặc</p>
        <div class="d-flex">
            <a href="{{ route('customer.socialite_redirect', 'github') }}"><i class="fa fa-github"></i></a>
            <a href="{{ route('customer.socialite_redirect', 'facebook') }}"><i class="fa fa-facebook"></i></a>
            <a href="{{ route('customer.socialite_redirect', 'google') }}"><i class="fa fa-google-plus"></i></a>
        </div>
    </div>
</div>
<!--/login form-->
