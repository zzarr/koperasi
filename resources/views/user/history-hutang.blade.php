@extends('layout.app')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h3>History Hutang</h3>
    </div>

    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a></li>
            <li class="breadcrumb-item active" aria-current="page"><span>History Hutang</span></li>
        </ol>
    </nav>
</div>

<!-- Menampilkan Sisa Hutang di Atas Tabel -->
<div class="row mb-4">
    <div class="col-12">
        <div class="alert alert-info">
            <strong>Total Sisa Hutang: </strong>
            <span id="totalSisaHutang">Loading...</span>
        </div>
    </div>
</div>

<div class="row" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <div class="table-responsive mb-4 mt-4">
                <table id="piutangTable" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenis Hutang</th>
                            <th>Jumlah Hutang</th>
                            <th>Sisa</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- DataTable rows will be populated here by AJAX -->
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
    $(document).ready(function () {
        // Inisialisasi DataTable
        var table = $('#piutangTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('user.history-piutang') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'jenis_hutang', name: 'jenis_hutang' },
                { data: 'jumlah_hutang', name: 'jumlah_hutang' },
                { data: 'sisa', name: 'sisa' },
                { data: 'is_lunas', name: 'is_lunas' },
                { data: 'aksi', name: 'aksi', orderable: false, searchable: false }
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
            }
        });

        // Hitung dan tampilkan total sisa hutang di atas tabel
        $.ajax({
            url: "{{ route('user.history-piutang') }}",
            method: "GET",
            success: function(response) {
                // Menghitung total sisa hutang
                var totalSisa = 0;
                response.data.forEach(function(item) {
                    var sisaHutang = parseInt(item.sisa.replace(/\D/g, '')); // Menghapus karakter non-digit
                    totalSisa += sisaHutang;
                });

                // Menampilkan total sisa hutang
                $('#totalSisaHutang').text(totalSisa.toLocaleString('id-ID'));
            }
        });
    });
</script>
@endpush
