<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Withdraw;




class WithdrawController extends Controller
{
    public function index(Request $request)
    {
        $data['user'] = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'admin');
        })->orderBy('name', 'ASC')->get();

        return view('admin.withdraw-request.index', $data);
    }

    public function datatables(Request $request)
    {
        $data = Withdraw::with('user')->get();

        return DataTables::of($data)->make();
    }
}
