@extends('layouts.app')

@section('title')
    Chi Tiết Phân Công
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <table class="table tab-content" id="assignment_table">
                <thead>
                    <tr>
                        <th>Tên Lớp</th>
                        <th>Tên Môn</th>
                        <th>Tên Giảng Viên</th>
                        <th>Tình Trạng</th>
                        <th>Chỉnh Sửa</th>
                    </tr>
                </thead>
                @foreach ($assignments as $assignment)
                    <thead>
                        <tr>
                            <td>{{ $assignment->class_name }}</td>
                            <td>{{ $assignment->subject_name }}</td>
                            <td>{{ $assignment->fullname }}</td>
                            <td>{{ $assignment->status ? 'Đã Hoàn Thành' : 'Đang Dạy' }}</td>
                            <td>
                                <a href="#" class="btn btn-primary">Chỉnh Sửa</a>
                            </td>
                        </tr>
                    </thead>
                @endforeach
            </table>
        </div>
    </div>
@endsection
