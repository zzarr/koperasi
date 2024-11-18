<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class WithdrawController extends Controller
{
    $data['user'] = User::where('role_id', '!=', Roles::where('name', 'admin')->first()->id)->orderBy('name', 'ASC')->get();

    return view('admin.withdraw-request.index', $data);
}
