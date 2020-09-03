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
                                <span style="height: 20px; font-size: 14px; justify-items: center" class="badge-primary">{{ $permission->description }}</span>
                            @endforeach
                        </td>
                        <td>
                            {{! $users = \App\User::role($role)->get() }}
                            @foreach ($users as $user)
                                <a href="{{ route('view_staff_detail', ['id'=>$user->id]) }}"><span style="height: 20px; font-size: 14px; justify-items: center" onfocus="cusor" class="badge badge-success">{{ $user->fullname }}</span></a>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
