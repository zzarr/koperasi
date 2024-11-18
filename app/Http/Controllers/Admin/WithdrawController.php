<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;

use Spatie\Permission\Models\Role;



class WithdrawController extends Controller
{
    public function index(Request $request)
    {
        $data['user'] = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'admin');
        })->orderBy('name', 'ASC')->get();

        return view('admin.withdraw-request.index', $data);
    }
}
