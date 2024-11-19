@extends('layout.app')

@section('title','Manage Penarikan Dana')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h3>Manage Penarikan Dana</h3>
    </div>
    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg></a></li>
        </ol>
    </nav>
</div>
<div class="col-lg-12 col-md-12 mt-3 layout-spacing">
    <div class="d-flex justify-content-start mb-3">
        <a href="#" class="btn btn-outline-primary" data-toggle="modal" data-target="#exampleModal">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Buat Penarikan
        </a>
</div>
    
<div class="row" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <div class="table-responsive mb-4 mt-4">
                <table id="user-table" class="table table-hover table-striped" style="width:100%">
                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jenis Penarikan</th>
                            <th>Banyak</th>
                            <th>Nilai Penarikan</th>
                            <th>Catatan</th>
                            <th>Status</th>
                            <th>Tanggal Penarikan</th>
                            <th class="drop">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Isi tabel akan dimuat menggunakan AJAX -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
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
        ajax: "{{ route('admin.withdraw.ajax') }}",
        scrollCollapse: true,
        fixedColumns: true,
        fixedHeader: true,
        dom: `<"row" <"col-md-2" l> <"col-md-2" B>  <"col-md-8" f>> rt`,
        buttons: {
            buttons: [{
                text: '+ Buat Penarikan',
                className: 'btn-primary',
                action: function(e, dt, node, config) {
                    $('#action-modal').text('Tambah ');
                    $('#user-modal').modal('show');
                    $("#user-form")[0].reset();
                    $('.after').prop('disabled', true);
                    $("#user-form").attr('data-id', '');
                },
            }],
            dom: {
                button: {
                    className: 'btn'
                },
                buttonLiner: {
                    tag: null
                }
            }
        },
        columnDefs: [{
                targets: 0,
                createdCell: function(td, cellData, rowData, row, col) {
                    $(td).text(row + 1);
                    $(td).addClass('text-center');
                }
            },
            {
                targets: -3,
                render: function(data, type, full, meta) {
                    let state = ``;
                    if (data) state = `<a class="btn btn-success btn-sm">Selesai</a>`;
                    else state = `<a class="btn btn-warning btn-sm">Pending</a>`;
                    return state;
                }
            },
            {
                targets: -1,
                title: 'Aksi',
                orderable: false,
                createdCell: function(td, cellData, rowData, row, col) {
                    $(td).addClass('tmbl-usr text-center');
                },
                render: function(data, type, full, meta) {
                    return `
                        <a href="javascript:void(0);" data-id="${full.id}" class="btn-edit btn btn-md btn-outline-primary btn-icon" title="Edit details">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a href="javascript:void(0);" data-id="${full.id}" class="btn-delete btn btn-md btn-outline-danger btn-icon" title="Delete">
                            <i class="fa fa-trash"></i>
                        </a>`;
                }
            }
        ],
        columns: [{
                data: 'id',
                title: 'ID'
            },
            {
                data: 'user.name',
                title: 'Nama User'
            },
            {
                data: 'name',
                title: 'Nama'
            },
            {
                data: 'value',
                title: 'Nilai'
            },
            {
                data: 'amount',
                title: 'Jumlah'
            },
            {
                data: 'description',
                title: 'Deskripsi'
            },
            {
                data: 'status',
                title: 'Status'
            },
            {
                data: 'withdrawn_at',
                title: 'Tanggal Penarikan'
            },
            {
                data: 'id',
                title: 'Aksi'
            }
        ],
        language: {
            searchPlaceholder: 'Cari...',
            sSearch: '',
            oPaginate: {
                sPrevious: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                sNext: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
            }
        }
    });
});

    </script>
@endpush