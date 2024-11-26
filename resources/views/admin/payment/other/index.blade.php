@extends('layout.app')
@section('title', 'Simpanan Sukarela')
@section('content')
    <div class="page-header">
        <div class="page-title">
            <h3>Simpanan Hari Raya</h3>
        </div>
        <nav class="breadcrumb-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg></a></li>
                <li class="breadcrumb-item " aria-current="page"><span>Pembayaran</span></li>
                <li class="breadcrumb-item active" aria-current="page"><span>Simpanan Hari Raya</span></li>

            </ol>
        </nav>
    </div>

    <div class="row" id="cancel-row">
        <div class="col-12 layout-spacing">
            <div class="widget-content widget-content-area br-6">
                <div class="row">
                    <div class="col-6">
                        <!-- Konten di sini -->
                    </div>
                </div> <!-- Penutup div.row -->
                <div class="table-responsive" style="overflow-x: auto; white-space: nowrap;">
                    <table id="user-table" width="100%" class="table table-bordered table-striped table-hover">
                        <thead class="text-center">
                            <tr>
                                <th rowspan="3" style="vertical-align: middle">Nama</th>
                                {{-- <th rowspan="3" width="10%" style="vertical-align: middle">Nomor Anggota</th> --}}
                                <th colspan="24">Bulan</th>
                                <th rowspan="3" style="vertical-align: middle">Total now</th>
                                <th rowspan="3" style="vertical-align: middle">Total last</th>
                                <th rowspan="3" style="vertical-align: middle">Total All</th>
                                <th rowspan="3" style="vertical-align: middle">Aksi</th>
                            </tr>
                            <tr>
                                <th colspan="2">1</th>
                                <th colspan="2">2</th>
                                <th colspan="2">3</th>
                                <th colspan="2">4</th>
                                <th colspan="2">5</th>
                                <th colspan="2">6</th>
                                <th colspan="2">7</th>
                                <th colspan="2">8</th>
                                <th colspan="2">9</th>
                                <th colspan="2">10</th>
                                <th colspan="2">11</th>
                                <th colspan="2">12</th>
                            </tr>
                            <tr>
                                <th>TGL</th>
                                <th>JML</th>

                                <th>TGL</th>
                                <th>JML</th>

                                <th>TGL</th>
                                <th>JML</th>

                                <th>TGL</th>
                                <th>JML</th>

                                <th>TGL</th>
                                <th>JML</th>

                                <th>TGL</th>
                                <th>JML</th>

                                <th>TGL</th>
                                <th>JML</th>

                                <th>TGL</th>
                                <th>JML</th>

                                <th>TGL</th>
                                <th>JML</th>

                                <th>TGL</th>
                                <th>JML</th>

                                <th>TGL</th>
                                <th>JML</th>

                                <th>TGL</th>
                                <th>JML</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div> <!-- Penutup div.widget-content -->
        </div> <!-- Penutup div.col-12 -->
    </div> <!-- Penutup div.row -->
    <!-- Modal -->
    <div class="modal fade" id="user-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle"><span id="action-modal"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="user-form" data-id="" data-userId="">
                        @csrf
                        <div class="form-group">
                            <label>Tanggal Bayar<span class="text-danger">*</span> </label>
                            <input type="text" name="paid_at" class="form-control" id="paid_at" placeholder="">
                        </div>
                        <div class="form-group">
                            <label>Bulan Ke-<span class="text-danger">*</span> </label>
                            <input type="text" name="payment_month" class="form-control" id="payment_month"
                                placeholder="" readonly>
                        </div>
                        {{-- <div class="form-group"> --}}
                        {{-- <label>Tahun yang dibayar<span class="text-danger">*</span> </label> --}}
                        <input type="text" name="payment_year" class="form-control" id="payment_year" placeholder="">
                        {{-- </div> --}}
                        <div class="form-group">
                            <label>Jumlah <span class="text-danger">*</span> </label>
                            <input type="text" name="amount" class="form-control" id="amount" placeholder="">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i>
                        Close</button>
                    <button type="button" id="btn_form" class="btn btn-primary"><i class="fa fa-save"></i>
                        Save</button>
                </div>
            </div>
        </div>
    </div>

    @include('admin.payment.other.exportInvoice')


