@extends('layouts.app')

@section('title')
    Danh Sách Sinh Viên
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="form-group row">
                <label for="" class="col-sm-2 col-form-label">Chọn Khóa</label>
                <div class="col-sm-8">
                    <select name="course" id="" class="form-control">
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
                    <select name="major" id="" class="form-control">
                        <option value="" disabled selected hidden> ---Chọn Ngành--- </option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-sm-2 col-form-label">Chọn Lớp</label>
                <div class="col-sm-8">
                    <select name="class" id="" class="form-control">
                        <option value="" disabled selected hidden> ---Chọn Lớp--- </option>
                    </select>
                </div>
            </div>
            <div class="col-2 mx-auto">
                <button class="btn btn-primary">Xác Nhận</button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <table class="table table-bordered datatable d-none" id="list_student">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @push('script')
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
                            "<option selected hidden>" + "---Chọn Ngành---" +
                            "</option>"
                        );
                        $.each(data, function(key, value) {
                            $("select[name='major']").append(
                                "<option value=" + value.id + ">" + value.major_name +
                                "</option>"
                            );
                        });

                        var url = "{{ route('show_course_major_class') }}";
                        $("select[name='major']").change(function() {

                            var major_id = $(this).val();
                            var token = $("input[name='_token']").val();
                            $.ajax({
                                url: url,
                                method: 'POST',
                                data: {
                                    course_id: course_id,
                                    major_id: major_id,
                                    _token: token
                                },
                                success: function(data) {
                                    $("select[name='class'").html('');
                                    $("select[name='class']").append(
                                        "<option selected hidden>" +
                                        "---Chọn Lớp---" +
                                        "</option>"
                                    );
                                    $.each(data, function(key, value) {
                                        $("select[name='class']").append(
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

            $("button").click(function(e) {
                e.preventDefault();
                $("#list_student").removeClass("d-none");
                callAjax();
            });

            function callAjax() {
                $('#list_student').DataTable({
                    processing: true,
                    destroy: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('get_list_student') }}",
                        type: "GET",
                        data: function(d) {
                            d.classes_id = $("select[name='class']").val();
                        }
                    },

                    columns: [{
                            data: 'id',
                            name: 'id'
                        },
                        {
                            data: 'fullname',
                            name: 'fullname'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            data: 'updated_at',
                            name: 'updated_at'
                        }
                    ],
                    initComplete: function() {

                    }
                });
            }

        </script>
    @endpush
@endsection
