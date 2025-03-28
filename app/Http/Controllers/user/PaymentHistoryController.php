<?php

namespace App\Http\Controllers\user;

use App\Models\User;
use App\Models\Role;
use App\Models\Wallet;
use App\Models\YearlyLog;
use App\Models\OtherPayment;
use App\Models\MainPayment;
use App\Models\MonthlyPayment;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentHistoryController extends Controller
{
    public function main() {
        return view('user.history.mainPayment');


    }

    public function mainDatatable(){
        $data = MainPayment::where('user_id', Auth::id())->get()->filter(function ($item) {
            return $item->amount > 0; // Hanya data dengan amount > 0
        });

        return Datatables::of($data)->addIndexColumn() // Tambahkan kolom index secara otomatis
        ->make(true);;
    }

    public function mainPrint()
    {
        $data = MainPayment::with('user')->where('user_id', Auth::user()->id)->get();

        if (!$data) {
            return back()->with('error', 'Data tidak ditemukan!');
        }

        // Generate PDF
        $pdf = Pdf::loadView('admin.payment.main.invoiceAll', compact('data'))
            ->setPaper('a4', 'landscape');

        // Stream PDF ke browser untuk preview
        return $pdf->stream('Invoice_' . $data[0]->id . '.pdf');
    }

    public function monthly() {
        return view('user.history.monthlyPayment');

    }

    public function monthlyDatatable(){
        $data = MonthlyPayment::where('user_id', Auth::user()->id)
        ->get()
        ->filter(function ($item) {
            return $item->amount > 0; // Hanya data dengan amount > 0
        });



        return Datatables::of($data)->make();
    }

    public function monthlyPrint()
    {
        $data = MonthlyPayment::with('user')->where('user_id', Auth::user()->id)->where('paid_at', '!=', null)->get();

        if (!$data) {
            return back()->with('error', 'Data tidak ditemukan!');
        }

        // Generate PDF
        $pdf = Pdf::loadView('admin.payment.monthly.invoiceAll', compact('data'))
            ->setPaper('a4', 'landscape');

        // Stream PDF ke browser untuk preview
        return $pdf->stream('Invoice_' . $data[0]->id . '.pdf');
    }

    public function other() {
        return view('user.history.otherPayment');

    }

    public function otherDatatable(){
        $data = OtherPayment::where('user_id', Auth::user()->id)->get()->filter(function ($item) {
            return $item->amount > 0; // Hanya data dengan amount > 0
        });

        return Datatables::of($data)->make();
    }

    public function otherPrint()
    {
        $data = OtherPayment::with('user')->where('user_id', Auth::user()->id)->where('paid_at', '!=', null)->get();

        if (!$data) {
            return back()->with('error', 'Data tidak ditemukan!');
        }

        // Generate PDF
        $pdf = Pdf::loadView('admin.payment.other.invoiceAll', compact('data'))
            ->setPaper('a4', 'landscape');

        // Stream PDF ke browser untuk preview
        return $pdf->stream('Invoice_' . $data[0]->id . '.pdf');
    }
}
