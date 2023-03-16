<script>
    $(document).ready(function() {
        // $(".add-to-cart").click(function() {
        //     let id = $(this).val();
        //     $.ajax({
        //         url: '{{ route('customer.save_cart') }}',
        //         type: "GET",
        //         data: {
        //             id,
        //         },
        //         success: function(res) {
        //             const cartQuantity = $("#cart-quantity");
        //             if (Number(res.status) === 200) {
        //                 if (res.data != null) {
        //                     $.trim(cartQuantity.text(res.data));
        //                 }
        //                 Swal.fire("Thành công", res.message, "success");
        //             } else if (Number(res.status) === 401) {
        //                 location.href = res.redirect;
        //             } else {
        //                 toastr.options.escapeHtml = true;

        //                 Command: toastr["error"](res.message, "Lỗi");

        //                 toastr.options = {
        //                     closeButton: true,
        //                     debug: false,
        //                     newestOnTop: false,
        //                     progressBar: false,
        //                     positionClass: "toast-top-right",
        //                     preventDuplicates: false,
        //                     onclick: null,
        //                     showDuration: "300",
        //                     hideDuration: "1000",
        //                     timeOut: "5000",
        //                     extendedTimeOut: "1000",
        //                     showEasing: "swing",
        //                     hideEasing: "linear",
        //                     showMethod: "fadeIn",
        //                     hideMethod: "fadeOut",
        //                 };
        //             }
        //         },
        //     });
        // });
        $(".add-to-cart-form").submit(function(e) {
            e.preventDefault();
            let id = $(this).find(".add-to-cart").val();
            let quantity = $(this).find(".cart_quantity_input").val() ?? 1;

            $.ajax({
                url: '{{ route('customer.save_cart') }}',
                type: "GET",
                data: {
                    id,
                    quantity
                },
                success: function(res) {
                    const cartQuantity = $("#cart-quantity");
                    if (Number(res.status) === 200) {
                        if (res.data != null) {
                            $.trim(cartQuantity.text(res.data));
                        }
                        Swal.fire("Thành công", res.message, "success");
                    } else if (Number(res.status) === 401) {
                        location.href = res.redirect;
                    } else {
                        toastr.options.escapeHtml = true;

                        Command: toastr["error"](res.message, "Lỗi");

                        toastr.options = {
                            closeButton: true,
                            debug: false,
                            newestOnTop: false,
                            progressBar: false,
                            positionClass: "toast-top-right",
                            preventDuplicates: false,
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
                    }
                },
            });
        });

        $('.cart_quantity_input').on("input", function() {
            regex = /^\d+$/;
            value = $(this).val();
            if (!regex.test(value) || value == '') {
                $(this).val('');
            }
        })
    });
</script>