@endsection

@push('css')
    <link href="{{ asset('demo1/assets/css/scrollspyNav.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('demo1/plugins/file-upload/file-upload-with-preview.min.css') }}" rel="stylesheet"
        type="text/css">
    <link rel="stylesheet" href="{{ asset('demo1/plugins/table/datatable/datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('demo1/plugins/table/datatable/dt-global_style.css') }}">
    <style>
        .paginate-button {
            cursor: pointer;
            display: inline-flex;
            align-items: center;
        }

        .paginate-button svg {
            margin-right: 5px;
        }
    </style>
    <link href="{{ asset('demo1/assets/css/scrollspyNav.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('demo1/assets/css/components/custom-modal.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{ asset('demo1/plugins/select2/select2.min.css') }}">
@endpush

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.2.1/exceljs.min.js"></script>
    <script src="{{ asset('demo1/assets/js/scrollspyNav.js') }}"></script>
    <script src="{{ asset('demo1/plugins/file-upload/file-upload-with-preview.min.js') }}"></script>
    <script src="{{ asset('demo1/plugins/table/datatable/datatables.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.13/jspdf.plugin.autotable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="{{ asset('demo1/assets/js/scrollspyNav.js') }}"></script>
    <script src="{{ asset('demo1/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('demo1/plugins/select2/custom-select2.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#user-modal').on('shown.bs.modal', function(event) {
                $('#payment_month').daterangepicker({
                    singleDatePicker: true,
                    locale: {
                        format: 'MM',
                        autoUpdateInput: true,
                    }
                });

                $('#paid_at').daterangepicker({
                    singleDatePicker: true,
                    locale: {
                        format: 'YYYY-MM-DD',
                        autoUpdateInput: true,
                    }
                });

                var rupiah = $('#amount');
                rupiah.on('keyup', function(e) {
                    rupiah.val(formatRupiah(rupiah.val(), 'Rp. '));
                });
            });

            var table = $("#user-table").DataTable({
                paging: true,
                processing: true,
                serverSide: true,
                scrollY: "50vh",
                scrollX: true,
                ajax: "{{ route('admin.payment.other.ajax') }}",
                scrollCollapse: true,

                fixedColumns: true,
                fixedHeader: true,
                // responsive: true,
                // lengthChange: false,
                // autoWidth: true,
                columns: [{
                        data: 'name'
                    },

                    // 1
                    {
                        data: 'other_payment.0.paid_at'
                    },
                    {
                        data: 'other_payment.0.amount'
                    },

                    // 2
                    {
                        data: 'other_payment.1.paid_at'
                    },
                    {
                        data: 'other_payment.1.amount'
                    },

                    // 3
                    {
                        data: 'other_payment.2.paid_at'
                    },
                    {
                        data: 'other_payment.2.amount'
                    },

                    // 4
                    {
                        data: 'other_payment.3.paid_at'
                    },
                    {
                        data: 'other_payment.3.amount'
                    },

                    // 5
                    {
                        data: 'other_payment.4.paid_at'
                    },
                    {
                        data: 'other_payment.4.amount'
                    },

                    // 6
                    {
                        data: 'other_payment.5.paid_at'
                    },
                    {
                        data: 'other_payment.5.amount'
                    },

                    // 7
                    {
                        data: 'other_payment.6.paid_at'
                    },
                    {
                        data: 'other_payment.6.amount'
                    },

                    // 8
                    {
                        data: 'other_payment.7.paid_at'
                    },
                    {
                        data: 'other_payment.7.amount'
                    },

                    // 9
                    {
                        data: 'other_payment.8.paid_at'
                    },
                    {
                        data: 'other_payment.8.amount'
                    },

                    // 10
                    {
                        data: 'other_payment.9.paid_at'
                    },
                    {
                        data: 'other_payment.9.amount'
                    },

                    // 11
                    {
                        data: 'other_payment.10.paid_at'
                    },
                    {
                        data: 'other_payment.10.amount'
                    },

                    // 12
                    {
                        data: 'other_payment.11.paid_at'
                    },
                    {
                        data: 'other_payment.11.amount'
                    },

                    {
                        data: 'other_total'
                    },
                    {
                        data: 'last_year_1'
                    },
                    {
                        data: 'total_all'
                    },
                    {
                        data: null, // Kolom Aksi tidak memerlukan data, karena kita render tombol secara manual
                        orderable: false, // Tidak bisa diurutkan
                        className: 'text-center', // Pusatkan kolom aksi
                    },
                ],
                columnDefs: [{
                        targets: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20,
                            21, 22, 23, 24
                        ],
                        "defaultContent": "",
                        orderable: false,
                        createdCell: function(td, cellData, rowData, row, col) {
                            if (cellData) {
                                $(td).css('writing-mode', 'sideways-lr');
                                $(td).css('vertical-align', 'bottom');
                            } else {
                                $(td).css('vertical-align', 'middle');
                            }
                            $(td).addClass('text-center');
                        },
                    },
                    {
                        targets: [1, 3, 5, 7, 9, 11, 13, 15, 17, 19, 21, 23],
                        "defaultContent": "",
                        orderable: false,
                        render: function(data, type, full, meta) {
                            col = 0;
                            array = [1, 3, 5, 7, 9, 11, 13, 15, 17, 19, 21, 23]
                            col = array.indexOf(meta.col) + 1;

                            if (!data) {
                                return `<button type="button" class="btn btn-outline-primary btn-add" data-id="${full.id}" data-month="${col}">+</button>`;
                            }
                            // return `<button type="button" class="btn btn-danger">-</button>`+data;
                            return data
                        },
                    },
                    {
                        targets: [2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22, 24],
                        "defaultContent": "",
                        orderable: false,
                        render: function(data, type, full, meta) {
                            if (!data || data === 0) {
                                return `-`;
                            }
                            // return `<button type="button" class="btn btn-danger">-</button>`+data;
                            return formatRupiah(String(data), 'Rp. ');
                        },
                    },
                    {
                        targets: 25,
                        title: 'Total simpanan Sukarela ' + new Date().getFullYear(),
                        // orderable: false,
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).addClass('text-center');
                        },
                        render: function(data, type, full, meta) {
                            return formatRupiah(String(data), 'Rp. ');
                        },
                    },
                    {
                        targets: 26,
                        title: 'Total simpanan Sukarela ' + ((new Date().getFullYear()) - 1),
                        // orderable: false,
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).addClass('text-center');
                        },
                        render: function(data, type, full, meta) {
                            return formatRupiah(String(data), 'Rp. ');
                        },
                    },
                    {
                        targets: 27,
                        title: 'Total simpanan Sukarela Keseluruhan',
                        // orderable: false,
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).addClass('text-center');
                        },
                        render: function(data, type, full, meta) {
                            return formatRupiah(String(data), 'Rp. ');
                        },
                    },
                    {
                        targets: 28, // Indeks kolom "Aksi" yang baru
                        title: 'Aksi',
                        orderable: false, // Tidak bisa diurutkan
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).addClass('text-center'); // Pusatkan konten dalam kolom
                        },
                        render: function(data, type, full, meta) {
                            // Menghasilkan tombol dengan ikon cetak
                            return `
            <button type="button" class="btn btn-sm btn-outline-primary btn-print" data-id="${full.id}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
                     viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                     stroke-width="2" stroke-linecap="round" 
                     stroke-linejoin="round" class="feather feather-printer">
                     <polyline points="6 9 6 2 18 2 18 9"></polyline>
                     <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                     <rect x="6" y="14" width="12" height="8"></rect>
                </svg>
            </button>
        `;
                        }
                    },

                ],
                oLanguage: {
                    oPaginate: {
                        sPrevious: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                        sNext: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                    },
                    sInfo: "Showing page _PAGE_ of _PAGES_",
                    sSearch: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                    sSearchPlaceholder: "Search...",
                    sLengthMenu: "Results :  _MENU_"
                },
                stripeClasses: [],
                lengthMenu: [5, 10, 20, 50],
                pageLength: 5
            });

            $('#user-table').on('click', '.btn-add', function() {
                var id = $(this).attr("data-id");
                $('#user-modal').modal('show');
                $("#user-modal #action-modal").text('Angsuran baru');
                $("#user-form")[0].reset();
                $('#payment_month').val($(this).attr("data-month"));
                $('#payment_year').val(new Date().getFullYear());
                $("#user-form").attr('data-userId', id);
                $('#user-modal').on('shown.bs.modal', function(event) {
                    KTApp.unblock('#user-modal .modal-content');
                });
            });

            $(document).on('click', '.btn-print', function() {
                // Ambil data-id dari tombol yang ditekan
                const dataId = $(this).data('id');

                // Tampilkan modal
                $('#modal-invoice').modal('show');

                // Ambil data dari backend untuk mengisi select
                $.ajax({
                    url: `/admin/payment/other/data_tanggal/${dataId}`, // Endpoint untuk mengambil data pembayaran
                    type: 'GET',
                    success: function(data) {
                        const select = $('#payment-tanggal');
                        select.empty(); // Hapus opsi sebelumnya

                        // Tambahkan opsi baru berdasarkan properti "paid_at" dari data
                        if (Array.isArray(data) && data.length > 0) {
                            // Ambil user_id dari elemen pertama dalam array
                            const userId = data[0].user_id;

                            // Tambahkan opsi berdasarkan properti paid_at
                            data.forEach(payment => {
                                if (payment.paid_at) {
                                    select.append(
                                        `<option value="${payment.payment_month}">Bulan ke-${payment.payment_month}</option>`
                                    );
                                }
                            });

                            // Tambahkan input hidden untuk user_id setelah select
                            select.after(
                                `<input type="hidden" name="user_id" value="${userId}">`
                            );
                        } else {
                            alert('Data yang diterima tidak valid.');
                        }


                        // Set opsi default
                        select.prepend(
                            '<option value="" disabled selected>Pilih Pembayaran</option>'
                        );
                    },
                    error: function() {
                        alert('Gagal mengambil data pembayaran.');
                    }
                });
            });



            $('#user-modal').on('click', '#btn_form', function() {
                let data = new FormData($('#user-form')[0])
                let id = $('#user-form').attr("data-id") ?? '';
                let user_id = $('#user-form').attr("data-userId") ?? '';

                if (id != '') data.append("id", id);
                if (user_id != '') data.append("user_id", user_id);

                $.ajax({
                    url: "{{ route('admin.payment.other.store') }}",
                    type: 'POST',
                    data: data,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#btn_form').attr('disabled', 'disabled')
                        KTApp.block('#user-modal .modal-content', {
                            overlayColor: '#000000',
                            message: 'Please wait...',
                        });
                    },
                    success: function(data) {
                        table.ajax.reload();
                        KTApp.unblock('#user-modal .modal-content');
                        $("#user-modal").modal('hide');
                        $('#btn_form').removeAttr('disabled');
                        swal.fire({
                            text: data.message,
                            icon: data.code == 600 ? "warning" : "success"
                        });
                    },
                    error: function(res, exception) {
                        KTApp.unblock('#user-modal .modal-content');
                        $('#btn_form').removeAttr('disabled');
                        if (res.responseJSON.code) {
                            swal.fire({
                                text: res.responseJSON.error,
                                icon: "warning"
                            });
                        } else {
                            swal.fire({
                                text: "Something Wrong, Please check your connection and try again!",
                                icon: "error"
                            });
                        }
                    }
                });
            });

        });
    </script>
@endpush
