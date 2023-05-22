@extends('admin_layout')
@section('admin_content')
    @push('datatable_css')
        <link rel="stylesheet" href="{{ asset('backend/css/datatables.min.css') }}">
    @endpush
    <div class="card">
        <h5 class="card-header">
            Liệt kê {{ $messageName }}
        </h5>
        <div class="card-body">
            <a href="{{route('admin.category_product.create')}}" class="btn btn-info mb-3">Thêm</a>
            <div class="table-responsive">
                @php
                    $message = session()->get('message');
                    if ($message) {
                        echo '<span class="text-alert">' . $message . '</span>';
                        session()->put('message', null);
                    }
                @endphp
                <table class="table table-centered mb-0" id="table-index">
                    <thead>
                        <tr>
                            <th>Tên danh mục</th>
                            <th>Hiển thị</th>
                            <th>Sửa</th>
                            <th>Xóa</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    @push('datatable_js')
        <script src="{{ asset('backend/js/datatables.min.js') }}"></script>
        <script>
            $(function() {
                // datatable
                var buttonCommon = {
                    exportOptions: {
                        columns: ':visible :not(.not-export)'
                    }
                };
                let table = $('#table-index').DataTable({
                    dom: 'Bfrtip',
                    select: true,
                    buttons: [
                        $.extend(true, {}, buttonCommon, {
                            extend: 'copyHtml5'
                        }),
                        $.extend(true, {}, buttonCommon, {
                            extend: 'excelHtml5'
                        }),
                        $.extend(true, {}, buttonCommon, {
                            extend: 'csvHtml5'
                        }),
                        $.extend(true, {}, buttonCommon, {
                            extend: 'pdfHtml5'
                        }),
                        $.extend(true, {}, buttonCommon, {
                            extend: 'print'
                        }),
                        'colvis'
                    ],
                    processing: true,
                    serverSide: true,
                    ajax: '{!! route('admin.category_product.api') !!}',
                    columnDefs: [{
                        className: 'not-export',
                        "targets": [1, 2]
                    }],
                    columns: [{
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'status',
                            name: 'status',
                            // render html
                            render: function(data, type, row, meta) {
                                
                                if (data.includes('inactive')) {
                                    return `<a href="${data}" class='btn btn-success' title="hiện"><span class='fa fa-eye'></span></a>`;
                                } else {
                                    return `<a href="${data}" class='btn btn-danger' title="ẩn"><span class='fa fa-eye-slash'></span></a>`;
                                }
                            },

                        },
                        {
                            data: 'edit',
                            target: 2,
                            orderable: false,
                            searchable: false,
                            render: function(data, type, row, meta) {
                                return `<a class="btn btn-primary" href="${data}">Edit</a>`;
                            },
                        },
                        // dùng được blade trong js

                        {
                            data: 'destroy',
                            target: 3,
                            orderable: false,
                            searchable: false,
                            render: function(data, type, row, meta) {
                                return `
                                        <form action="${data}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type='button' onclick="return confirm('Bạn có chắc muốn xóa {{ $messageName }} này không?')" class="btn-delete btn btn-danger">Delete</button>
                                        </form>
                                    `;
                            },
                        },
                    ]
                })

                // reload table when select2 change
                $('#select-name').change(function() {
                    table.column(0).search(this.value).draw();
                })

                $(document).on('click', '.btn-delete', function() {
                    let row = $(this).parents('tr');
                    let form = $(this).parents('form');
                    $.ajax({
                        type: "POST",
                        url: form.attr('action'),
                        data: form.serialize(),
                        dataType: "json",
                        success: function(response) {
                            console.log('success');
                            table.draw();
                        },
                        error: function(response) {
                            console.log('error');
                            // bắt lỗi khi middleware trả về
                            toastr.options.escapeHtml = true;

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
                            toastr["error"](response.responseJSON.message, "Lỗi");
                        }
                    }, );
                })
            });
        </script>
    @endpush
@endsection
