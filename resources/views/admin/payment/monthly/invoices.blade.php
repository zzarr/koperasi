<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Invoice Pembayaran Bulanan</title>
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" />
        <!-- App css -->
        <link href="templates/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
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
                                    <h1 class="mt-1 mb-0 text-muted">INVOICE</h1>
                                    <h4>KOPERASI KARYAWAN</h4>
                                    <p class="text-muted mb-0">KOSMA SASI</p>
                                    <p class="text-muted mb-0">Jl. MT. Haryono Sindang Indramayu</p>
                                </div>
                                <div class="col-md-8">
                                    <ul class="list-inline mb-0 contact-detail float-end">
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row row-cols-3 d-flex justify-content-md-between">
                                <div class="col-md-3 d-print-flex">
                                    <div class="">
                                        <h6 class="mb-2"><b>Tanggal Pembayaran :</b> {{ $data->paid_at }}</h6>
                                        <h6 class="mb-2"><b>Bulan Pembayaran :</b> {{ $data->payment_month }}</h6>
                                        <h6 class="mb-2"><b>Tahun Pembayaran :</b> {{ $data->payment_year }}</h6>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3 d-print-flex ms-auto text-end">
                                <div class="">
                                    <address class="font-13">
                                        <strong class="font-14 mr-2">Bapak/Ibu:</strong><br />
                                        {{ $data->user->name }}<br />
                                    </address>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive project-invoice">
                                        <table class="table table-bordered mb-0">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Jenis Pembayaran</th>
                                                    <th>Tanggal Pembayaran</th>
                                                    <th>Jumlah Pembayaran</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        @if ($data->configPayment->name == 'monthly_payment')
                                                            Simpanan Wajib
                                                        @endif</td>
                                                    <td>{{ $data->paid_at }}</td>
                                                    <td>{{ formatRupiah($data->amount) }}</td>

                                                </tr>
                                                <tr class="bg-black text-white">
                                                    <th colspan="1" class="border-0"></th> <!-- Sesuaikan colspan dengan jumlah kolom -->
                                                    <td class="border-0 font-14 "><b>Total</b></td> <!-- Menambahkan  untuk perataan kanan -->
                                                    <td class="border-0 font-14"><b>{{ formatRupiah($data->amount) }}</b></td> <!-- Menambahkan text-end untuk perataan kanan -->
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
