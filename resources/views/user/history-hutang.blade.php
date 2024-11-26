@extends('layout.app')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h3>History Piutang</h3>
    </div>
    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('user.dashboard') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page"><span>History Piutang</span></li>
        </ol>
    </nav>
</div>

<div class="row" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <div class="table-responsive mb-4 mt-4">
                <table id="datatable" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenis Hutang</th>
                            <th>Jumlah Hutang</th>
                            <th>Sisa Hutang</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data akan di-load menggunakan DataTables -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    $(document).ready(function () {
    var table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('user.history-piutang') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'jenis_hutang', name: 'jenis_hutang' },
            { data: 'jumlah_hutang', name: 'jumlah_hutang' },
            { data: 'sisa', name: 'sisa' },
            { 
                data: 'is_lunas', 
                name: 'is_lunas',
                render: function(data) {
                    return data == 1 
                        ? '<span class="badge badge-success">Lunas</span>' 
                        : '<span class="badge badge-warning">Belum Lunas</span>';
                }
            },
            { 
                data: 'aksi', 
                name: 'aksi', 
                orderable: false, 
                searchable: false,
                render: function(data, type, row) {
                    return `<a href="${row.detail_url}" class="btn btn-info btn-sm">Detail</a>`;
                }
            }
        ],
        language: {
            url: "//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json"
        }
    });

    // Memanggil ulang data jika diperlukan
    table.ajax.reload(null, false); // Mengambil data terbaru setelah ada perubahan
});


</script>
@endpush