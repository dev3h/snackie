 <script>
     $(document).ready(function() {
         function getPayment() {
             let total = 0;
             let payment = 0;
             let shipping = 20000;

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
             $(".span-total").text(total);
             $("#span-payment").text(payment);
         }

         function getTotalPrice() {

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

         $('.cart-checkbox').change(function() {
             const rowChecks = $('.cart-checkbox:checked');
             const numCheckbox = rowChecks.length;
             $('.delete-num-rows').text(numCheckbox);
         })
     });
 </script>
