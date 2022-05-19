@extends('layouts.admin')

@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Chỉnh sửa người dùng
        </div>
        <div class="card-body">
            <form action="{{url('admin/user/update', $user->id)}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Họ và tên</label>
                    <input class="form-control" type="text" name="name" id="name">
                    @error('name')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input value="{{$user->email}}" disabled class="form-control" type="text" name="email" id="email">
                </div>
                <div class="form-group">
                    <label for="password">Mật khẩu</label>
                    <input class="form-control" type="password" name="password" id="password">
                    @error('password')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password-confirm">Xác nhận mật khẩu</label>
                    <input class="form-control" type="password" name="password_confirmation" id="password-confirm">
                    @error('password')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="">Nhóm quyền</label>
                    <select class="form-control" id="">
                        <option>Chọn quyền</option>
                        <option>Danh mục 1</option>
                        <option>Danh mục 2</option>
                        <option>Danh mục 3</option>
                        <option>Danh mục 4</option>
                    </select>
                </div>

                <input type="submit" name="btn-update" value="Cập nhật" class="btn btn-primary">
            </form>
        </div>
    </div>
</div>
@endsection