@extends('layout.app')
@section('title','Simpanan Wajib')
@section('content')
<div class="page-header">
    <div class="page-title">
        <h3>Simpanan Wajib</h3>
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
            <li class="breadcrumb-item active" aria-current="page"><span>Simpanan Wajib</span></li>

        </ol>
    </nav>
</div>

{{-- <div class="col-lg-12 col-md-12 mt-3 layout-spacing">
    <div class="d-flex justify-content-start mb-3">
        <a href="#" class="btn btn-outline-success" data-toggle="modal" data-target="#exampleModal">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Import
        </a> --}}

        <div class="row" id="cancel-row">
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="table-responsive mb-4 mt-4">
                        <table id="user-table" class="table table-hover table-striped" style="width:100%">
                            <thead class="text-center">
                                <tr>
                                    <th rowspan="3" style="vertical-align: middle">Nama</th>
                                    <th colspan="24">Bulan</th>
                                    <th rowspan="3" style="vertical-align: middle">Sisa</th>
                                    <th rowspan="3" style="vertical-align: middle">Ket</th>
                                    <th rowspan="3" style="vertical-align: middle">Jumlah</th>
                                    <th rowspan="3" style="vertical-align: middle">Jumlah</th>
                                    <th rowspan="3" style="vertical-align: middle">Jumlah</th>
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
                                {{-- Isi table menggunakan ajax --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal --}}
    <div class="modal fade" id="user-modal" tabindex="-1" role="dialog" aria-labelledby="userModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="userModalTitle">
                        <span id="action-modal"></span>
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="user-form" data-id="" data-userId="">
                        @csrf
                        <div class="form-group">
                            <label for="paid_at">Tanggal Bayar<span class="text-danger">*</span></label>
                            <input type="text" name="paid_at" class="form-control" id="paid_at" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="payment_month">Bulan Ke-<span class="text-danger">*</span></label>
                            <input type="text" name="payment_month" class="form-control" id="payment_month" placeholder="" readonly>
                        </div>
                        <input type="hidden" name="payment_year" class="form-control" id="payment_year" placeholder="">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                    <button type="button" id="btn_form" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="import-modal" tabindex="-1" role="dialog" aria-labelledby="importModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="importModalTitle">
                        <span id="action-modal">Import Pembayaran</span>
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('payment.monthly.import') }}" id="import-form" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="year">Tahun Data Pembayaran<span class="text-danger">*</span></label>
                            <input type="number" name="year" value="{{ date('Y') }}" class="form-control" id="year" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label for="file">File Excel <span class="text-danger">*</span></label>
                            <input type="file" name="file" class="form-control" id="file">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    
        

    
@endsection

@push('script')
<script>
    

</script>

<script>


    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let table = $("#user-table").DataTable({
            processing: true,
            serverSide: true,
            scrollY: "50vh",
            scrollX: true,
           
            ajax: "{{ route('payment.monthly.ajax') }}",
            scrollCollapse: true,

            fixedColumns: true,
            fixedHeader: true,
            columnDefs: [{
                    targets: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24],
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
                    title: 'Total simpanan wajib ' + new Date().getFullYear(),
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
                    title: 'Total simpanan wajib ' + ((new Date().getFullYear()) - 1),
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
                    title: 'Total simpanan wajib ' + ((new Date().getFullYear()) - 2),
                    // orderable: false,
                    createdCell: function(td, cellData, rowData, row, col) {
                        $(td).addClass('text-center');
                    },
                    render: function(data, type, full, meta) {
                        return formatRupiah(String(data), 'Rp. ');
                    },
                },
                {
                    targets: 28,
                    title: 'Total simpanan wajib ' + ((new Date().getFullYear()) - 3),
                    // orderable: false,
                    createdCell: function(td, cellData, rowData, row, col) {
                        $(td).addClass('text-center');
                    },
                    render: function(data, type, full, meta) {
                        return formatRupiah(String(data), 'Rp. ');
                    },
                },
                {
                    targets: 29,
                    title: 'Total simpanan wajib Keseluruhan',
                    // orderable: false,
                    createdCell: function(td, cellData, rowData, row, col) {
                        $(td).addClass('text-center');
                    },
                    render: function(data, type, full, meta) {
                        return formatRupiah(String(data), 'Rp. ');
                    },
                },
            ],

            columns: [{
                    data: 'name'
                },

                // 1
                {
                    data: 'monthly_payment.0.paid_at'
                },
                {
                    data: 'monthly_payment.0.amount'
                },

                // 2
                {
                    data: 'monthly_payment.1.paid_at'
                },
                {
                    data: 'monthly_payment.1.amount'
                },

                // 3
                {
                    data: 'monthly_payment.2.paid_at'
                },
                {
                    data: 'monthly_payment.2.amount'
                },

                // 4
                {
                    data: 'monthly_payment.3.paid_at'
                },
                {
                    data: 'monthly_payment.3.amount'
                },

                // 5
                {
                    data: 'monthly_payment.4.paid_at'
                },
                {
                    data: 'monthly_payment.4.amount'
                },

                // 6
                {
                    data: 'monthly_payment.5.paid_at'
                },
                {
                    data: 'monthly_payment.5.amount'
                },

                // 7
                {
                    data: 'monthly_payment.6.paid_at'
                },
                {
                    data: 'monthly_payment.6.amount'
                },

                // 8
                {
                    data: 'monthly_payment.7.paid_at'
                },
                {
                    data: 'monthly_payment.7.amount'
                },

                // 9
                {
                    data: 'monthly_payment.8.paid_at'
                },
                {
                    data: 'monthly_payment.8.amount'
                },

                // 10
                {
                    data: 'monthly_payment.9.paid_at'
                },
                {
                    data: 'monthly_payment.9.amount'
                },

                // 11
                {
                    data: 'monthly_payment.10.paid_at'
                },
                {
                    data: 'monthly_payment.10.amount'
                },

                // 12
                {
                    data: 'monthly_payment.11.paid_at'
                },
                {
                    data: 'monthly_payment.11.amount'
                },

                {
                    data: 'monthly_total'
                },
                {
                    data: 'last_year_1'
                },
                {
                    data: 'last_year_2'
                },
                {
                    data: 'last_year_3'
                },
                {
                    data: 'total_all'
                },
            ],
            language: {
                searchPlaceholder: 'Cari...',
                sSearch: '',
                oPaginate: {
                    sPrevious: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                    sNext: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                },
            }

        });
    });
</script>
    
{{-- <script>
    $('#datatable').DataTable( {
        dom: '<"row"<"col-md-12"<"row"<"col-md-6"B><"col-md-6"f> > ><"col-md-12"rt> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
        buttons: {
            buttons: [
                { extend: 'copy', className: 'btn' },
                { extend: 'csv', className: 'btn' },
                { extend: 'excel', className: 'btn' },
                { extend: 'print', className: 'btn' }
            ]
        },
        "oLanguage": {
            "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
            "sInfo": "Showing page _PAGE_ of _PAGES_",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Search...",
           "sLengthMenu": "Results :  _MENU_",
        },
        "stripeClasses": [],
        "lengthMenu": [7, 10, 20, 50],
        "pageLength": 7 
    } );
</script> --}}

@endpush