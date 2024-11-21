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
        <a href="#" class="btn btn-outline-primary" data-toggle="modal" data-target="#user-modal">
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

<!-- Modal -->
<div class="modal fade" id="user-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><span id="action-modal"></span> Permintaan Penarikan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="user-form" data-id="">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label>Dompet <span id="wallet-type"></span> :</label>
                        </div>
                        <div class="col-md-6">
                            <div class="float-right">
                                <span id="wallet-amount"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-1">
                            <div class="form-group">
                                <label>Anggota<span class="text-danger">*</span></label>
                                <select id="user_id" name="user_id" class="form-control form-control-border">
                                    <option selected disabled value="">-- Pilih Member --</option>
                                    @foreach ($user as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Jenis Penarikan <span class="text-danger">*</span> </label>
                                <select name="type" id="type" class="form-control form-control-border after" disabled required>
                                    <option selected disabled value="">-- Pilih Jenis Penarikan --</option>
                                    <option value="all">Penarikan Keseluruhan Tabungan</option>
                                    {{-- <option value="shu-cash">Penarikan Dana SHU ke Cash</option> --}}
                                    <option value="other-cash">Penarikan Keseluruhan Tabungan Hari Raya</option>
                                    {{-- <option value="shu-monthly">Pindahkan Dana SHU Ke Tabungan Wajib</option> --}}
                                    {{-- <option value="shu-other">Pindahkan Dana SHU Ke Tabungan Sukarela</option> --}}
                                    {{-- <option value="other-monthly">Pindahkan Dana Sukarela Ke Tabungan Wajib</option> --}}
                                </select>
                            </div>
                            <div class="form-group d-none" id="form-value">
                                <label>Banyaknya <span class="text-danger">*</span> </label>
                                <input type="number" id="value" name="value" class="form-control form-control-border after" placeholder="" disabled>
                            </div>
                            <div class="form-group d-none" id="amount-div">
                                <label>Nilai Penarikan <span class="text-danger">*</span> </label>
                                <input type="text" id="amount" name="amount" class="form-control form-control-border after" placeholder="" disabled>
                            </div>
                            <div class="form-group">
                                <label>Catatan </label>
                                <input type="text" name="note" class="form-control form-control-border after" placeholder="" disabled>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer ">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                <button type="button" id="btn_form" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')

<script>
    $(document).ready(function() {
    var config_payment = ``;

    getConfig();

    // Fetch configuration
    function getConfig() {
        let url = `{{ route('admin.metadata.get.data') }}`;
        $.get(url, function(response) {
            config_payment = +response.paid_off_amount;
        });
    }
    
    var wallet = {
        main: 0,
        monthly: 0,
        other: 0,
        shu: 0,
        total: 0,
    };

    var type = ``;

        // Format Rupiah
        var rupiah = $('#amount');
    rupiah.on('keyup', function(e) {
        rupiah.val(formatRupiah(rupiah.val(), 'Rp. '));
    });


    // Handle User Selection
    $(document).on('change', '#user_id', function() {
        let id = $(this).val();
        let url = `{{ route('admin.withdraw.info', ':id') }}`.replace(':id', id);

        $.ajax({
            url: url,
            type: 'GET',
            beforeSend: function() {
                Notiflix.Block.circle('#user-modal .modal-content', 'Loading...');
            },
            success: function(response) {
                wallet.main = response.wallet.main;
                wallet.monthly = response.wallet.monthly;
                wallet.other = response.wallet.other;
                wallet.shu = response.wallet.shu;
                wallet.total = (+response.wallet.main + +response.wallet.monthly + +response.wallet.other + +response.wallet.shu).toString();
                Notiflix.Block.remove('#user-modal .modal-content');
            },
            error: function() {
                Notiflix.Block.remove('#user-modal .modal-content');
                $('#user-modal').modal('hide');
                Notiflix.Report.failure('Error', 'Terjadi kesalahan, mohon cek kembali!', 'Tutup');
            }
        });

        $('.after').prop('disabled', false);
    });

    // Handle Type Selection
    $(document).on('change', '#type', function() {
        type = $(this).val();

        if (type == 'shu-monthly' || type == 'other-monthly') {
            $('#form-value').removeClass('d-none');
            $('#amount-div').addClass('d-none');
        } else {
            if (type == 'shu-other') $('#amount').val(formatRupiah(wallet.shu, 'Rp. '));
            else if (type == 'shu-cash') $('#amount').val(formatRupiah(wallet.shu, 'Rp. '));
            // else if (type == 'other-cash') $('#amount').val(formatRupiah(wallet.other, 'Rp. ')); 
            else $('#amount').val(formatRupiah('0', 'Rp. '));

            if (type == 'shu-other' || type == 'shu-cash' ) $('#amount-div').removeClass('d-none');
            else $('#amount-div').addClass('d-none');

            $('#form-value').addClass('d-none');
            $('#value').val('');
        }

        // Update Wallet Information (bener)
        if (type == 'all') {
            $('#wallet-type').html('Keseluruhan');
            $('#wallet-amount').html(formatRupiah(wallet.total, 'Rp. '));
        } else if (type == 'other-monthly' || type == 'other-cash') {
            $('#wallet-type').html('Hari Raya');
            $('#wallet-amount').html(formatRupiah(wallet.other, 'Rp. '));
        }
    });

    // Validate Input Value
    $(document).on('change input', '#value', function() {
        let val = $(this).val();

        if (type == 'shu-monthly' && (val * config_payment) > +wallet.shu) {
            alert('Dompet SHU tidak mencukupi!');
            $(this).val('');
        } else if (type == 'other-monthly' && (val * config_payment) > +wallet.other) {
            alert('Dompet Sukarela tidak mencukupi!');
            $(this).val('');
        }
    });

    // Submit Form
    $('#user-modal').on('click', '#btn_form', function() {
        let data = new FormData($('#user-form')[0]);
        let id = $('#user-form').attr("data-id") || '';
        if (id) {
            data.append("id", id);
        }

        $.ajax({
            url: "{{ route('admin.withdraw.store') }}",
            type: 'POST',
            data: data,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $('#btn_form').attr('disabled', 'disabled');
                Notiflix.Block.circle('#user-modal .modal-content', 'Submitting...');
            },
            success: function(data) {
                $('#user-table').DataTable().ajax.reload();
                Notiflix.Block.remove('#user-modal .modal-content');
                $('#btn_form').removeAttr('disabled');
                if (data.code == 200) {
                    $('#user-modal').modal('hide');
                    Notiflix.Notify.success(data.message || 'Data berhasil disimpan!');
                } else {
                    Notiflix.Notify.warning(data.message || 'Periksa data Anda kembali.');
                }
            },
            error: function(xhr) {
                Notiflix.Block.remove('#user-modal .modal-content');
                $('#btn_form').removeAttr('disabled');
                if (xhr.responseJSON && xhr.responseJSON.error) {
                    Notiflix.Notify.failure(xhr.responseJSON.error);
                } else {
                    Notiflix.Notify.failure('Terjadi kesalahan, mohon coba lagi.');
                }
            }
        });
    });
});
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
        ajax: "{{ route('admin.withdraw.ajax') }}",
        scrollCollapse: true,
        fixedColumns: true,
        fixedHeader: true,
       
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
                    if (data) state = `<a class="btn btn-outline-success btn-sm">Selesai</a>`;
                    else state = `<a class="btn btn-outline-warning btn-sm">Pending</a>`;
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
                <div class="action-buttons d-flex justify-content-center ">
            <a href="javascript:void(0);" data-id="${full.id}" class="btn-edit btn btn-sm btn-outline-primary btn-icon mr-2" title="Edit details">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-printer"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
            </a>
        </div>`;
                }
            }
        ],
        columns: [{
                data: 'id',
            },
            {
                data: 'user.name',
            },
            {
                data: 'name',
            },
            {
                data: 'value',
            },
            {
                data: 'amount',
            },
            {
                data: 'description',
            },
            {
                data: 'status',
            },
            {
                data: 'withdrawn_at',
            },
            {
                data: 'id',
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