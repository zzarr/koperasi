@extends('layout.app')
@section('title','Simpanan Wajib')
@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush
@section('content')


<div class="page-header">
    <div class="page-title">
        <h3>Laporan Bulanan</h3>
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
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline>
            </svg>
            Import
        </a>
</div> --}}


        <div class="row" id="cancel-row">
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="table-responsive mb-4 mt-4">
                        <table id="user-table" class="table table-hover table-striped" style="width:100%">
                            <thead class="text-center">
                                <tr>
                                    <th style="vertical-align: middle">Nama</th>
                                    <th style="vertical-align: middle">Jumlah Pokok</th>
                                    <th style="vertical-align: middle">Jumlah Wajib</th>
                                    <th style="vertical-align: middle">Jumlah Hari Raya</th>
                                    <th style="vertical-align: middle">Aksi</th>
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

    {{-- modal Tanbah Data --}}
    <div class="modal fade" id="user-modal" tabindex="-1" role="dialog" aria-labelledby="userModalTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
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

    <div class="modal fade" id="modal-invoice" tabindex="-1" role="dialog" aria-labelledby="modalInvoiceLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalInvoiceLabel">Cetak Invoice</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="invoice-form" method="POST" action="{{ route('admin.report.export') }}">
                    @csrf
                    <input type="hidden" name="user_id" id="user_id">
                    <div class="modal-body">
                        <label for="payment-tanggal">Pilih Bulan Pembayaran:</label>
                        <select id="payment-tanggal" name="month" required class="form-control">
                            <option value="" disabled selected>Loading...</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" id="btn_form" class="btn btn-primary">Cetak</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
@endsection

@push('script')
<script>
   // Inisialisasi Flatpickr pada saat modal ditampilkan
$('#user-modal').on('shown.bs.modal', function(event) {
    // Input untuk tanggal pembayaran
    flatpickr("#paid_at", {
        dateFormat: "Y-m-d", // Format: Tahun-Bulan-Hari
        defaultDate: new Date(), // Tanggal default adalah hari ini
        allowInput: true, // Pengguna bisa mengetik manual
    });
});

// Logika untuk membuka modal dan mengatur ulang form
$('#user-table').on('click', '.btn-add', function() {
    var id = $(this).attr("data-id");
    $('#user-modal').modal('show');
    $("#user-modal #action-modal").text('Angsuran Baru');
    $("#user-form")[0].reset();
    $('#payment_month').val($(this).attr("data-month")); // Set bulan
    $('#payment_year').val(new Date().getFullYear()); // Set tahun
    $("#user-form").attr('data-userId', id);
});

$('#user-modal').on('click', '#btn_form', function() {
    let data = new FormData($('#user-form')[0]);
    let id = $('#user-form').attr("data-id") || '';
    let user_id = $('#user-form').attr("data-userId") || '';

    if (id) data.append("id", id);
    if (user_id) data.append("user_id", user_id);

    $.ajax({
        url: "{{ route('admin.payment.monthly.store') }}",
        type: 'POST',
        data: data,
        contentType: false,
        processData: false,
        beforeSend: function() {
            $('#btn_form').attr('disabled', true);
            Notiflix.Loading.pulse('Processing...');
        },
        success: function(data) {
            $('#user-modal').modal('hide');
            $('#btn_form').removeAttr('disabled');
            $('#user-form')[0].reset();
            $('#user-table').DataTable().ajax.reload();
            Notiflix.Loading.remove();

            if (data.code === 600) {
                Notiflix.Report.warning('Warning', data.message, 'OK');
            } else {
                Notiflix.Notify.success('Data berhasil disimpan!');

                // window.location.href = data.pdf_url;
            }
        },
        error: function(res) {
            $('#btn_form').removeAttr('disabled');
            Notiflix.Loading.remove();

            if (res.responseJSON && res.responseJSON.errors) {
                let errorMsg = Object.values(res.responseJSON.errors).flat().join('<br>');
                Notiflix.Report.failure('Error', errorMsg, 'OK');
            } else {
                Notiflix.Report.failure('Error', 'Terjadi kesalahan, silakan coba lagi.', 'OK');
            }
        }
    });
});


</script>

<script>


    $(document).on('click', '.btn-view', function() {
                // Ambil data-id dari tombol yang ditekan
                const dataId = $(this).data('id');

                // Tampilkan modal
                $('#modal-invoice').modal('show');

                // Ambil data dari backend untuk mengisi select
                $.ajax({
                    url: `/admin/payment/monthly/data_tanggal/${dataId}`, // Endpoint untuk mengambil data pembayaran
                    type: 'GET',
                    success: function(data) {
                        
                    const select = $('#payment-tanggal');
                    select.empty(); // Hapus opsi sebelumnya
                    
                    $('#user_id').val(dataId);
                    
                    // Tambahkan opsi baru berdasarkan properti "paid_at" dari data
                    if (Array.isArray(data)) {
                        data.forEach(payment => {
                                if (payment.paid_at!== null) {
                                    select.append(
                                        `<option value="${payment.payment_month}">Bulan ke-${payment.payment_month}</option>`
                                    );
                            }
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
           
            ajax: {
                url : "{{ route('admin.payment.monthly.ajax') }}",
                data: function(d){
                    d.source = 'report'
                }
            },
            scrollCollapse: true,

            fixedColumns: true,
            fixedHeader: true,
            columnDefs: [
                {
                    targets: -4,
                    title: 'Total simpanan Pokok',
                    // orderable: false,
                    createdCell: function(td, cellData, rowData, row, col) {
                        $(td).addClass('text-center');
                    },
                    render: function(data, type, full, meta) {
                        return formatRupiah(String(data), 'Rp. ');
                    },
                },
                {
                    targets: -3,
                    title: 'Total simpanan wajib',
                    // orderable: false,
                    createdCell: function(td, cellData, rowData, row, col) {
                        $(td).addClass('text-center');
                    },
                    render: function(data, type, full, meta) {
                        return formatRupiah(String(data), 'Rp. ');
                    },
                },
                {
                    targets: -2,
                    title: 'Total simpanan Hari Raya ',
                    // orderable: false,
                    createdCell: function(td, cellData, rowData, row, col) {
                        $(td).addClass('text-center');
                    },
                    render: function(data, type, full, meta) {
                        return formatRupiah(String(data), 'Rp. ');
                    },
                },
                {
                        targets: -1,
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
                    data: 'wallet.main'
                },
                {
                    data: 'wallet.monthly'
                },
                {
                    data: 'wallet.other'
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
                },
            }

        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endpush