@extends('customer_layout')
@push('payment-online-css')
    <link href="{{ asset('frontend/css/vnpay.css') }}" rel="stylesheet" />
@endpush
@section('content')
    <div class="table-responsive">
        <form id="create_form" class="form-vnpay" method="post">
            @csrf
            <div class="form-group">
                <label for="language">Loại hàng hóa </label>
                <select name="order_type" id="order_type" class="form-control" required>
                    <option value="billpayment">Thanh toán hóa đơn</option>
                </select>
            </div>
            <div class="form-group">
                <label for="order_id">Mã hóa đơn</label>
                <input class="form-control" id="order_id" name="order_id" type="text" value="{{ $order_id ?? '' }}"
                    readonly />
            </div>
            <div class="form-group">
                <label for="amount">Số tiền</label>
                <input class="form-control" id="amount" name="amount" type="number" value="{{ $total_price ?? '' }}"
                    readonly />
            </div>
            <div class="form-group">
                <label for="order_desc">Nội dung thanh toán</label>
                <textarea class="form-control" cols="20" id="order_desc" name="order_desc" rows="2"
                    placeholder="Nội dung thanh toán" required></textarea>
            </div>
            <div class="form-group" required>
                <label for="bank_code">Ngân hàng</label>
                <select name="bank_code" id="bank_code" class="form-control">
                    <option value="">Không chọn</option>
                    <option value="NCB"> Ngan hang NCB</option>
                    <option value="AGRIBANK"> Ngan hang Agribank</option>
                    <option value="SCB"> Ngan hang SCB</option>
                    <option value="SACOMBANK">Ngan hang SacomBank</option>
                    <option value="EXIMBANK"> Ngan hang EximBank</option>
                    <option value="MSBANK"> Ngan hang MSBANK</option>
                    <option value="NAMABANK"> Ngan hang NamABank</option>
                    <option value="VNMART"> Vi dien tu VnMart</option>
                    <option value="VIETINBANK">Ngan hang Vietinbank</option>
                    <option value="VIETCOMBANK"> Ngan hang VCB</option>
                    <option value="HDBANK">Ngan hang HDBank</option>
                    <option value="DONGABANK"> Ngan hang Dong A</option>
                    <option value="TPBANK"> Ngân hàng TPBank</option>
                    <option value="OJB"> Ngân hàng OceanBank</option>
                    <option value="BIDV"> Ngân hàng BIDV</option>
                    <option value="TECHCOMBANK"> Ngân hàng Techcombank</option>
                    <option value="VPBANK"> Ngan hang VPBank</option>
                    <option value="MBBANK"> Ngan hang MBBank</option>
                    <option value="ACB"> Ngan hang ACB</option>
                    <option value="OCB"> Ngan hang OCB</option>
                    <option value="IVB"> Ngan hang IVB</option>
                    <option value="VISA"> Thanh toan qua VISA/MASTER</option>
                </select>
            </div>
            <div class="form-group">
                <label for="language">Ngôn ngữ</label>
                <select name="language" id="language" class="form-control">
                    <option value="vn">Tiếng Việt</option>
                    <option value="en">English</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary" id="btnPopup">Xác nhận thanh toán</button>
        </form>
    </div>
    @push('payment-online-js')
        <script src="{{ asset('frontend/js/vnpay.js') }}"></script>
        <script type="text/javascript">
            $(".form-vnpay").submit(function(e) {
                e.preventDefault();
                var postData = new FormData(document.querySelector("#create_form"));
                // get csrf token of input name _token in form
                var token = $('input[name=_token]').val();
                postData.append('_token', token);

                postData.append('paymentOnline', 'vnpay');
                console.log(postData)
                $.ajax({
                    type: "POST",
                    url: "{{ route('customer.processPaymentOnline') }}",
                    data: postData,
                    dataType: 'JSON',
                    cache: false,
                    processData: false,
                    success: function(x) {
                        console.log(x.data)
                        if (x.code === '00') {
                            // if (window.vnpay) {
                            //     vnpay.open({width: 768, height: 600, url: x.data});
                            // } else {
                            //
                            // }
                            location.href = x.data;
                            return false;
                        } else {
                            alert(x.Message);
                        }
                    }
                });
                return false;
            });
        </script>
    @endpush
@endsection
