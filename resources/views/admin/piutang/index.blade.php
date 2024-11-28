@extends('layout.app')
@section('content')
    <div class="page-header">
        <div class="page-title">
            <h3>Manajemen Piutang</h3>
        </div>

        <nav class="breadcrumb-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a></li>
                <!-- <li class="breadcrumb-item"><a href="javascript:void(0);">Starter Kits</a></li> -->
                <li class="breadcrumb-item active" aria-current="page"><span>Manajemen Piutang</span></li>
            </ol>
        </nav>
    </div>

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
                            <div class="modal-body">
                                <!-- Form input -->
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <select class="form-control" id="nama" name="nama" required>
                                        <option value="" disabled selected>Pilih Nama</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="jenis_hutang">Jenis Hutang</label>
                                    <select class="form-control" id="jenis_hutang" name="jenis_hutang" required>
                                        <option value="" disabled selected>Pilih Jenis Hutang</option>
                                        <option value="rutin">Rutin</option>
                                        <option value="khusus">Khusus</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="jumlah_bulan">Jumlah Bulan</label>
                                    <select class="form-control" id="jumlah_bulan" name="jumlah_bulan" required>
                                        <option value="" disabled selected>Pilih Jumlah Bulan</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="jumlah_hutang">Jumlah Hutang</label>
                                    <input type="text" class="form-control"  id="jumlah_hutang"  name="jumlah_hutang"   required  oninput="formatInputRupiah(this)">
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
                            <th>Nama</th>
                            <th>Jenis Hutang</th>
                            <th>Jumlah Bulan</th>
                            <th>Jumlah Hutang</th>
                            <th>Sisa</th>
                            <th>Status</th>
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
    $('#createForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: "{{ route('admin.piutang.store') }}", // Route untuk menyimpan data
            method: 'POST',
            data: $(this).serialize(), // Ambil data dari form
            success: function(response) {
                $('#exampleModal').modal('hide'); // Tutup modal
                $('#createForm')[0].reset(); // Reset form
                $('#datatable').DataTable().ajax.reload(); // Reload data di datatable
                Notiflix.Notify.success('Data berhasil ditambahkan!'); // Notifikasi sukses
            },
            error: function(xhr) {
                const errors = xhr.responseJSON.errors;
                for (const key in errors) {
                    Notiflix.Notify.failure(errors[key][0]); // Tampilkan error pada setiap field
                }
            }
        });
    });

    function formatInputRupiah(input) {
    // Hilangkan karakter non-digit
    let angka = input.value.replace(/[^,\d]/g, '');
    
    if (!angka) {
        input.value = ''; // Kosongkan jika tidak ada angka
        return;
    }

    // Format angka dengan separator ribuan
    input.value = 'Rp ' + angka.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

</script>




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
            ajax: "{{ route('admin.piutang.ajax') }}",
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
                { data: 'user_name' },     
                { data: 'jenis_hutang' }, 
                { data: 'jumlah_bulan' },
                {
                    data: 'jumlah_hutang',
                    render: function (data) {
                        return formatRupiah(data);
                    }
                },  
                {
                    data: 'sisa',
                    render: function (data) {
                        return formatRupiah(data);
                    }
                },          
                {
                    data: 'is_lunas',      
                    render: function(data, type, row) {
                       
                        return data == 1 ? 'Lunas' : 'Belum Lunas';
                    }
                },

                { data: 'id' },     
            ],
            language: {
                searchPlaceholder: 'Cari...',
                sSearch: '',
            }
        });
                    function formatRupiah(angka) {
                    if (angka == null) return '-';
                    return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                   }

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
                    url: '/admin/piutang/delete/' + dataId,
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

    // Lakukan permintaan AJAX untuk mendapatkan detail data
    $.ajax({
        url: `/admin/piutang/pembayaran/${id}`, // Endpoint untuk mengambil data berdasarkan ID
        method: 'GET',
        success: function (data) {
            const jenisHutang = data.jenis_hutang; // Ambil jenis_hutang dari respons data

            // Tentukan URL berdasarkan jenis_hutang
            let url;
            if (jenisHutang === 'rutin') {
                url = `/admin/piutang/pembayaran/rutin/${id}/detail`;
            } else if (jenisHutang === 'khusus') {
                url = `/admin/piutang/pembayaran/khusus/${id}/detail`;
            } else {
                Notiflix.Notify.failure('Jenis hutang tidak valid.'); // Jika jenis_hutang tidak valid
                return;
            }

            // Arahkan ke halaman baru
            window.location.href = url;
        },
        error: function () {
            Notiflix.Notify.failure('Gagal mengambil data. Silakan coba lagi.');
        }
    });
});


    });
</script>

@endpush