@extends('layout.app')
@section('content')
<div class="page-header">
    <div class="page-title">
        <h3>Manajemen Pembayarann Piutang Khusus</h3>
    </div>

    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a></li>
            <!-- <li class="breadcrumb-item"><a href="javascript:void(0);">Starter Kits</a></li> -->
            <li class="breadcrumb-item active" aria-current="page"><span>Manajemen Pembayaran Piutang Khusus</span></li>
        </ol>
    </nav>
    
</div>

<div class="d-flex justify-content-start mb-3">
<a href="/admin/piutang" class="btn btn-secondary">Kembali</a></div>

<div class="d-flex justify-content-start mb-3">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="feather feather-plus">
            <line x1="12" y1="5" x2="12" y2="19"></line>
            <line x1="5" y1="12" x2="19" y2="12"></line>
        </svg> Tambah Data
    </button>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
          aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>


                    <form id="createForm">
                        @csrf
                        <input type="hidden" name="hutang_id" value="{{ $piutang->id }}">
                        <div class="modal-body">
                            <!-- Form input lainnya -->
                            <div class="form-group">
                                <label for="tanggal_pembayaran">Tanggal Pembayaran</label>
                                <input type="date" name="tanggal_pembayaran" id="tanggal_pembayaran" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="jumlah_bayar_pokok">Nominal Pokok</label>
                                <input type="text" name="jumlah_bayar_pokok" id="jumlah_bayar_pokok" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="jumlah_bayar_bunga">Nominal Bunga</label>
                                <input type="text" name="jumlah_bayar_bunga" id="jumlah_bayar_bunga" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                    
                    

                </div>
            </div>
        </div>
</div>
<div class="row" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <div class="table-responsive mb-4 mt-4">
                <table id="datatable" id="zero-config" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Pembayaran Ke-</th>
                            <th>Tanggal Pembayaran</th>
                            <th>Jumlah Bayar Pokok</th>
                            <th>Jumlah Bayar Bunga</th>
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
            ajax: {
        url: "{{ route('admin.piutang.pembayaran.khusus.ajax') }}",
        type: "GET",
        data: function(d) {
            d.hutang_id = {{ $hutang_id }}; // Pastikan nilai hutang_id dikirimkan
        }
    },
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
                        return btn;
                    },
                },
            ],
            columns: [
                { data: 'id' },          
                { data: 'pembayaran_ke' },     
                { data: 'tanggal_pembayaran' },  
                { data: 'jumlah_bayar_pokok' },  
                { data: 'jumlah_bayar_bunga' }, 
                { data: 'id' },            // Kolom aksi
            ],
            language: {
                searchPlaceholder: 'Cari...',
                sSearch: '',
            }
        });

        $(document).on('click', '.btn-print', function() {
    // Ambil data-id dari tombol print yang ditekan
    const paymentId = $(this).data('id');

    // Buka halaman cetak dengan ID pembayaran
    const printUrl = `/admin/piutang/pembayaran/khusus/print/${paymentId}`;

    // Membuka halaman cetak di tab baru
    window.open(printUrl, '_blank');
});
});

</script>





<script>
    $(document).ready(function () {
        $('#createForm').on('submit', function (event) {
            event.preventDefault(); // Mencegah form untuk submit secara default

            const hutangId = $("input[name='hutang_id']").val(); // Mengambil ID hutang dari form

            // Validasi input form sebelum mengirimkan data
            if (!$('#tanggal_pembayaran').val() || !$('#jumlah_bayar_pokok').val() || !$('#jumlah_bayar_bunga').val()) {
                Notiflix.Notify.failure('Semua field harus diisi');
                return; // Menghentikan eksekusi jika ada field yang kosong
            }

            // Ambil data dari form
            const formData = {
                hutang_id: hutangId,
                tanggal_pembayaran: $('#tanggal_pembayaran').val(),
                jumlah_bayar_pokok: $('#jumlah_bayar_pokok').val(),
                jumlah_bayar_bunga: $('#jumlah_bayar_bunga').val(),
            };

            // Kirim data ke backend
            $.ajax({
                url: '/admin/piutang/pembayaran/khusus/store', // Ganti dengan URL yang sesuai
                method: 'POST',
                data: formData,
                success: function (response) {
                    if (response.message) {
                        Notiflix.Notify.success(response.message); // Tampilkan notifikasi sukses
                        $('#createForm')[0].reset(); // Reset form setelah berhasil
                        $('#exampleModal').modal('hide'); // Menutup modal setelah berhasil
                        // Refresh DataTable
                        $('#datatable').DataTable().ajax.reload();
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                    if (xhr.status === 422) {
                        // Jika ada validasi gagal di server, tampilkan pesan kesalahan
                        const errors = xhr.responseJSON.errors;
                        let errorMessage = 'Gagal menyimpan pembayaran. ';
                        for (const key in errors) {
                            errorMessage += `${errors[key].join(', ')} `;
                        }
                        Notiflix.Notify.failure(errorMessage.trim());
                    } else {
                        Notiflix.Notify.failure('Terjadi kesalahan pada server');
                    }
                }
            });
        });
    });
</script>


@endpush