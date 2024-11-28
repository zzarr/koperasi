@extends('layout.app')

@section('content')
<div class="container mt-5">
    <h2>History Hutang</h2>
    <div class="table-responsive mb-4">
        <table id="piutangTable" class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jenis Hutang</th>
                    <th>Jumlah Hutang</th>
                    <th>Sisa</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data akan di-load dengan DataTables -->
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('script')
{{-- <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script> --}}
<script>
    $(document).ready(function () {
        $('#piutangTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('user.history-piutang') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'jenis_hutang', name: 'jenis_hutang' },
                { data: 'jumlah_hutang', name: 'jumlah_hutang' },
                { data: 'sisa', name: 'sisa' },
                { data: 'is_lunas', name: 'is_lunas' },
                { data: 'aksi', name: 'aksi', orderable: false, searchable: false }
            ],
            // language: {
            //     url: "//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json"
            // }
        });
    });
</script>
@endpush
