<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'Koperasi')</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="{{ asset('demo1/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('demo1/assets/css/plugins.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('demo1/assets/css/elements/breadcrumb.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('demo1/assets/css/elements/miscellaneous.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('demo1/assets/css/scrollspyNav.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('demo1/assets/css/plugins.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('demo1/assets/css/structure.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('demo1/assets/css/loader.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('demo1/assets/css/components/custom-modal.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('demo1/plugins/apex/apexcharts.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('demo1/assets/css/dashboard/dash_1.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('dist/css/icons.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/fontawesome-free/css/all.min.css') }}">



    <!-- <link href="{{ asset('demo1/assets/css/elements/alert.css') }}" rel="stylesheet" type="text/css" /> -->


    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    @stack('css')
    <!-- notiflix -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notiflix/dist/notiflix-3.2.6.min.css" />

    <link rel="stylesheet" type="text/css" href="{{ asset('demo1/plugins/table/datatable/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('demo1/plugins/table/datatable/dt-global_style.css') }}">
    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    @include('layout.breadcrumb')
</head>

<body class="alt-menu sidebar-noneoverflow">
    <div id="load_screen">
        <div class="loader">
            <div class="loader-content">
                <div class="spinner-grow align-self-center"></div>
            </div>
        </div>
    </div>

    <!--  BEGIN NAVBAR  -->
    @include('layout.navbar')
    <!--  END NAVBAR  -->

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container sidebar-closed sbar-open" id="container">

        <div class="overlay"></div>
        <div class="cs-overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN SIDEBAR  -->
        @include('layout.sidebar')
        <!--  END SIDEBAR  -->

        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">
                <!-- CONTENT AREA -->
                @yield('content')
                <!-- CONTENT AREA -->

            </div>
        </div>
        <!--  END CONTENT AREA  -->
    </div>
    <!-- END MAIN CONTAINER -->

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="{{ asset('demo1/assets/js/libs/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('demo1/bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('demo1/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('demo1/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('demo1/assets/js/app.js') }}"></script>


    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
    <script src="{{ asset('demo1/assets/js/custom.js') }}"></script>
    <script src="{{ asset('libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('dist/js/app.js') }}"></script>

    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    @stack('js')

    <script src={{ asset('demo1/assets/js/loader.js') }}></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <script src="{{ asset('demo1/plugins/table/datatable/datatables.js') }}"></script>

    <!-- notiflix -->
    <script src="https://cdn.jsdelivr.net/npm/notiflix/dist/notiflix-3.2.6.min.js"></script>

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    <script src="{{ asset('demo1/plugins/apex/apexcharts.min.js') }}"></script>
    <script src="{{ asset('demo1/assets/js/dashboard/dash_1.js') }}"></script>

    <script>
        feather.replace();
    </script>
    <script>
                    function formatRupiah(angka, prefix) {
            let number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? prefix + rupiah : '');
        }
    </script>
    @stack('script')

</body>

</html>
