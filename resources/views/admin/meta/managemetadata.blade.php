@extends('layout.app')
@section('title', 'Manage Meta Data')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="page-header">
            <div class="page-title">
                <h3>Manage Metadata</h3>
            </div>
            <nav class="breadcrumb-one" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-home">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg></a></li>

                    <li class="breadcrumb-item active" aria-current="page"><span>Manage Metadata</span></li>

                </ol>
            </nav>
        </div>

        <!-- /.content-header -->

        <!-- Main content -->

        <form id="meta" action="{{ route('admin.metadata.manage_metadata.store') }}" method="POST">
            <div class="row" id="cancel-row">
                <div class="col-6 layout-spacing">
                    <div class="widget-content widget-content-area br-6">
                        @csrf
                        <input type="hidden" id="metaId" name="id">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Nama Aplikasi</label>
                                <input type="text" class="form-control" id="app_name" name="app_name"
                                    value="{{ $app->where('name', 'app_app_name')->first()->paid_off_amount ?? '' }}" required>
                            </div>
                            <div class="form-group">
                                <label>Nama Instansi</label>
                                <input type="text" class="form-control" id="instansi" name="instansi"
                                    placeholder="" value="{{ $app->where('name', 'app_instansi')->first()->paid_off_amount ?? '' }}" required>
                            </div>
                            <div class="form-group">
                                <label>Wilayah Titi Mangsa</label>
                                <input type="text" class="form-control" id="location" name="location"
                                    placeholder="" value="{{ $app->where('name', 'app_location')->first()->paid_off_amount ?? '' }}" required>
                            </div>
                            <div class="form-group">
                                <label>Nama Ketua Koperasi</label>
                                <input type="text" class="form-control" id="ketua" name="ketua"
                                    value="{{ $app->where('name', 'app_ketua')->first()->paid_off_amount ?? '' }}" required>
                            </div>
                            <div class="form-group">
                                <label>Nama Bendahara</label>
                                <input type="text" class="form-control" id="bendahara" name="bendahara"
                                    value="{{ $app->where('name', 'app_bendahara')->first()->paid_off_amount ?? '' }}" required>
                            </div>
                        </div>

                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>

                    </div>
                </div>
            
                <div class="col-6 layout-spacing">
                    <div class="widget-content widget-content-area br-6">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Total Angsuran Pokok</label>
                                <input type="text" class="form-control" id="main_payment" name="main_payment"
                                value="{{ $main->paid_off_amount ?? '' }}" required>
                            </div>
                            <div class="form-group">
                                <label>Total Angsuran Wajib ASN</label>
                                <input type="text" class="form-control" id="monthly_payment_asn" name="monthly_payment_asn"
                                placeholder="" value="{{ $monthlyAsn->paid_off_amount ?? '' }}" required>
                            </div>
                            <div class="form-group">
                                <label>Total Angsuran Wajib TU</label>
                                <input type="text" class="form-control" id="monthly_payment_tu" name="monthly_payment_tu"
                                placeholder="" value="{{ $monthlyTu->paid_off_amount ?? '' }}" required>
                            </div>
                            <div class="form-group">
                                <label>Total Angsuran Wajib Non-ASN</label>
                                <input type="text" class="form-control" id="monthly_payment" name="monthly_payment"
                                placeholder="" value="{{ $monthly->paid_off_amount ?? '' }}" required>
                            </div>
                            <div class="form-group">
                                <label>Persentase Jasa Hutang Rutin (%)</label>
                                <input type="text" class="form-control" id="dept_routine" name="dept_routine"
                                value="{{ $routine->paid_off_amount ?? '' }}" required>
                            </div>
                            <div class="form-group">
                                <label>Persentase Jasa Hutang Khusus (%)</label>
                                <input type="text" class="form-control" id="dept_special" name="dept_special"
                                value="{{ $special->paid_off_amount ?? '' }}" required>
                            </div>
                        </div>
                        
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        
                    </div>
                </div>
            </div>
        </form>
            
            <!-- /.content -->
    </div>

    <!-- /.content-wrapper -->
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            var main = $('#main_payment');
            main.on('keyup', function(e) {
                main.val(formatRupiah(main.val(), 'Rp. '));
            });

            var monthly = $('#monthly_payment');
            monthly.on('keyup', function(e) {
                monthly.val(formatRupiah(monthly.val(), 'Rp. '));
            });

            main.val(formatRupiah(main.val(), 'Rp. '))
            monthly.val(formatRupiah(monthly.val(), 'Rp. '))

            $('#card-meta').on('click', '#btn_form_meta', function() {
                let data = new FormData($('#meta')[0])
                $.ajax({
                    url: "{{ route('admin.metadata.manage_metadata.store') }}",
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
