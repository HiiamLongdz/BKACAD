@extends('layouts.app')

@section('title')
    Danh Sách Nhân Viên
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <table class="table tab-navigation">
                <tr>
                    <th>Chức Vụ</th>
                    <th>Quyền Chức Vụ</th>
                    <th>Người Dùng</th>
                </tr>
                @foreach ($roles as $role)
                    <tr>
                        <td>{{ $role->description }}</td>
                        <td>
                            @foreach ($role->permissions as $permission)
                                <span style="font-size: 14px; justify-items: center" class="badge-primary">{{ $permission->description }}</span>
                            @endforeach
                            <a class="badge badge-primary" href="{{ route('edit_permission_to_role', ['id' => $role->id]) }}"><i size="20px" class="ion-ios-add-circle"></i></a>
                        </td>
                        <td>
                            {{! $users = \App\User::role($role)->get() }}
                            @foreach ($users as $user)
                                <a href="{{ route('view_staff_detail', ['id'=>$user->id]) }}" class="badge badge-primary" style="font-size: 14px">{{ $user->fullname }}</a>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
