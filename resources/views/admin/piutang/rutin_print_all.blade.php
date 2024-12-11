<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        @foreach ($usernames as $username)
        <title>Cetak Seluruh Data Pembayaran Rutin {{ $username }}</title>
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
                   
                        <p><strong>Username       : {{ $username }}</strong></p>
                        <p><strong>Sisa Hutang : Rp.{{ number_format($sisaHutang, 2) }}</strong></p>
                    @endforeach

                    <div class="table-responsive mt-4">
                        <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Pembayaran Ke-</th>
                                <th>Tanggal Pembayaran</th>
                                <th>Nominal Bayar Pokok</th>
                                <th>Nominal Bayar Bunga</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pembayaran as $key => $data)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $data->pembayaran_ke }}</td>
                                <td>{{ $data->tanggal_pembayaran }}</td>
                                <td>Rp {{ number_format($data->jumlah_bayar_pokok, 2, ',', '.') }}</td>
                                <td>Rp {{ number_format($data->jumlah_bayar_bunga, 2, ',', '.') }}</td>
                                <td>{{ $data->catatan }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="text-end mt-4">
                        <p>Terima kasih atas pembayaran Anda!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
                    <script>
                        window.onload = function() {
                            window.print();
                        };
                    </script>
</body>
</html>
