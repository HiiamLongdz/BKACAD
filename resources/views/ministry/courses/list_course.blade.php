@extends('layouts.app')

@section('title')
    Xem Các Khóa Đã Thêm
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <table class="table tab-content">
                <tr>
                    <th>Tên Khóa</th>
                    <th>Tên Ngành</th>
                </tr>
                @foreach ($courses as $course)
                    <tr>
                        <td>{{ $course->course_name }}</td>
                        <td>
                            @foreach ($course->majors as $major)
                                <a href="{{ route('list_major') }}"><span style="font-size: 14px" class="badge badge-primary">{{ $major->major_name }}</span></a>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td></td>
                    <td><a href="{{ route('create_course') }}"><button class="btn btn-primary">Thêm Khóa</button></a></td>
                </tr>
            </table>
        </div>
    </div>
@endsection
