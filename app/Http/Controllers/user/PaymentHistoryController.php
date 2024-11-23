<?php

namespace App\Http\Controllers\user;

use App\Models\User;
use App\Models\Role;
use App\Models\Wallet;
use App\Models\YearlyLog;
use App\Models\OtherPayment;
use App\Models\MainPayment;
use App\Models\MonthlyPayment;
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
        $data = MainPayment::where('user_id', Auth::id())->get();

        return Datatables::of($data)->addIndexColumn() // Tambahkan kolom index secara otomatis
        ->make(true);;
    }

    public function monthly() {
        
        
    }

    public function monthlyDatatable(){
        $data = MonthlyPayment::where('id_user', Auth::user()->id)->get();

        return Datatables::of($data)->make();
    }

    public function other() {
        
        
    }

    public function otherDatatable(){
        $data = OtherPayment::where('id_user', Auth::user()->id)->get();

        return Datatables::of($data)->make();
    }
}
