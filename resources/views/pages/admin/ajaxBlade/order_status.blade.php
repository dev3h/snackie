<script>
    $(document).ready(function() {
        $(".order-status-select").submit(function(e) {
            e.preventDefault();
            const form = $(this);
            const data = form.serialize();

            $.ajax({
                url: '{{ route('customer.save_cart') }}',
                type: "PUT",
                data:data,
                success: function(res) {
                    if (Number(res.status) === 200) {
                        Swal.fire("Thành công", res.message, "success");
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
</script>
