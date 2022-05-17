<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    function list()
    {
        $users = User::simplePaginate(5);
        return view('admin.user.list', compact('users'));
    }
}
