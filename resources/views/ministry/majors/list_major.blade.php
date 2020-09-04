@extends('layouts.app')

@section('title')
    Xem Các Ngành Đã Thêm
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <table class="table tab-content">
                <tr>
                    <th>Mã Ngành</th>
                    <th>Tên Ngành</th>
                    <th>Môn Học</th>
                </tr>
                @foreach ($majors as $major)
                    <tr>
                        <td>{{ $major->id }}</td>
                        <td>{{ $major->major_name }}</td>
                        <td>
                            @foreach ($major->subjects as $subject)
                                <span style="font-size: 14px" class="badge badge-primary">{{ $subject->subject_name }}</span>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td></td>
                    <td><a href="{{ route('create_major') }}"><button class="btn btn-primary">Thêm Ngành</button></a></td>
                </tr>
            </table>
        </div>
    </div>
@endsection
