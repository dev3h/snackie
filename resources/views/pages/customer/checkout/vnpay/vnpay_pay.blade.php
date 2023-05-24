<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <title>{{$title}}</title>
        <!-- Bootstrap core CSS -->
        <link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet">
    </head>

    <body>            
        <div class="container">
            <h3>Tạo mới đơn hàng</h3>
            <div class="table-responsive">
                <form action={{route('customer.handle_vnpay_create_payment')}} id="frmCreateOrder" method="post"> 
                    @csrf       
                    <div class="form-group">
                        <label for="amount">Số tiền</label>
                        <input class="form-control" data-val="true" data-val-number="The field Amount must be a number." data-val-required="The Amount field is required." id="amount" max="100000000" min="1" name="amount" type="number" value={{$total_price}} />
                    </div>
                     <h4>Chọn phương thức thanh toán</h4>
                    <div class="form-group">
                        <h5>Cách 1: Chuyển hướng sang Cổng VNPAY chọn phương thức thanh toán</h5>
                       <input type="radio" Checked="True" id="bankCode" name="bankCode" value="">
                       <label for="bankCode">Cổng thanh toán VNPAYQR</label><br>
                       
                       <h5>Cách 2: Tách phương thức tại site của đơn vị kết nối</h5>
                       <input type="radio" id="bankCode" name="bankCode" value="VNPAYQR">
                       <label for="bankCode">Thanh toán bằng ứng dụng hỗ trợ VNPAYQR</label><br>
                       
                       <input type="radio" id="bankCode" name="bankCode" value="VNBANK">
                       <label for="bankCode">Thanh toán qua thẻ ATM/Tài khoản nội địa</label><br>
                       
                       <input type="radio" id="bankCode" name="bankCode" value="INTCARD">
                       <label for="bankCode">Thanh toán qua thẻ quốc tế</label><br>
                       
                    </div>
                    <div class="form-group">
                        <h5>Chọn ngôn ngữ giao diện thanh toán:</h5>
                         <input type="radio" id="language" Checked="True" name="language" value="vn">
                         <label for="language">Tiếng việt</label><br>
                         <input type="radio" id="language" name="language" value="en">
                         <label for="language">Tiếng anh</label><br>
                         
                    </div>
                    <button type="submit" class="btn btn-primary" href>Thanh toán</button>
                </form>
            </div>
        </div>  
    </body>
</html>
