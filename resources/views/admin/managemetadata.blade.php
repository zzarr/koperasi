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
                <div class="card-body">
                    <form id="meta">
                        <div class="form-group">
                            <label>Total Angsuran Pokok</label>
                            <input type="text" name="main_payment" class="form-control form-control-border" id="main_payment" value="{{$main->paid_off_amount ?? ''}}">
                        </div>
                        <div class="form-group">
                            <label>Total Angsuran Wajib</label>
                            <input type="text" name="monthly_payment" class="form-control form-control-border" id="monthly_payment" placeholder="" value="{{$monthly->paid_off_amount ?? ''}}">
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <button type="button" id="btn_form_meta" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                </div>
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
        var monthly = $('#monthly_payment');
        var isUpdate = false; // Flag untuk cek apakah ini update

        // Format input saat mengetik
        main.on('keyup', function(e){
            main.val(formatRupiah(main.val(), 'Rp. '));
        });

        monthly.on('keyup', function(e){
            monthly.val(formatRupiah(monthly.val(), 'Rp. '));
        });

        // Format data saat halaman load
        main.val(formatRupiah(main.val(), 'Rp. '));
        monthly.val(formatRupiah(monthly.val(), 'Rp. '));

        // Cek apakah data sudah ada
        if(main.val() && monthly.val()) {
            isUpdate = true;
            $('#btn_form_meta').text('Update'); // Ubah tombol menjadi Update
        }

        $('#card-meta').on('click', '#btn_form_meta', function() {
            let data = new FormData($('#meta')[0]);
            let url = '/admin/metadata/update/' + id,
            let method = isUpdate ? 'PUT' : 'POST';

            $.ajax({
                url: url,
                type: method,
                data: data,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#btn_form_meta').attr('disabled', 'disabled');
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

                    // Jika berhasil, ubah tombol jadi "Update"
                    if (!isUpdate) {
                        isUpdate = true;
                        $('#btn_form_meta').text('Update');
                    }
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
