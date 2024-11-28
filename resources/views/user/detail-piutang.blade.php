@extends('layout.app')

@section('content')
<div class="container mt-5">
    <h2>Detail History Piutang</h2>
    <div class="table-responsive mb-4">
        <table id="detail-table" class="table table-hover">
            <thead>
                <tr>
                    <th>Hutang ID</th>
                    <th>Pembayaran Ke-</th>
                    <th>Jumlah Bayar Pokok</th>
                    <th>Jumlah Bayar Bunga</th>
                    <th>Tanggal Pembayaran</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data akan di-load dengan DataTables -->
            </tbody>
        </table>
    </div>
    <a href="{{ route('user.history-piutang') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection

@push('script')
<script>
    $(document).ready(function () {
        $('#detail-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('user.history-piutang.detail', $piutang->id) }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'pembayaran_ke', name: 'pembayaran_ke' },
                { data: 'jumlah_bayar_pokok', name: 'jumlah_bayar_pokok' },
                { data: 'jumlah_bayar_bunga', name: 'jumlah_bayar_bunga' },
                { data: 'tanggal_pembayaran', name: 'tanggal_pembayaran' }
            ],
            language: {
                url: "//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json"
            }
        });
    });
</script>
@endpush