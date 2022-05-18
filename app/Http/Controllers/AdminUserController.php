<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    function list(Request $request)
    {
        $keyword = "";
        if ($request->input('keyword')) {
            $keyword = $request->input('keyword');
        }
        $status = $request->input('status');
        if ($status == 'trash') {
            $users = User::where('name', 'LIKE', "%{$keyword}%")
                ->onlyTrashed()->orderBy('id')->simplePaginate(5);
        } else {

            $users = User::where('name', 'LIKE', "%{$keyword}%")
                ->orderBy('id')->simplePaginate(5);
        }
        $count_user_active = User::count();
        $count_user_trash = User::onlyTrashed()->count();
        $count = [$count_user_active, $count_user_trash];
        return view('admin.user.list', compact('users', 'count'));
    }
    function add()
    {
        return view('admin.user.add');
    }
    function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',

            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có độ dài ít nhất :min ký tự',
                'max' => ':attributecó độ dài lớn nhất :max ký tự',
                'confirmed' => 'xác nhận mật khẩu không thành công',
                'unique' => ':attribute đã tồn tại',
            ],
            [
                'name' => 'Tên người dùng',
                'email' => 'Email',
                'password' => 'Mật khẩu',
            ]
        );
        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
        return redirect('admin/user/list')->with('status', 'Đã thêm thành viên thành công');
    }
    function delete($id)
    {
        if (Auth::id() != $id) {
            User::find($id)->delete();
            return redirect('admin/user/list')->with('status', 'Đã xóa thành viên thành công');
        } else {
            return  redirect('admin/user/list')->with('status', 'Bạn không thể tự xóa mình ra khỏi hệ thống');
        }
    }
    function action(Request $request)
    {
        $list_check = $request->input('list_check');
        // return $request->input();
        if ($list_check) {
            // Loại bỏ thao tác với chính bản thân
            foreach ($list_check as $k => $id) {
                if (Auth::id() == $id) {
                    // Loại bỏ người đăng nhập ra khỏi mảng 
                    unset($list_check[$k]);
                }
            }

            if (!empty($list_check)) {
                // echo "<pre>";
                // print_r($list_check);
                $act = $request->input('act');
                // echo $act;
                if ($act == 'delete') {
                    User::destroy($list_check);
                    return redirect('admin/user/list')->with('status', 'Bạn đã xóa thành công');
                } else if ($act == 'restore') {
                    User::withTrashed()
                        ->whereIn('id', $list_check)->restore();
                    return redirect('admin/user/list')->with('status', 'Bạn đã khôi phục thành công');
                }
            } else {
                return redirect('admin/user/list')->with('status', 'Bạn không thể thao tác trên tài khoản của bạn');
            }
        } else {
            return redirect('admin/user/list')->with('status', 'Bạn cần chọn phần tử cần thực thi');
        }
    }
}
