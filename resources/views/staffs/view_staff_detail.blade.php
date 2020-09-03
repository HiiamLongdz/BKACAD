@extends('layouts.app')

@section('title')
    Chi Tiết Người Dùng - {{ $user->fullname }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="col-sm-8 mx-auto">
                <table class="table table-primary">
                    <tbody>
                        <tr>
                            <th colspan="2"> THÔNG TIN CƠ BẢN </th>
                        </tr>
                        <tr>
                            <th> Ảnh Đại Diện </th>
                            <td><img src="{{ asset($user->avatar) }}" width="128px" alt=""></td>
                        </tr>
                        <tr>
                            <th> Họ Tên </th>
                            <td>{{ $user->fullname }}</td>
                        </tr>
                        <tr>
                            <th> Giới Tính </th>
                            <td>{{ $user->gender ? 'Nam' : 'Nữ' }}</td>
                        </tr>
                        <tr>
                            <th> Ngày Sinh </th>
                            <td>{{ date_format(new DateTime($user->dob), 'd-m-Y') }}</td>
                        </tr>
                        <tr>
                            <th> Số Điện Thoại </th>
                            <td>{{ $user->phone }}</td>
                        </tr>
                        <tr>
                            <th> Email </th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th> Thời Gian Tạo </th>
                            <td>{{ date_format(new DateTime($user->created_at), 'd-m-Y h:m:s') }}</td>
                        </tr>
                        <tr>
                            <th> Cập Nhật Gần Nhất </th>
                            <td>{{ date_format(new DateTime($user->updated_at), 'd-m-Y h:m:s') }}</td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align: center">
                                <a class="btn btn-primary"
                                    href="{{ route('edit_staff_detail', ['id' => $user->id]) }}">Chỉnh
                                    Sửa Thông Tin</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
