@extends('layout.app')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h3>Detail History Piutang</h3>
    </div>

    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0);">History Hutang</a></li>
            <li class="breadcrumb-item active" aria-current="page"><span>Detail Piutang</span></li>
        </ol>
    </nav>
</div>

<div class="row" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <!-- Menampilkan Sisa Hutang -->
            <div class="rp-box float-right my-5">
                <h4>Sisa Hutang = <span id="sisa-hutang">Rp 0,00</span></h4>
            </div>

            <div class="table-responsive mb-4 mt-4">
                <table id="detail-table" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Pembayaran Ke-</th>
                            <th>Jumlah Bayar Pokok</th>
                            <th>Jumlah Bayar Bunga</th>
                            <th>Tanggal Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data akan di-load dengan DataTables -->
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
            </div>
            <a href="{{ route('user.history-piutang') }}" class="btn btn-secondary mt-3">Kembali</a>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    $(document).ready(function () {
        // Ambil jumlah hutang awal dari piutang yang ditampilkan
        var jumlahHutang = {{ $piutang->jumlah_hutang }};
        var totalPembayaran = 0;

        $('#detail-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('user.history-piutang.detail', $piutang->id) }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'pembayaran_ke', name: 'pembayaran_ke' },
                { data: 'jumlah_bayar_pokok', name: 'jumlah_bayar_pokok' },
                { data: 'jumlah_bayar_bunga', name: 'jumlah_bayar_bunga' },
                { data: 'tanggal_pembayaran', name: 'tanggal_pembayaran' }
            ],
            language: {
                paginate: {
                    previous: `
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left">
                            <line x1="19" y1="12" x2="5" y2="12"></line>
                            <polyline points="12 19 5 12 12 5"></polyline>
                        </svg>`,
                    next: `
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>`
                }
            },
            drawCallback: function(settings) {
                totalPembayaran = 0;
                // Menghitung total pembayaran
                settings.json.data.forEach(function(payment) {
                    totalPembayaran += payment.jumlah_bayar_pokok + payment.jumlah_bayar_bunga;
                });

                // Menampilkan sisa hutang
                var sisaHutang = jumlahHutang - totalPembayaran;
                $('#sisa-hutang').text('Rp ' + sisaHutang.toLocaleString('id-ID'));
            }
        });
    });
</script>
@endpush
