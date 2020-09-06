@extends('layouts.app')

@section('title')
    Điểm Danh
@endsection

@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <form action="{{ route('process_attend') }}" method="post">
        <div class="row">
            <div class="col-12">

                @csrf
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Chọn Môn</label>
                    <div class="col-sm-8">
                        <select name="subject" class="form-control js-example-basic-single">
                            <option value="" disabled selected hidden> ---Chọn Môn--- </option>
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->subject_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Chọn Lớp</label>
                    <div class="col-sm-8">
                        <select name="class[]" class="form-control js-example-basic-multiple" multiple="multiple">
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label">Chọn Ca</label>
                            <div class="col-sm-8">
                                <select name="time" class="form-control js-example-basic-single js-example-disabled">
                                    <option value="" selected hidden disabled>---Chọn Ca---</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2 mx-auto">
                        <a href="javascript:void(0);" id="btn-1" class="btn btn-primary">Xác Nhận</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <table class="table table-content d-none" id="list_student">
                    <thead>
                        <tr>
                            <th>Họ Tên Sinh Viên</th>
                            <th>Tình Trạng Đi Học</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="form-group row">
                    <div class="col-2 mx-auto">
                        <button type="submit" class="btn btn-primary d-none" id="btn-2">Điểm Danh</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
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
        <script>
            var url = "{{ route('show_class') }}";
            $("select[name='subject']").change(function() {
                var subject_id = $(this).val();
                var token = $("input[name='_token']").val();
                console.log(subject_id);
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        subject_id: subject_id,
                        _token: token
                    },
                    success: function(data) {
                        $("select[name='class[]']").html('');
                        $.each(data, function(key, value) {
                            $("select[name='class[]']").append("<option value=" + value.id + ">" +
                                value.class_name + "</option>");
                        });
                    }
                });
            });

        </script>
        <script>
            $("#btn-1").click(function(e) {
                e.preventDefault();
                $("#list_student").removeClass("d-none");
                $("#btn-2").removeClass("d-none");
                callAjax();
            });

            function callAjax() {
                var url = "{{ route('get_list_student_attendance') }}";
                var class_id = $("select[name='class[]']").val();
                var token = $("input[name='_token']").val();
                console.log(class_id);
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        class_id: class_id,
                        _token: token
                    },
                    success: function(data) {
                        // $("#list_student").html('');
                        $.each(data, function(key, value) {
                            $("#list_student").append("<thead><tr><td>" + value.fullname +
                                "</td><td><input type='radio' name='" + value.id +
                                "' value='0' checked='checked' > Đi học  <input type='radio' name='" +
                                value.id + "' value='1'> Muộn   <input type='radio' name='" + value.id +
                                "' value='2'> Nghỉ Có Phép    <input type='radio' name='" + value.id +
                                "' value='2'> Nghỉ Không Phép</td></tr></thead>"
                            );
                        });
                    }
                });
            }

        </script>
        <script>
            var time = new Date().toTimeString();
            if (time < '10:15:00') {
                $("select[name='time']").append(
                    "<option value='1'>Ca 1: 08:00:00 - 10:00:00</option><option value='3'>Ca 1 + 2: 08:00:00 - 12:00:00</option>"
                );
            } else
            if (time < '12:15:00') {
                $("select[name='time']").append(
                    "<option value='2'>Ca 1: 10:00:00 - 12:00:00</option><option value='3'>Ca 1 + 2: 08:00:00 - 12:00:00</option>"
                );
            } else
            if (time < '15:45:00') {
                $("select[name='time']").append(
                    "<option value='4'>Ca 3: 13:30:00 - 15:30:00</option><option value='6'>Ca 3 + 4: 13:30:00 - 17:30:00</option>"
                );
            } else
            if (time < '17:45:00') {
                $("select[name='time']").append(
                    "<option value='5'>Ca 3: 15:30:00 - 17:30:00</option><option value='6'>Ca 3 + 4: 13:30:00 - 17:30:00</option>"
                );
            } else {
                $(document).ready(function() {
                    $("select[name='time']").append(
                        "<option selected hidden disabled>Không phải thời gian điểm danh</option>")
                    $('.js-example-disabled').prop('disabled', true);
                });
            }

        </script>
    @endpush
@endsection
