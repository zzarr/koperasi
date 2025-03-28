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
              width: 50% !important;
              padding: 0;
              margin: 0;
            }
            .invoice-head {
              border-bottom: 1px solid #ddd;
              margin-bottom: 0px;
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
            .column{
                height: 15px;
                margin-top:-10px;
            }
        </style>
    </head>
    <body>
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="card">
                    <div class="invoice-head">
                        <div class="row">
                            <div class="col-md-4 align-self-center">
                                {{-- <h1 class="mt-1 mb-0 text-muted text-center">INVOICE</h1> --}}
                                <h1 class="text-center">{{ $configs->where('name', 'app_app_name')->first()->paid_off_amount }}</h1>
                                <div class="ms-auto text-center">
                                    <p class="mb-0">{{ $configs->where('name', 'app_instansi')->first()->paid_off_amount }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                            
                        <div class="">
                            <h6 class="mb-2"><b>Nama :</b> {{ $data->user->name }}</h6>
                            <h6 class="mb-2"><b>Bulan :</b> {{ monthArray()[$data->payment_month]['name'].'-'.$data->payment_year }}</h6>
                            <h6 class="mb-2">{{ $data->user->address == 'asn' ? 'Aparatur Sipil Negara/P3K' : ($data->user->address == 'tu' ? 'Aparatur Sipil Negara/P3K/TU' : 'Non Aparatur Sipil Negara' )}}</h6>
                        </div>

                        <h5 class="text-center" style="margin: 10px 0px 10px">Transaksi</h5>
                        
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="table-responsive project-invoice">
                                    <table class="table mb-0">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Pinjaman</th>
                                                <th>Jumlah</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- Start 1 Row --}}
                                            <tr>
                                                <td colspan="2" style="padding-top: 20px">
                                                    <div class="column"><b>RUTIN (1)</b></div>
                                                </td>
                                                <td>
                                                    <div class="column">{{ $pembayaran->has('rutin') ? ($pembayaran['rutin']?->first()->piutang->first()->source == 'gaji' ? 'Gaji' : 'TPP/KUM') : '-' }}</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="column">POKOK</div>
                                                </td>
                                                <td>
                                                    <div class="column">{{ $pembayaran->has('rutin') ? formatRupiah($pembayaran['rutin']?->first()->jumlah_bayar_pokok) : '-' }}</div>
                                                </td>
                                                <td>
                                                    <div class="column">-</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="column">JASA</div>
                                                </td>
                                                <td>
                                                    <div class="column">{{ $pembayaran->has('rutin') ? formatRupiah($pembayaran['rutin']?->first()->jumlah_bayar_bunga) : '-' }}</div>
                                                </td>
                                                <td>
                                                    <div class="column">-</div>
                                                </td>
                                            </tr>
                                            {{-- End 1 Row --}}
                                            {{-- Start 2 Row --}}
                                            <tr>
                                                <td colspan="2" style="padding-top: 20px">
                                                    <div class="column"><b>RUTIN (2)</b></div>
                                                </td>
                                                <td>
                                                    <div class="column">{{ $pembayaran->has('rutin_2') ? ($pembayaran['rutin_2']?->first()->piutang->first()->source == 'gaji' ? 'Gaji' : 'TPP/KUM') : '-' }}</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="column">POKOK</div>
                                                </td>
                                                <td>
                                                    <div class="column">{{ $pembayaran->has('rutin_2') ? formatRupiah($pembayaran['rutin_2']?->first()->jumlah_bayar_pokok) : '-' }}</div>
                                                </td>
                                                <td>
                                                    <div class="column">-</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="column">JASA</div>
                                                </td>
                                                <td>
                                                    <div class="column">{{ $pembayaran->has('rutin_2') ? formatRupiah($pembayaran['rutin_2']?->first()->jumlah_bayar_bunga) : '-' }}</div>
                                                </td>
                                                <td>
                                                    <div class="column">-</div>
                                                </td>
                                            </tr>
                                            {{-- End 2 Row --}}
                                            {{-- Start 2 Row --}}
                                            <tr>
                                                <td colspan="2" style="padding-top: 20px">
                                                    <div class="column"><b>Open Book</b></div>
                                                </td>
                                                <td>
                                                    <div class="column">{{ $pembayaran->has('ob') ? ($pembayaran['ob']?->first()->piutang->first()->source == 'gaji' ? 'Gaji' : 'TPP/KUM') : '-' }}</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="column">POKOK</div>
                                                </td>
                                                <td>
                                                    <div class="column">{{ $pembayaran->has('ob') ? formatRupiah($pembayaran['ob']?->first()->jumlah_bayar_pokok) : '-' }}</div>
                                                </td>
                                                <td>
                                                    <div class="column">-</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="column">JASA</div>
                                                </td>
                                                <td>
                                                    <div class="column">{{ $pembayaran->has('ob') ? formatRupiah($pembayaran['ob']?->first()->jumlah_bayar_bunga) : '-' }}</div>
                                                </td>
                                                <td>
                                                    <div class="column">-</div>
                                                </td>
                                            </tr>
                                            {{-- End 2 Row --}}
                                            {{-- Start 3 Row --}}
                                            <tr>
                                                <td colspan="2" style="padding-top: 20px">
                                                    <div class="column"><b>BARANG</b></div>
                                                </td>
                                                <td>
                                                    <div class="column">{{ $pembayaran->has('barang') ? ($pembayaran['barang']?->first()->piutang->first()->source == 'gaji' ? 'Gaji' : 'TPP/KUM') : '-' }}</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="column">POKOK</div>
                                                </td>
                                                <td>
                                                    <div class="column">{{ $pembayaran->has('barang') ? formatRupiah($pembayaran['barang']?->first()->jumlah_bayar_pokok) : '-' }}</div>
                                                </td>
                                                <td>
                                                    <div class="column">-</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="column">JASA</div>
                                                </td>
                                                <td>
                                                    <div class="column">{{ $pembayaran->has('barang') ? formatRupiah($pembayaran['barang']?->first()->jumlah_bayar_bunga) : '-' }}</div>
                                                </td>
                                                <td>
                                                    <div class="column">-</div>
                                                </td>
                                            </tr>
                                            {{-- End 3 Row --}}
                                            {{-- Start 4 Row --}}
                                            <tr>
                                                <td colspan="2" style="padding-top: 20px">
                                                    <div class="column"><b>KHUSUS</b></div>
                                                </td>
                                                <td>
                                                    <div class="column">{{ $pembayaran->has('khusus') ? ($pembayaran['khusus']?->first()->piutang->first()->source == 'gaji' ? 'Gaji' : 'TPP/KUM') : '-' }}</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="column">POKOK</div>
                                                </td>
                                                <td>
                                                    <div class="column">{{ $pembayaran->has('khusus') ? formatRupiah($pembayaran['khusus']?->first()->piutang->first()->jumlah_hutang ) : '-' }}</div>
                                                </td>
                                                <td>
                                                    <div class="column">-</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="column">JASA</div>
                                                </td>
                                                <td>
                                                    <div class="column">{{ $pembayaran->has('khusus') ? formatRupiah($pembayaran['khusus']?->first()->jumlah_bayar_bunga) : '-' }}</div>
                                                </td>
                                                <td>
                                                    <div class="column">-</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="column">BAYAR KHUSUS</div>
                                                </td>
                                                <td>
                                                    <div class="column">{{ $pembayaran->has('khusus') ? formatRupiah($pembayaran['khusus']?->first()->jumlah_bayar_pokok) : '-' }}</div>
                                                </td>
                                                <td>
                                                    <div class="column">-</div>
                                                </td>
                                            </tr>
                                            {{-- End 4 Row --}}
                                            {{-- Start 5 Row --}}
                                            <tr>
                                                <td colspan="3" style="padding-top: 20px">
                                                    <div class="column"><b>SIMPANAN</b></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="column">POKOK</div>
                                                </td>
                                                <td>
                                                    <div class="column">{{ formatRupiah($payment['main'] ?? 0) }}</div>
                                                </td>
                                                <td>
                                                    <div class="column">-</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="column">WAJIB</div>
                                                </td>
                                                <td>
                                                    <div class="column">{{ formatRupiah($payment['monthly'] ?? 0) }}</div>
                                                </td>
                                                <td>
                                                    <div class="column">-</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="column">HARI RAYA</div>
                                                </td>
                                                <td>
                                                    <div class="column">{{ formatRupiah($payment['other'] ?? 0) }}</div>
                                                </td>
                                                <td>
                                                    <div class="column">-</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="column">PKPRI</div>
                                                </td>
                                                <td>
                                                    <div class="column">{{ formatRupiah(10000) }}</div>
                                                </td>
                                                <td>
                                                    <div class="column">-</div>
                                                </td>
                                            </tr>
                                            {{-- End 5 Row --}}
                                            <tr class="bg-black text-white">
                                                <td class="border-0 font-14 "><b>Jumlah</b></td> <!-- Menambahkan  untuk perataan kanan -->
                                                @php
                                                    $jumlah = 0;
                                                    
                                                    if($pembayaran->has('rutin')){
                                                        $jumlah += ($pembayaran['rutin']?->first()->jumlah_bayar_pokok + $pembayaran['rutin']?->first()->jumlah_bayar_bunga);
                                                    }
                                                    
                                                    if($pembayaran->has('rutin_2')){
                                                        $jumlah += ($pembayaran['rutin_2']?->first()->jumlah_bayar_pokok + $pembayaran['rutin_2']?->first()->jumlah_bayar_bunga);
                                                    }
                                                    
                                                    if($pembayaran->has('ob')){
                                                        $jumlah += ($pembayaran['ob']?->first()->jumlah_bayar_pokok + $pembayaran['ob']?->first()->jumlah_bayar_bunga);
                                                    }

                                                    if($pembayaran->has('barang')){
                                                        $jumlah += ($pembayaran['barang']?->first()->jumlah_bayar_pokok + $pembayaran['barang']?->first()->jumlah_bayar_bunga);
                                                    }

                                                    if($pembayaran->has('khusus')){
                                                        $jumlah += ($pembayaran['khusus']?->first()->jumlah_bayar_bunga + $pembayaran['khusus']?->first()->jumlah_bayar_pokok);
                                                    }

                                                    $jumlah += ($payment['monthly'] ?? 0);
                                                    $jumlah += (($payment['other'] ?? 0) + 10000);

                                                @endphp
                                                <td class="border-0 font-14" colspan="2"><b>{{ formatRupiah($jumlah) }}</b></td> <!-- Menambahkan text-end untuk perataan kanan -->
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 10px">
                            <div class="col-md-12">
                                <table border="0" width="100%">
                                    <tr>
                                        <td style="width: 50%">Mengetahui</td>
                                        <td style="width: 50%">{{ $configs->where('name', 'app_location')->first()->paid_off_amount.','.date('d-m-Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td>Ketua</td>
                                        <td>Bendahara</td>
                                    </tr>
                                    <tr>
                                        <td style="">&nbsp;</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>ttd</td>
                                        <td>ttd</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>{{ $configs->where('name', 'app_ketua')->first()->paid_off_amount }}</td>
                                        <td>{{ $configs->where('name', 'app_bendahara')->first()->paid_off_amount }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="templates/assets/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
