@extends('layout.app')
@section('content')
<div class="page-header">
    <div class="page-title">
        <h3>Manajemen Pembayarann Piutang Rutin</h3>
    </div>

    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a></li>
            <!-- <li class="breadcrumb-item"><a href="javascript:void(0);">Starter Kits</a></li> -->
            <li class="breadcrumb-item active" aria-current="page"><span>Manajemen Pembayaran Piutang Rutin</span></li>
        </ol>
    </nav>

</div>

<div class="d-flex justify-content-start mb-3">
    <a href="/admin/piutang" class="btn btn-secondary">Kembali</a>
    <button type="button" class="btn btn-primary mx-2" data-toggle="modal" data-target="#exampleModal">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="feather feather-plus">
            <line x1="12" y1="5" x2="12" y2="19"></line>
            <line x1="5" y1="12" x2="19" y2="12"></line>
        </svg> Tambah Data
    </button>
    <button class="btn btn-primary" onclick="window.open('/admin/piutang/pembayaran/rutin/print-all/{{ $piutang->id }}', '_blank')">
        <i class="fa fa-print"></i> Cetak Semua Riwayat Pembayaran
    </button>
</div>


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
                                <input type="text" name="jumlah_bayar_pokok" id="jumlah_bayar_pokok" class="form-control" value="{{ formatRupiah($nominal) }}" required oninput="formatInputRupiah(this)">
                            </div>
                            <div class="form-group">
                                <label for="catatan">Catatan</label>
                                <textarea name="catatan" id="catatan" class="form-control" rows="3" placeholder="Tambahkan catatan jika perlu"></textarea>
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

        <div class="row" id="cancel-row">
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="rp-box  float-right my-5">
                        <h5>   Sisa Hutang = Rp {{ number_format($sisa, 2, ',', '.') }}</h5>
                    </div>
                    <div class="table-responsive mb-4 mt-4">
                        <table id="datatable" id="zero-config" class="table table-hover" style="width:100%">
                            <thead>

                                <tr>
                                    <th>No</th>
                                    <th>Pembayaran Ke-</th>
                                    <th>Tanggal Pembayaran</th>
                                    <th>Jumlah Bayar Pokok</th>
                                    <th>Jumlah Bayar Jasa</th>
                                    <th>Catatan</th>
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

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let table = $("#datatable").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
            url: "{{ route('admin.piutang.pembayaran.rutin.ajax') }}",
            type: "GET",
            data: function(d) {
                d.hutang_id = {{ $hutang_id }};
            }
             },
            columnDefs: [
                {
                    targets: 0,
                    render: function(data, type, full, meta) {
                        return meta.row + 1;
                    },
                },
                {
                    targets: -1,
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
                {
                    data: 'jumlah_bayar_pokok',
                    render: function (data) {
                        return formatRupiah(data);
                    }
                },
                {
                    data: 'jumlah_bayar_bunga',
                    render: function (data) {
                        return formatRupiah(data);
                    }
                },
                { data: 'catatan' },
                { data: 'id' },
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


    $(document).on('click', '.btn-print', function() {

    const paymentId = $(this).data('id');

    const printUrl = `/admin/piutang/pembayaran/rutin/print/${paymentId}`;

    window.open(printUrl, '_blank');
});
});
</script>

<script>
    $(document).ready(function () {
        $('#createForm').on('submit', function (event) {
            event.preventDefault();

            const hutangId = $("input[name='hutang_id']").val();
            if (!$('#tanggal_pembayaran').val() || !$('#jumlah_bayar_pokok').val()) {
                Notiflix.Notify.failure('Semua field harus diisi');
                return;
            }

            const formData = {
                hutang_id: hutangId,
                tanggal_pembayaran: $('#tanggal_pembayaran').val(),
                jumlah_bayar_pokok: $('#jumlah_bayar_pokok').val(),
                catatan: $('#catatan').val(),
            };

            $.ajax({
                url: '/admin/piutang/pembayaran/rutin/store',
                method: 'POST',
                data: formData,
                success: function (response) {
                    if (response.message) {
                        Notiflix.Notify.success(response.message);
                        $('#createForm')[0].reset();
                        $('#exampleModal').modal('hide');
                        $('#datatable').DataTable().ajax.reload();
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                    if (xhr.status === 422) {
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

    function formatInputRupiah(input) {
    let angka = input.value.replace(/[^,\d]/g, '');
    if (!angka) {
        input.value = '';
        return;
    }
    input.value = 'Rp ' + angka.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
</script>
@endpush
