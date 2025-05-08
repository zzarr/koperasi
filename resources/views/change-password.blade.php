@extends('layout.app')
@section('title', 'Ganti Password')

@push('css')
{{-- <link rel="stylesheet" href="/demo2/assets/css/core-dark.css" class="template-customizer-core-css" /> --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
@endpush

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="page-header">
            <div class="page-title">
                <h3>Ganti Password</h3>
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

        <form id="meta" action="{{ route('password.update') }}" method="POST">
            <div class="row" id="cancel-row">
                <div class="offset-3 col-6 layout-spacing">
                    <div class="widget-content widget-content-area br-6">
                        @csrf
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif


                        <div class="">
                            <div class="mb-4 form-password-toggle">
                                <label class="form-label" for="current-password">Password Saat Ini</label>
                                <div class="input-group input-group-merge">
                                  <input type="password" id="current-password" class="form-control" name="current_password" placeholder="********" aria-describedby="password" />
                                  <span class="input-group-text cursor-pointer toggle-password"><i class="ti ti-eye-off"></i></span>
                                </div>
                            </div>
                            <div class="mb-4 form-password-toggle">
                                <label class="form-label" for="password">Password Baru</label>
                                <div class="input-group input-group-merge">
                                  <input type="password" id="password" class="form-control" name="password" placeholder="********" aria-describedby="password" />
                                  <span class="input-group-text cursor-pointer toggle-password"><i class="ti ti-eye-off"></i></span>
                                </div>
                            </div>
                            <div class="mb-4 form-password-toggle">
                                <label class="form-label" for="password-confirmation"> Konfirmasi Password</label>
                                <div class="input-group input-group-merge">
                                  <input type="password" id="password-confirmation" class="form-control" name="password_confirmation" placeholder="********" aria-describedby="password" />
                                  <span class="input-group-text cursor-pointer toggle-password"><i class="ti ti-eye-off"></i></span>
                                </div>
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

@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
      // Ambil semua elemen dengan class 'toggle-password'
      const toggleIcons = document.querySelectorAll('.toggle-password');
    
      toggleIcons.forEach(function (icon) {
        icon.addEventListener('click', function () {
          const input = this.closest('.input-group').querySelector('input');
          const iconElem = this.querySelector('i');
    
          if (input.type === 'password') {
            input.type = 'text';
            iconElem.classList.remove('ti-eye-off');
            iconElem.classList.add('ti-eye');
          } else {
            input.type = 'password';
            iconElem.classList.remove('ti-eye');
            iconElem.classList.add('ti-eye-off');
          }
        });
      });
    });
    </script>
    
@endpush
