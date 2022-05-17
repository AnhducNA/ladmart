<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    function list(Request $request)
    {
        $keyword = "";
        if ($request->input('keyword')) {
            $keyword = $request->input('keyword');
        }
        $users = User::where('name' , 'LIKE', "%{$keyword}%")
        ->simplePaginate(5);
        return view('admin.user.list', compact('users'));
    }
}
