<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

use App\Models\User;
use App\Models\MonthlyPayment;



class MonthlyPaymentController extends Controller
{

    public function index(Request $request)
    {
        return view('admin.payment.monthly.index');
    }
    public function datatables(Request $request)
    {
        $year = date('Y');

        $users = User::with([
            'monthlyPayment' => function ($query) use ($year) {
                $query->where('payment_year', $year)
                    ->orderBy('payment_month', 'ASC');
            },
            'monthlyPayment.configPayment'
        ])
            ->whereDoesntHave('roles', function ($query) {
                $query->where('name', 'admin'); // Exclude admin roles
            })
            ->get();

        return DataTables::of($users)
            ->addColumn('monthly_total', function ($user) use ($year) {
                return $user->monthlyPayment->where('payment_year', $year)->sum('amount') ?? 0;
            })
            ->addColumn('last_year_1', function ($user) {
                return MonthlyPayment::where('payment_year', (date('Y') - 1))->where('user_id', $user->id)->sum('amount') ?? 0;
            })
            ->addColumn('last_year_2', function ($user) {
                return MonthlyPayment::where('payment_year', (date('Y') - 2))->where('user_id', $user->id)->sum('amount') ?? 0;
            })
            ->addColumn('last_year_3', function ($user) {
                return MonthlyPayment::where('payment_year', '<=', (date('Y') - 3))->where('user_id', $user->id)->sum('amount') ?? 0;
            })
            ->addColumn('total_all', function ($user) {
                return $user->monthlyPayment->sum('amount') ?? 0;
            })
            ->make();
    }
}
