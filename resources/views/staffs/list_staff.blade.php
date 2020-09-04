@extends('layouts.app')

@section('title')
    Danh sách nhân viên
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <table class="table tab-content">
                <tr>
                    <th scope="col">Họ Tên Nhân Viên</th>
                    <th scope="col">Email</th>
                    <th scope="col">Số Điện Thoại</th>
                    <th scope="col">Chức Vụ</th>
                    <th scope="col">Quyền</th>
                    <th scope="col">Chỉnh Sửa</th>
                </tr>
                @foreach ($users as $key => $user)
                    <tr>
                        <td>{{ $user->fullname }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>
                            {{! $roles = $user->roles }}
                            @foreach ($roles as $role)
                                <span style="font-size: 14px" class="bagde badge-primary">{{ $role->description }}</span>
                            @endforeach
                        </td>
                        <td>
                            {{! $permissions = $user->getAllPermissions() }}
                            @foreach ($permissions as $permission)
                                <span style="font-size: 14px" class="badge badge-primary">{{ $permission->description }}</span>
                            @endforeach
                        </td>
                        <td>
                            <a class="btn btn-info" href="{{ route('view_staff_detail', ['id'=>$user->id]) }}">Xem Thông Tin</a>
                            <a class="btn btn-primary" href="{{ route('edit_staff_detail', ['id'=>$user->id]) }}">Chỉnh Sửa</a>
                            <a class="btn btn-danger" href="{{ route('delete_staff', ['id'=>$user->id]) }}">Xóa</a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
    <div class="row float-right">
        <div class="col-12">
            {{ $users->links() }}
        </div>
    </div>
@endsection
