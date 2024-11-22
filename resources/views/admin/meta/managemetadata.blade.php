@extends('layout.app')
@section('title', 'Manage Meta Data')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Meta Data</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Manage Meta Data</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card" id="card-meta">
                <div class="card-header">
                    <h3 class="card-title">Meta Angsuran</h3>
                </div>
                <form id="meta" action="{{route('admin.metadata.manage_metadata.store')}}" method="POST">
                    @csrf
                    <input type="hidden" id="metaId" name="id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label >Total Angsuran Pokok</label>
                            <input type="text" class="form-control" id="main_payment" name="main_payment" value="{{$main->paid_off_amount ?? ''}}" required>
                        </div>
                        <div class="form-group">
                            <label>Total Angsuran Wajib</label>
                            <input type="text" class="form-control" id="monthly_payment" name="monthly_payment" placeholder="" value="{{$monthly->paid_off_amount ?? ''}}" required>
                        </div>
                        <div class="form-group">
                            <label>Hutang Rutin</label>
                            <input type="text" class="form-control" id="dept_routine" name="dept_routine" value="{{$routine->paid_off_amount ?? ''}}" required>
                        </div>
                        <div class="form-group">
                            <label>Hutang Khusus</label>
                            <input type="text" class="form-control" id="dept_special" name="dept_special" value="{{$special->paid_off_amount ?? ''}}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<!-- /.content-wrapper -->
@endsection

@section('script')
<script>
    $(document).ready(function () {
        var main = $('#main_payment');
        main.on('keyup', function(e){
            main.val(formatRupiah(main.val(), 'Rp. '));
        });

        var monthly = $('#monthly_payment');
        monthly.on('keyup', function(e){
            monthly.val(formatRupiah(monthly.val(), 'Rp. '));
        });

        main.val(formatRupiah(main.val(), 'Rp. '))
        monthly.val(formatRupiah(monthly.val(), 'Rp. '))

        $('#card-meta').on('click', '#btn_form_meta', function() {
            let data = new FormData($('#meta')[0])
            $.ajax({
                url: "{{route('admin.metadata.manage_metadata.store')}}",
                type: 'POST',
                data: data,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#btn_form_meta').attr('disabled', 'disabled')
                    KTApp.block('#card-meta .card', {
                        overlayColor: '#000000',
                        message: 'Please wait...',
                    });
                },
                success: function(data) {
                    KTApp.unblock('#card-meta .card');
                    $('#btn_form_meta').removeAttr('disabled');
                    swal.fire({
                        text: data.message,
                        icon: data.code == 600 ? "warning" : "success"
                    });
                },
                error: function(res, exception) {
                    KTApp.unblock('#card-meta .card');
                    $('#btn_form_meta').removeAttr('disabled');
                    if (res.responseJSON.code) {
                        swal.fire({
                            text: res.responseJSON.error,
                            icon: "warning"
                        });
                    } else {
                        swal.fire({
                            text: "Something Wrong, Please check your connection and try again!",
                            icon: "error"
                        });
                    }
                }
            });
        });
    });
</script>
@endsection
