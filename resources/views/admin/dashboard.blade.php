@extends('layout.app')
@section('title', 'Dashboard')
@section('content')
<div class="page-header">
    <h3>DASHBOARD ADMIN</h3>
</div>
<div>
    <div class="layout-px-spacing">
        <div class="row analytics">


            <div class="col-md-4 col-sm-12 layout-spacing">
                <div class="widget widget-card-two">
                    <div class="widget-content">
                        <div class="card-bottom-section">
                            <h3>Rp. {{number_format($simpananPokok)}}</h3>
                            <h5>Total Simpanan Pokok</h5>
                            <a href="javascript:void(0);" class="btn">View Details</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-12 layout-spacing">
                <div class="widget widget-card-two">
                    <div class="widget-content">
                        <div class="card-bottom-section">
                            <h3>Rp. {{number_format($simpananWajib)}}</h3>
                            <h5>Total Simpanan Wajib</h5>
                            <a href="javascript:void(0);" class="btn">View Details</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-12 layout-spacing">
                <div class="widget widget-card-two">
                    <div class="widget-content">
                        <div class="card-bottom-section">
                            <h3>Rp. {{number_format($simpananSukarela)}}</h3>
                            <h5>Total Simpanan Hari Raya</h5>
                            <a href="javascript:void(0);" class="btn">View Details</a>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-4 col-sm-12 layout-spacing">
                <div class="widget widget-card-two">
                    <div class="widget-content">
                        <div class="card-bottom-section">
                            <h3>{{number_format($jumlah_user)}}</h3>
                            <h5>Total Anggota</h5>
                            <a href="javascript:void(0);" class="btn">View Details</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-12 layout-spacing">
                <div class="widget widget-card-two">
                    <div class="widget-content">
                        <div class="card-bottom-section">
                            <h3>{{number_format($hutang_rutin)}}</h3>
                            <h5>Hutang Rutin</h5>
                            <a href="javascript:void(0);" class="btn">View Details</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-12 layout-spacing">
                <div class="widget widget-card-two">
                    <div class="widget-content">
                        <div class="card-bottom-section">
                            <h3>{{number_format($hutang_khusus)}}</h3>
                            <h5>Hutang Khusus</h5>
                            <a href="javascript:void(0);" class="btn">View Details</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!--  END CONTENT AREA  -->
@endsection
