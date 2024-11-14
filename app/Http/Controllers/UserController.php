<?php

namespace App\Http\Controllers;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use HasRoles;
}
