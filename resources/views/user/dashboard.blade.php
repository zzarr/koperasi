@extends('layout.app')
@section('content')

<div class="page-header">
    <div class="page-title">
        <h3>Manajemen User</h3>
    </div>
    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
            </a></li>
            <li class="breadcrumb-item active" aria-current="page"><span>Manajemen Pelanggan</span></li>
        </ol>
    </nav>
</div>

<!-- Main content -->
<div class="row" id="cancel-row">
    <div class="col-12 layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <!-- Tombol Print -->
            <button type="button" class="btn btn-outline-primary mb-2 mr-2" onclick="window.print()">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16">
                    <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v2h-1V2a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v2H2V2z"/>
                    <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2h-1v2a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1v-2H2a2 2 0 0 1-2-2V7zm4 9v-4h8v4H4z"/>
                </svg> Print
            </button>

            <!-- Tombol Import Excel dan PDF -->
            <button type="button" class="btn btn-outline-success mb-2 mr-2" data-toggle="modal" data-target="#importModal">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-spreadsheet" viewBox="0 0 16 16">
                    <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V9H3V2a1 1 0 0 1 1-1h5.5zM3 12v-2h2v2zm0 1h2v2H4a1 1 0 0 1-1-1zm3 2v-2h3v2zm4 0v-2h3v1a1 1 0 0 1-1 1zm3-3h-3v-2h3zm-7 0v-2h3v2z"/>
                </svg> Import Excel
            </button>
            <button type="button" class="btn btn-outline-danger mb-2 mr-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-pdf" viewBox="0 0 16 16">
                    <path d="M5.5 7.5v1h2v1h-2v1h2V12h1V8.5h1v1h-1v-1H7v1h1v1h1v-1h1v-1H6v-1h2v-1H5.5zm4.5 1h2v-1h-2v-1H8v4h2V10h1v1h1v-1H9v1h-1v-2h2v1h-1v-1zm-2 2v-1H7v1h1zm1-5.5a2 2 0 0 1 2 2h-1a1 1 0 0 0-1-1v-1zM14 14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h5.5L14 4.5V14zM5 2h1v1H5V2zm6 1v.5a.5.5 0 0 0 .5.5H13V5H9.5A1.5 1.5 0 0 1 8 3.5V2H5a1 1 0 0 0-1 1v4.5H5v1H3v1h4v1h2v1h2v-2h-2v1H9V8.5A1.5 1.5 0 0 1 10.5 7H13v1h-1v1h-1v1h1v-2h1V5H9.5A.5.5 0 0 0 9 5.5V7H5V4H4a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4h-2z"/>
                </svg> Export PDF
            </button>

            <!-- Tabel Data Pelanggan -->
            <div class="table-responsive mb-4 mt-4">
                <table id="pelanggan-table" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Kode Anggota</th>
                            <th>Nomor Telefon</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>John Doe</td>
                            <td>12345</td>
                            <td>08123456789</td>
                            <td>Jl. Contoh Alamat</td>
                            <td>
                                <button class="btn btn-primary btn-sm">Edit</button>
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Jane Smith</td>
                            <td>67890</td>
                            <td>08198765432</td>
                            <td>Jl. Alamat Lain</td>
                            <td>
                                <button class="btn btn-primary btn-sm">Edit</button>
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push('css')
    <!-- CSS dependencies -->
    <link href="{{ asset('demo1/assets/css/scrollspyNav.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('demo1/plugins/file-upload/file-upload-with-preview.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('demo1/plugins/table/datatable/datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('demo1/plugins/table/datatable/dt-global_style.css') }}">
    <style>
        .paginate-button {
            cursor: pointer;
            display: inline-flex;
            align-items: center;
        }

        .paginate-button svg {
            margin-right: 5px;
        }
    </style>
    <link href="{{ asset('demo1/assets/css/scrollspyNav.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('demo1/assets/css/components/custom-modal.css') }}" rel="stylesheet" type="text/css">
@endpush

@push('js')
    <!-- JS dependencies -->
@endpush
