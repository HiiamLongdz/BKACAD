@extends('layouts.app')

@section('title')
    Phân Công
@endsection

@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <div class="row">
        <div class="col-12">
            <form action="{{ route('process_assign') }}" method="post" class="mx-auto" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Chọn Khóa</label>
                    <div class="col-sm-8">
                        <select name="course" class="form-control">
                            <option value="" disabled selected hidden> ---Chọn Khóa--- </option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->course_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Chọn Ngành</label>
                    <div class="col-sm-8">
                        <select name="major" class="form-control">
                            <option value="" disabled selected hidden> ---Chọn Ngành--- </option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Chọn Môn</label>
                    <div class="col-sm-8">
                        <select name="subject" class="form-control">
                            <option value="" disabled selected hidden> ---Chọn Môn--- </option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Chọn Giảng Viên</label>
                    <div class="col-sm-8">
                        <select name="lecturer" class="form-control js-example-basic-single">
                            <option value="" disabled selected hidden> ---Chọn Giảng Viên--- </option>
                            @foreach ($lecturers as $item)
                                <option value="{{ $item->id }}">{{ $item->fullname }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Chọn Lớp</label>
                    <div class="col-sm-8">
                        <select name="class[]" id="" class="form-control js-example-basic-multiple" multiple="multiple">

                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-8">
                        <button type="submit" class="btn btn-primary">Phân Công Cho Giảng Viên Này</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @push('script')
        <script src="{{ asset('assets/js/select2.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('.js-example-basic-single').select2();
            });
            $(document).ready(function() {
                $('.js-example-basic-multiple').select2();
            });
        </script>
        <script type="text/javascript">
            var url = "{{ route('show_course_major') }}";
            $("select[name='course']").change(function() {
                var course_id = $(this).val();
                var token = $("input[name='_token']").val();
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        course_id: course_id,
                        _token: token
                    },
                    success: function(data) {
                        $("select[name='major'").html('');
                        $("select[name='major']").append(
                            "<option hidden selected>---Chọn Ngành---</option>");
                        $.each(data, function(key, value) {
                            $("select[name='major']").append(
                                "<option value=" + value.id + ">" + value.major_name +
                                "</option>"
                            );
                        });

                        var url = "{{ route('show_subject_major') }}";
                        $("select[name='major']").change(function() {
                            var major_id = $(this).val();
                            var token = $("input[name='_token']").val();
                            $.ajax({
                                url: url,
                                method: 'POST',
                                data: {
                                    major_id: major_id,
                                    _token: token
                                },
                                success: function(data) {
                                    $("select[name='subject'").html('');
                                    $("select[name='subject']").append(
                                        "<option hidden selected>---Chọn Môn---</option>"
                                    );

                                    $.each(data, function(key, value) {
                                        $("select[name='subject']").append(
                                            "<option value=" + value.id +
                                            ">" + value.subject_name +
                                            "</option>"
                                        );
                                    });
                                }
                            });

                            $.ajax({
                                url: "{{ route('show_course_major_class') }}",
                                method: 'POST',
                                data: {
                                    course_id: course_id,
                                    major_id: major_id,
                                    _token: token
                                },
                                success: function(data) {
                                    $("select[name='class[]'").html('');
                                    $.each(data, function(key, value) {
                                        $("select[name='class[]']").append(
                                            "<option value=" + value.id +
                                            ">" + value.class_name +
                                            "</option>"
                                        );
                                    });
                                }
                            });

                        });
                    }
                });
            });

        </script>
    @endpush
@endsection
