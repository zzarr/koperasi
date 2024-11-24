@extends('layout.app')

@section('content')
<div class="container mt-5">
    <h2>History Piutang</h2>

    <!-- Tabel daftar piutang -->
    <div class="table-responsive mb-5">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>no</th>
                    <th>Jenis Piutang</th>
                    <th>Jumlah Piutang</th>
                    <th>Sisa</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($piutangs as $key => $piutang)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ ucfirst($piutang->jenis_hutang) }}</td>
                    <td>Rp {{ number_format($piutang->jumlah_hutang, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($piutang->sisa, 0, ',', '.') }}</td>
                    <td>{{ $piutang->is_lunas ? 'Lunas' : 'Belum Lunas' }}</td>
                    <td>
                        <a href="{{ route('user.history-piutang', $piutang->id) }}" class="btn btn-info btn-sm">
                            Detail Pembayaran
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Detail pembayaran jika ada -->
    @if ($detailPiutang)
    <div class="card">
        <div class="card-body">
            <h4>Detail Piutang</h4>
            <p><strong>Jenis Piutang:</strong> {{ ucfirst($detailPiutang->jenis_hutang) }}</p>
            <p><strong>Jumlah Piutang:</strong> Rp {{ number_format($detailPiutang->jumlah_hutang, 0, ',', '.') }}</p>
            <p><strong>Sisa:</strong> Rp {{ number_format($detailPiutang->sisa, 0, ',', '.') }}</p>
            <p><strong>Status:</strong> {{ $detailPiutang->is_lunas ? 'Lunas' : 'Belum Lunas' }}</p>
        </div>
    </div>

    <div class="table-responsive mt-4">
        <h5>Riwayat Pembayaran</h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Pembayaran Ke-</th>
                    <th>Jumlah Bayar Pokok</th>
                    <th>Jumlah Bayar Bunga</th>
                    <th>Tanggal Pembayaran</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pembayarans as $key => $pembayaran)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $pembayaran->{'pembayaran ke-'} }}</td>
                    <td>Rp {{ number_format($pembayaran->jumlah_bayar_pokok, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($pembayaran->jumlah_bayar_bunga, 0, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($pembayaran->tanggal_pembayaran)->format('d M Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <a href="{{ route('user.history-piutang') }}" class="btn btn-secondary mt-3">Kembali</a>
    @endif
</div>
@endsection
