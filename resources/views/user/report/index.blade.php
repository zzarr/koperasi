@extends('layout.app')

@section('content')
    <div class="page-header">
        <h3>Laporan Invoice Bulanan</h3>
    </div>

    <div class="layout-px-spacing">
        <div class="row analytics">
            @foreach ($invoices as $invoice)
            <div class="col-md-4 col-sm-12 layout-spacing">
                <div class="widget widget-card-two">
                    <div class="widget-content">
                        <div class="card-bottom-section">
                            <h5>Invoice Bulan-</h5>
                            <h3>{{ date('F', mktime(0, 0, 0, $invoice->payment_month, 1)) }}</h3>
                            <form method="POST" action="{{ route('export.invoice-user') }}">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                <input type="hidden" name="month" value="{{ $invoice->payment_month }}">
                                <button class="btn w-100 btn-primary">Cetak Invoice</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

@endsection
