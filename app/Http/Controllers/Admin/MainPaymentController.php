<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Roles;
use App\Models\Wallet;
use App\Models\YearlyLog;
use App\Models\MainPayment;
use Illuminate\Http\Request;
use App\Models\ConfigPayment;
use Yajra\DataTables\Facades\DataTables;
use App\Imports\MainPaymentImport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class MainPaymentController extends Controller
{
    private $isSuccess;
    private $exception;

    public function __construct()
    {
        $this->isSuccess = false;
        $this->exception = null;
    }
    public function index(Request $request)
    {
        return view('admin.payment.main.index');
    }

    public function datatables()
    {
        // Ambil semua user yang memiliki role 'user'
            $user = User::with(['mainPayment.configPayment', 'roles'])
                ->role('user') // Filter user dengan role 'user' (fitur dari Spatie)
                ->get();
        return DataTables::of($user)->make();
    }
}
