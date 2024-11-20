@extends('layout.app')
@section('title', 'Simpanan Sukarela')
@section('content')
    <div class="page-header">
        <div class="page-title">
            <h3>Simpanan Sukarela</h3>
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
                <li class="breadcrumb-item active" aria-current="page"><span>Pimpanan Sukarela</span></li>

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
        // Fungsi formatRupiah
        function formatRupiah(angka, prefix) {
            let number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? prefix + rupiah : '');
        }

        var table = $("#user-table").DataTable({
            paging: true,
            processing: true,
            serverSide: true,
            scrollY: "50vh",
            scrollX: true,
            ajax: "{{ route('admin.payment.other.ajax') }}",
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
            ],
            columnDefs: [{
                    targets: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23,
                        24
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
                            return `<button type="button" class="btn btn-primary btn-add" data-id="${full.id}" data-month="${col}">+</button>`;
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

        $(document).ready(function() {
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
        });
    </script>
@endpush
