@extends('layout.app')
@section('title', 'Pembayaran Pokok')
@section('content')
    <div class="page-header">
        <div class="page-title">
            <h3>Simpanan Pokok</h3>
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
                <li class="breadcrumb-item active" aria-current="page"><span>Simpanan Pokok</span></li>

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
                                <th colspan="14">Angsuran</th>
                                <th rowspan="3" style="vertical-align: middle">Sisa</th>
                                <th rowspan="3" style="vertical-align: middle">Ket</th>
                                <th rowspan="3" style="vertical-align: middle">Jumlah</th>
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

                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div> <!-- Penutup div.widget-content -->
        </div> <!-- Penutup div.col-12 -->
    </div> <!-- Penutup div.row -->

    @include('admin.payment.main.main_payment_modal')
    @include('admin.payment.main.exportInvoice')

@endsection

@push('css')
    <link href="{{ asset('demo1/assets/css/scrollspyNav.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('demo1/plugins/file-upload/file-upload-with-preview.min.css') }}" rel="stylesheet" type="text/css">
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

@push('script')
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
    <script src="https://cdn.jsdelivr.net/npm/html2pdf.js"></script>

    <script>
        $(document).ready(function() {
            var ss = $(".basic").select2({
                tags: true,
            });

            var table = $("#user-table").DataTable({
                paging: true,
                processing: true,
                serverSide: true,
                scrollY: "50vh",
                scrollX: true,
                autoWidth: false,
                ajax: "{{ route('admin.payment.main.ajax') }}",
                columnDefs: [{
                        targets: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14],
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
                        targets: [1, 3, 5, 7, 9, 11, 13],
                        "defaultContent": "",
                        render: function(data, type, full, meta) {
                            if (!data && full.main_payment_status) {
                                return '-';
                            }
                            if (!data) {
                                return `<button type="button" class="btn btn-outline-primary btn-add" data-id="${full.id}">+</button>`;
                            }
                            return data;
                        },
                    },
                    {
                        targets: [2, 4, 6, 8, 10, 12, 14],
                        "defaultContent": "",
                        render: function(data, type, full, meta) {
                            if (!data) {
                                return `-`;
                            }
                            return formatRupiah(String(data), 'Rp. ');
                        },
                    },
                    {
                        targets: 15,
                        render: function(data, type, full, meta) {
                            let sum = 0;
                            let total = 0;
                            data.forEach(function(item) {
                                sum += item.amount;
                                total = item.config_payment.paid_off_amount;
                            });
                            return formatRupiah(String(total - sum), 'Rp. ');
                        },
                    },
                    {
                        targets: 16,
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).addClass('text-center');
                        },
                        render: function(data, type, full, meta) {
                            let sum = 0;
                            let total = 0;
                            data.forEach(function(item) {
                                sum += item.amount;
                                total = item.config_payment.paid_off_amount;
                            });
                            const sisa = sum - total;
                            return sisa >= 0 && sum > 0 ?
                                '<a class="btn btn-outline-success btn-sm">Lunas</a>' :
                                '<a class="btn btn-outline-warning btn-sm">Belum lunas</a>';
                        },
                    },
                    {
                        targets: 17,
                        render: function(data, type, full, meta) {
                            let sum = 0;
                            data.forEach(function(item) {
                                sum += item.amount;
                            });
                            return formatRupiah(String(sum), 'Rp. ');
                        },
                    },
                    // Tambahan kolom "Aksi"
                    {
                        targets: 18,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, full, meta) {
                            return `
                        <button type="button" class="btn btn-outline-primary btn-sm btn-view" data-id="${full.id}" id="btn-view">
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
                        },
                    },
                ],
                columns: [{
                        data: 'name'
                    },
                    {
                        data: 'main_payment.0.paid_at'
                    },
                    {
                        data: 'main_payment.0.amount'
                    },
                    {
                        data: 'main_payment.1.paid_at'
                    },
                    {
                        data: 'main_payment.1.amount'
                    },
                    {
                        data: 'main_payment.2.paid_at'
                    },
                    {
                        data: 'main_payment.2.amount'
                    },
                    {
                        data: 'main_payment.3.paid_at'
                    },
                    {
                        data: 'main_payment.3.amount'
                    },
                    {
                        data: 'main_payment.4.paid_at'
                    },
                    {
                        data: 'main_payment.4.amount'
                    },
                    {
                        data: 'main_payment.5.paid_at'
                    },
                    {
                        data: 'main_payment.5.amount'
                    },
                    {
                        data: 'main_payment.6.paid_at'
                    },
                    {
                        data: 'main_payment.6.amount'
                    },
                    {
                        data: 'main_payment'
                    },
                    {
                        data: 'main_payment'
                    },
                    {
                        data: 'main_payment'
                    },
                    {
                        data: null
                    }, // Kolom "Aksi"
                ],
                oLanguage: {
                    oPaginate: {
                        sPrevious: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                        sNext: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>',
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

            $(document).on('click', '.btn-view', function() {
                // Ambil data-id dari tombol yang ditekan
                const dataId = $(this).data('id');

                // Tampilkan modal
                $('#modal-invoice').modal('show');

                // Ambil data dari backend untuk mengisi select
                $.ajax({
                    url: `/admin/payment/main/data_tanggal/${dataId}`, // Endpoint untuk mengambil data pembayaran
                    type: 'GET',
                    success: function(data) {
                        const select = $('#payment-tanggal');
                        select.empty(); // Hapus opsi sebelumnya

                        // Tambahkan opsi baru berdasarkan properti "paid_at" dari data
                        if (Array.isArray(data)) {
                            let i = 1;
                            data.forEach(payment => {
                                select.append(
                                    `<option value="${payment.paid_at}">Bulan ke-${i}</option>`
                                );
                                i++;
                            });
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












            $('#user-modal').on('shown.bs.modal', function(event) {
                $('#paid_at').daterangepicker({
                    singleDatePicker: true,
                    locale: {
                        format: 'YYYY-MM-DD',
                        autoUpdateInput: false,
                    }
                })
                var rupiah = $('#amount');
                rupiah.on('keyup', function(e) {
                    rupiah.val(formatRupiah(rupiah.val(), 'Rp. '));
                });
            });



            $('#user-table').on('click', '.btn-add', function() {
                var id = $(this).attr("data-id");
                $('#user-modal').modal('show');
                $("#user-modal #action-modal").text('Angsuran baru');
                $("#user-form")[0].reset();
                $("#user-form").attr('data-userId', id);
                $('#user-modal').on('shown.bs.modal', function(event) {
                    KTApp.unblock('#user-modal .modal-content');
                });
            });



            $('#user-modal').on('click', '#btn_form', function() {
                let data = new FormData($('#user-form')[0])
                let id = $('#user-form').attr("data-id") ?? '';
                let user_id = $('#user-form').attr("data-userId") ?? '';

                if (id != '') data.append("id", id);
                if (user_id != '') data.append("user_id", user_id);

                $.ajax({
                    url: "{{ route('admin.payment.main.store') }}",
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
