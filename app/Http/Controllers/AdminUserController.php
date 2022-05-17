<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    function list()
    {
        // return User::simplePaginate();
        return view('admin.user.list');
    }
}
