<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Invoice Pembayaran Rutin</title>
    <link href="{{ asset('templates/assets/css/bootstrap.min.css') }}" rel="stylesheet" />
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
                            <div class="col-md-6">
                                <h1 class="mt-1 mb-0 text-muted">INVOICE</h1>
                                <h4>KOPERASI KARYAWAN</h4>
                                <p class="text-muted mb-0">Jalan Graha Asri Perdana No.11 Blok D</p>
                                <p class="text-muted mb-0">Kecamatan Lohbener, Kabupaten Indramayu</p>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <address>
                                    <strong>Penerima Pembayaran:</strong><br>
                                    {{ $data->piutang->user->username ?? 'Data tidak ditemukan' }}<br>
                                </address>
                            </div>
                            {{-- <div class="col-md-6 text-end">
                                <strong>Tanggal Cetak:</strong><br>
                                {{ now()->format('d M Y') }}<br>
                            </div> --}}
                        </div>

                        <div class="table-responsive mt-4">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Pembayaran Ke-</th>
                                        <th>Tanggal Pembayaran</th>
                                        <th>Catatan</th>
                                        <th class="text-end">Nominal Bayar Pokok</th>
                                        <th class="text-end">Nominal Bayar Bunga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $data->pembayaran_ke }}</td>
                                        <td>{{ $data->tanggal_pembayaran }}</td>
                                        <td>{{ $data->catatan }}</td>
                                        <td class="text-end">{{ formatRupiah($data->jumlah_bayar_pokok) }}</td>
                                        <td class="text-end">{{ formatRupiah($data->jumlah_bayar_bunga) }}</td>
                                    </tr>
                                    <tr class="bg-light">
                                        <td colspan="4" class="text-end"><strong>Total Pembayaran</strong></td>
                                        <td class="text-end"><strong>{{ formatRupiah($data->jumlah_bayar_pokok + $data->jumlah_bayar_bunga) }}</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="text-end mt-4">
                            <p>Terima kasih atas pembayaran Anda!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.print();
    </script>
</body>

</html>
