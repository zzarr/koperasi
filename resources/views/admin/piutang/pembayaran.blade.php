@extends('layout.app')
@section('content')
<div class="page-header">
    <div class="page-title">
        <h3>Manajemen Pembayarann Piutang</h3>
    </div>

    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a></li>
            <!-- <li class="breadcrumb-item"><a href="javascript:void(0);">Starter Kits</a></li> -->
            <li class="breadcrumb-item active" aria-current="page"><span>Manajemen Pembayaran Piutang</span></li>
        </ol>
    </nav>
    
</div>
<div class="d-flex justify-content-start mb-3">
<a href="/admin/piutang" class="btn btn-secondary">Kembali</a></div>
<div class="row" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <div class="table-responsive mb-4 mt-4">
                <table id="datatable" id="zero-config" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Pembayaran Ke-</th>
                            <th>Jumlah Bayar Pokok</th>
                            <th>Jumlah Bayar Bunga</th>
                            <th>Tanggal Pembayaran</th>
                            <th class="no-content">Action</th>

                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>




@endsection
@push('script')

<script>
    $(document).ready(function() {


         $.ajax({
            url: '/admin/piutang/users', // URL baru yang diarahkan ke PiutangController
            method: 'GET',
            success: function(data) {
                const namaSelect = $('#nama');
                namaSelect.empty();
                namaSelect.append('<option value="" disabled selected>Pilih Nama</option>');
                data.forEach(user => {
                    namaSelect.append(`<option value="${user.id}">${user.name}</option>`);
                });
            }
            });
        // Setup token CSRF untuk request Ajax
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Inisialisasi DataTables
        let table = $("#datatable").DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.piutang.pembayaran.ajax') }}",
            columnDefs: [
                {
                    targets: 0, // Kolom nomor urut
                    render: function(data, type, full, meta) {
                        return meta.row + 1;
                    },
                },
                {
                    targets: -1, // Kolom aksi di posisi terakhir
                    render: function(data, type, full, meta) {
                        let btn = `
                        <div class="btn-list">
                            <button class="btn btn-info btn-detail mr-1 rounded-circle" data-id="${data}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings">
                                    <circle cx="12" cy="12" r="3"></circle>
                                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                                </svg>
                            </button>
                            <button class="btn btn-danger btn-delete rounded-circle" data-id="${data}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                </svg>
                            </button>
                        </div>
                    `;
                        return btn;
                    },
                },
            ],
            columns: [
                { data: 'id' },           
                { data: 'pembayaran ke-' },     
                { data: 'jumlah_bayar_pokok' },  
                { data: 'jumlah_bayar_bunga' }, 
                { data: 'tanggal_pembayaran' },  
                { data: 'id' },            // Kolom aksi
            ],
            language: {
                searchPlaceholder: 'Cari...',
                sSearch: '',
            }
        });

 // Event listener untuk tombol delete
 $(document).on('click', '.btn-delete', function() {
        let dataId = $(this).data('id');

        Notiflix.Confirm.show(
            'Konfirmasi Hapus',
            'Apakah Anda yakin ingin menghapus data ini?',
            'Ya, Hapus',
            'Tidak',
            function() {
                $.ajax({
                    url: '/admin/delete/' + dataId,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Notiflix.Notify.success('Data berhasil dihapus');
                        table.ajax.reload();
                    },
                    error: function(xhr) {
                        Notiflix.Notify.failure('Terjadi kesalahan');
                    }
                });
            },
            function() {
                Notiflix.Notify.info('Aksi dibatalkan');
            }
        );
    });


    $(document).on('click', '.btn-detail', function () {
    const id = $(this).data('id'); // Ambil ID dari tombol
    // Arahkan ke halaman baru untuk melihat detail
    window.location.href = `/admin/piutang/${id}/detail`;
});

    });
</script>

@endpush