<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Invoice Pembayaran</title>
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" />
    <!-- App css -->

    <link href="templates/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
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

        .table th,
        .table td {
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

                            </div>

                        </div>

                        <div class="col-md-3 d-print-flex ms-auto text-end">
                            <div class="">
                                <address class="font-13">
                                    <strong class="font-14 mr-2">Bapak/Ibu:</strong><br />
                                    {{ $data[0]->user->name }}<br />
                                </address>
                            </div>
                        </div>



                        <div class="row">
                            <div class="col-lg-12">
                                <div class="table-responsive project-invoice">
                                    <table class="table table-bordered mb-0">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Pembayaran</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($data as $item)
                                            <tr>

                                                <td> {{ $item->paid_at }}</td>
                                                <td>{{ formatRupiah($item->amount) }}</td>
                                            </tr>
                                        @endforeach
                                        <tr class="bg-black text-white">
                                            <td class="border-0 font-14"><b>Total</b></td>
                                            <td class="border-0 font-14">
                                                <b>{{ formatRupiah($data->sum('amount')) }}</b>
                                            </td>
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
    <script>
        const KTApp = {
            block: function(content) {
                let overlay = `
                                    <div class="overlay" style="background-color: rgba(189, 189, 189, 0.7)">
                                        <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                                    </div>`;
                $(content).append(overlay);
            },
            unblock: function(content) {
                $(content + ' .overlay').remove();
            },
        }

        function formatRupiah(angka, prefix) {
            let number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? prefix + rupiah : '');
        }
    </script>

</body>

</html>
