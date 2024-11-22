<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Pembayaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .invoice-header {
            text-align: center;
        }
        .invoice-details {
            margin-top: 20px;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
        }
        .details-table th, .details-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
    </style>
</head>
<body>
    <div class="invoice-header">
        <h2>Invoice Pembayaran</h2>
        <p>Koperasi Karyawan</p>
    </div>
    <div class="invoice-details">
        <table>
            <tr>
                <td>Nama</td>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <td>Tanggal Bayar</td>
                <td>{{ $payment->paid_at }}</td>
            </tr>
            <tr>
                <td>Bulan</td>
                <td>{{ $payment->payment_month }}</td>
            </tr>
            <tr>
                <td>Tahun</td>
                <td>{{ $payment->payment_year }}</td>
            </tr>
            <tr>
                <td>Jumlah</td>
                <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>
</body>
</html>
