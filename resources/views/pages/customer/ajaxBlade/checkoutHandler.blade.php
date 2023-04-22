 <script>
     $(document).ready(function() {
        // checkbox class payment method checked
        $('.payment-method').click(function() {
            value = $(this).val();
            if(value == 0) {
                $('.list-payment-online').removeClass('d-none');
            } else {
                $('.list-payment-online').addClass('d-none');
  
                $('.list-payment-online').find('input').prop('checked', false);
            }
        });
        

     });
 </script>
