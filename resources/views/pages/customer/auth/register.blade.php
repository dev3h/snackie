<div class="signup-form">
    <!--sign up form-->
    <form action="{{ route('customer.process_register') }}" method="post">
        @csrf

        @auth
            <label for="" class="form-label">Tên</label>
            <input type="text" name="name" placeholder="tên" disabled value="{{ auth()->name }}" />
            <label for="" class="form-label">Email</label>
            <input type="email" name="email" placeholder="Email" disabled value="{{ auth()->email }}" />
        @endauth

        @guest
            <div>
                <label for="" class="form-label">Tên</label>
                <input type="text" name="name" placeholder="tên" class="form-control" />
            </div>
            <div class="mt-4">
                <label for="" class="form-label">Email</label>
                <input type="email" name="email" placeholder="Email" class="form-control" />
                </divc>
            @endguest
            <div class="mt-4">
                <label for="" class="form-label">Số điện thoại</label>
                <input type="text" name="phone" placeholder="Số điện thoại" class="form-control" />
            </div>
            <div class="mt-4">
                <label for="" class="form-label">Mật khẩu</label>
                <input type="password" name="password" placeholder="mật khẩu" class="form-control" />
            </div>

            {{-- captcha --}}
            <div class="g-recaptcha" data-sitekey="{!! env('CAPTCHA_KEY', 'NO-KEY-FOUND') !!}"></div>
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
