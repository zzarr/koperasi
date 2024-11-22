<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Invoice Penarikan</title>
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" />
        <!-- App css -->
        
        <link
            href="templates/assets/css/bootstrap.min.css"
            rel="stylesheet"
            type="text/css"
        />
        {{-- <link
            href="dist/css/icons.min.css"
            rel="stylesheet"
            type="text/css"
        /> --}}
        <link href="dist/css/app.min.css" rel="stylesheet" type="text/css" />
        <style>
            body {
              font-family: Arial, sans-serif;
            }
            .invoice-head {
              border-bottom: 1px solid #ddd;
              margin-bottom: 20px;
            }
            .table {
              width: 100%;
              border-collapse: collapse;
            }
            .table th, .table td {
              border: 1px solid #ddd;
              padding: 8px;
              text-align: left;
            }
            .table th {
              background-color: #f8f9fa;
            }
          </style>
          
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="card">
                        <div class="card-body invoice-head">
                            <div class="row">
                                <div class="col-md-4 align-self-center">
                                    {{-- <img src="{{ asset('assets/images/logo-sm.png') }}" alt="logo-small" class="logo-sm me-1" height="24" />
                                    <img src="{{ asset('assets/images/logo-dark.png') }}" alt="logo-large" class="logo-lg brand-dark" height="16" />
                                    <img src="{{ asset('assets/images/logo.png') }}" alt="logo-large" class="logo-lg brand-light" height="16" /> --}}
                                    <h1 class="mt-1 mb-0 text-muted">INVOICE</h1>
                                    <h4>KOPERASI KARYAWAN</h4>
                                    <div class="ms-auto text-end">
                                        <p class="text-muted mb-0">Jalan Graha Asri Perdana No.11 Blok D</p>
                                        <p class="text-muted mb-0">Kecamatan Lohbener Kabupaten Indramayu</p>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <ul class="list-inline mb-0 contact-detail float-end">
                                        {{-- <li class="list-inline-item">
                                            <div class="ps-3">
                                                <i class="mdi mdi-phone"></i>
                                                <p class="text-muted mb-0">+123 123456789</p>
                                                <p class="text-muted mb-0">+123 123456789</p>
                                            </div>
                                        </li> --}}
                                    
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row row-cols-3 d-flex justify-content-md-between">
                                <div class="col-md-3 d-print-flex">
                                    <div class="">
                                        <h6 class="mb-2"><b>Tanggal Penarikan :</b> {{ $withdraw->withdrawn_at }}</h6>
                                    </div>
                                </div>
                              
                            </div>

                            <div class="col-md-3 d-print-flex ms-auto text-end">
                                <div class="">
                                    <address class="font-13">
                                        <strong class="font-14 mr-2">Bapak/Ibu:</strong><br />
                                        {{ $withdraw->user->name }}<br />
                                    </address>
                                </div>
                            </div>

             

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive project-invoice">
                                        <table class="table table-bordered mb-0">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Jenis Penarikan</th>
                                                    <th>Catatan</th>
                                                    <th>Status</th>
                                                    <th>Nilai Penarikan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>@if($withdraw->name == 'all')
                                                        Penarikan Keseluruhan Tabungan
                                                    @elseif($withdraw->name == 'other-cash')
                                                        Penarikan Keseluruhan Dana Hari Raya
                                                    @else
                                                        Penarikan Tabungan Hari Raya
                                                    @endif
                                                </td>
                                                    <td>{{ $withdraw->description ?: 'Tidak ada catatan khusus' }}</td>
                                                    <td> {{ $withdraw->status == 1 ? 'Selesai' : 'Belum Selesai' }}</td>
                                                    <td>{{ formatRupiah($withdraw->amount) }}</td>
                                                </tr>
                                                <tr class="bg-black text-white">
                                                    <th colspan="2" class="border-0"></th>
                                                    <td class="border-0 font-14"><b>Total</b></td>
                                                    <td class="border-0 font-14"><b>{{ formatRupiah($withdraw->amount) }}</b></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <hr />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="templates/assets/js/bootstrap.bundle.min.js"></script>

    </body>
</html>
