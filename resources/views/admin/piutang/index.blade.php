@extends('layout.app')
@section('content')
<div class="page-header">
    <div class="page-title">
        <h3>Manajemen Pembayaran Piutang</h3>
    </div>

    <nav class="breadcrumb-one" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a></li>
            <!-- <li class="breadcrumb-item"><a href="javascript:void(0);">Starter Kits</a></li> -->
            <li class="breadcrumb-item active" aria-current="page"><span>Manajemen Pembayaran Piutang</span></li>
        </ol>
    </nav>
</div>


<div class="row" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <div class="table-responsive mb-4 mt-4">
                <table id="datatable" id="zero-config" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Nominal</th>
                           
                            <th class="no-content">Action</th>

                        </tr>
                    </thead>
                    <tbody>

                        <td>1</td>
                        <td>Admin Satu</td>
                        <td>Rp.200.000,00</td>
                       
                        <td>
                            <button type="button">Edit</button>
                            <button type="button">Delete</button>
                        </td>
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>


@endsection
