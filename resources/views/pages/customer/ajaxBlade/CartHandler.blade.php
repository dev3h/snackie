 <script>
     $(document).ready(function() {
         function getPayment() {
             let total = 0;
             let payment = 0;
             let shipping = 0;

             $(".span-sum").each(function() {
                 let sum = $(this).text();
                 sum = sum.replaceAll(".", "").trim();
                 total += parseInt(sum);
             });
             payment = total + shipping;

             total = total.toLocaleString("vi-VN", {
                 currency: "VND",
             });

             payment = payment.toLocaleString("vi-VN", {
                 currency: "VND",
             });
             $(".sub-total").text(total);
             $(".total-payment").text(payment);
         }

         $(".btn-update-quantity").click(function() {
             let btn = $(this);
             let id = btn.data("id");
             let type = parseInt(btn.data("type"));
             $.ajax({
                 url: "{{ route('customer.update_qty_cart') }}",
                 type: "get",
                 data: {
                     id,
                     type,
                 },
             }).done(function(res) {
                 const cartQuantity = $("#cart-quantity");
                 let parent_tr = btn.parents("tr");
                 let price = parent_tr.find(".span-price").text();

                 price = price.replace(".", "").trim();
                 let quantity = parent_tr.find(".span-quantity").val();
                 if (type == 1) {
                     quantity++;
                 } else {
                     quantity--;
                 }

                 if (quantity === 0) {
                     parent_tr.remove();
                 } else {
                     parent_tr.find(".span-quantity").val(quantity);
                     let sum = price * quantity;

                     sum = sum.toLocaleString("vi-VN", {
                         currency: "VND",
                     });

                     parent_tr.find(".span-sum").text(sum);
                 }
                 getPayment();
                 if (res.data != null) {
                     $.trim(cartQuantity.text(res.data));
                 }
             });
         });
         $(".btn-delete").click(function() {
             let btn = $(this);
             let id = btn.data("id");
             $.ajax({
                 url: "{{ route('customer.delete__item_cart') }}",
                 type: "get",
                 data: {
                     id,
                 },
             }).done(function(res) {
                 const cartQuantity = $("#cart-quantity");
                 btn.parents("tr").remove();
                 getPayment();
                 if (res.data != null) {
                     $.trim(cartQuantity.text(res.data));
                 }
             });
         });

         $('.cart_quantity_input').on("input", function(e) {
             regex = /^\d+$/;
             value = $(this).val();
             if (!regex.test(value) || value == '') {
                 $(this).val('');
             }
         })

         $('.btn-delete-by-nums-checkbox').click(function() {
             // get input checkbox checked

             const rowChecks = $('.cart-checkbox:checked');
             const numCheckbox = rowChecks.length;
             $('.delete-num-rows').text = numCheckbox;
             if (numCheckbox == 0) {
                 alert('Bạn chưa chọn sản phẩm nào');
                 return;
             }
             // loop to get value of checkbox checked
             let ids = [];
             rowChecks.each(function() {
                 ids.push($(this).val());
             });
             // send ajax
             $.ajax({
                 url: "{{ route('customer.delete__item_cart_checked') }}",
                 type: "get",
                 data: {
                     ids: ids,
                 },
             }).done(function(res) {
                 const cartQuantity = $("#cart-quantity");
                 rowChecks.each(function() {
                     $(this).parents("tr").remove();
                 });
                 $('.delete-num-rows').text(0);
                 getPayment();
                 if (res.data != null) {
                     $.trim(cartQuantity.text(res.data));
                 }
             });
         })

         $('.btn-delete-all-cart').click(function() {
             $.ajax({
                 url: "{{ route('customer.delete__all_cart') }}",
                 type: "get",
             }).done(function(res) {
                 const cartQuantity = $("#cart-quantity");
                 $('.cart-checkbox').each(function() {
                     $(this).parents("tr").remove();
                 });
                 $('.coupon-container').remove();
                 $('.delete-num-rows').text(0);
                 getPayment();
                 if (res.data != null) {
                     $.trim(cartQuantity.text(res.data));
                 }
             });
         })

         $('.cart-checkbox').change(function() {
             const rowChecks = $('.cart-checkbox:checked');
             const numCheckbox = rowChecks.length;
             $('.delete-num-rows').text(numCheckbox);
         })

         $('.coupon-form').submit(function(e) {
             e.preventDefault();
             let coupon = $(this).find('.coupon-product').val();
             let _token = $(this).find('input[name=_token]').val();
             if (coupon == '') {
                 alert('Bạn chưa nhập mã giảm giá');
                 return;
             }

             $.ajax({
                 url: "{{ route('customer.check_coupon') }}",
                 type: "post",
                 data: {
                     coupon,
                     _token
                 },
             }).done(function(res) {
                 if (res.status == 400) {
                     toastr.options.escapeHtml = true;

                     Command: toastr["error"](res.message, "Lỗi");

                     toastr.options = {
                         closeButton: true,
                         debug: false,
                         newestOnTop: false,
                         progressBar: false,
                         positionClass: "toast-top-right",
                         preventDuplicates: true,
                         onclick: null,
                         showDuration: "300",
                         hideDuration: "1000",
                         timeOut: "5000",
                         extendedTimeOut: "1000",
                         showEasing: "swing",
                         hideEasing: "linear",
                         showMethod: "fadeIn",
                         hideMethod: "fadeOut",
                     };
                 } else {
                     Swal.fire("Thành công", res.message, "success");
                 }

                 //  $(".span-sum").each(function() {
                 //      let sum = $(this).text();
                 //      sum = sum.replaceAll(".", "").trim();
                 //      total += parseInt(sum);
                 //  });
                 //  if (coupon_type == 1) {
                 //      payment = total + shipping - coupon_value;
                 //  } else {
                 //      payment = total + shipping - (total * coupon_value / 100);
                 //  }
                 //  if (payment < 0) {
                 //      payment = 0;
                 //  }
                 //  total = total.toLocaleString("vi-VN", {
                 //      currency: "VND",
                 //  });

                 //  payment = payment.toLocaleString("vi-VN", {
                 //      currency: "VND",
                 //  });
                 //  $(".span-total").text(total);
                 //  $("#span-payment").text(payment);
             })

         })

         $('.coupon-product').on('input', function(e) {
             let coupon = $(this).val();
             if (coupon == '') {
                 $('.btn-delete-coupon').hide();
             } else {
                 $('.btn-delete-coupon').show();
             }
         })

         $('.btn-delete-coupon').click(function() {
             $('.coupon-product').val('');
         })

     });
 </script>
