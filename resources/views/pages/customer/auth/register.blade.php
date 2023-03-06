<div class="signup-form">
    <!--sign up form-->
    <h2>Đăng ký</h2>
    <form action="{{ route('customer.process_register') }}" method="post">
        @csrf

        @auth
            <label for="">Tên</label>
            <input type="text" name="name" placeholder="tên" disabled value="{{ auth()->name }}" />
            <label for="">Email</label>
            <input type="email" name="email" placeholder="Email" disabled value="{{ auth()->email }}" />
        @endauth

        @guest
            <label for="">Tên</label>
            <input type="text" name="name" placeholder="tên" />
            <label for="">Email</label>
            <input type="email" name="email" placeholder="Email" />
        @endguest
        <label for="">Số điện thoại</label>
        <input type="text" name="phone" placeholder="Số điện thoại" />
        <label for="">Mật khẩu</label>
        <input type="password" name="password" placeholder="mật khẩu" />

        {{-- captcha --}}
        <div class="g-recaptcha" data-sitekey="{!! env('CAPTCHA_KEY','NO-KEY-FOUND') !!}"></div>
        <br />
        @if ($errors->has('g-recaptcha-response'))
            <span class="invalid-feedback" style="display:block">
                <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
            </span>
        @endif
        {{-- end --}}
        <button type="submit" class="btn btn-default">Đăng ký</button>
    </form>
</div>
<!--/sign up form-->
