@extends('layouts.app')

@section('title')
    Điểm Danh Lại
@endsection

@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <form action="{{ route('process_update_attend') }}" method="post">
        <div class="row">
            <div class="col-12">

                @csrf
                <input type="hidden" name="attendance_id" value="{{ $last_att->id }}">
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Chọn Môn</label>
                    <div class="col-sm-8">
                        <select name="subject" class="form-control js-example-basic-disabled">
                            <option value="{{ $subjects->id }}" disabled selected hidden>{{ $subjects->subject_name }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Chọn Lớp</label>
                    <div class="col-sm-8">
                        <select name="class[]" class="form-control js-example-basic-multiple" disabled="true"
                            multiple="multiple">
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}" disabled selected hidden>{{ $class->class_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label">Chọn Ca</label>
                            <div class="col-sm-8">
                                <select name="time" class="form-control js-example-basic-disabled">
                                    @if ($last_att->time_start == '08:00:00' && $last_att->time_end == '10:00:00')
                                        <option value='1'>Ca 1: 08:00:00 - 10:00:00</option>
                                    @endif
                                    @if ($last_att->time_start == '10:00:00' && $last_att->time_end == '10:00:00')
                                        <option value='2'>Ca 2: 08:00:00 - 10:00:00</option>
                                    @endif
                                    @if ($last_att->time_start == '08:00:00' && $last_att->time_end == '12:00:00')
                                        <option value='3'>Ca 1 + 2: 08:00:00 - 12:00:00</option>
                                    @endif
                                    @if ($last_att->time_start == '13:30:00' && $last_att->time_end == '15:30:00')
                                        <option value='4'>Ca 3: 13:30:00 - 15:30:00</option>
                                    @endif
                                    @if ($last_att->time_start == '15:30:00' && $last_att->time_end == '17:30:00')
                                        <option value='5'>Ca 4: 08:00:00 - 12:00:00</option>
                                    @endif
                                    @if ($last_att->time_start == '13:30:00' && $last_att->time_end == '17:30:00')
                                        <option value='6'>Ca 3 + 4: 13:30:00 - 17:30:00</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <table class="table table-content" id="list_student">
                    <thead>
                        <tr>
                            <th>Họ Tên Sinh Viên</th>
                            <th>Tình Trạng Đi Học</th>
                        </tr>
                    </thead>
                    @foreach ($att_details as $key)
                        <thead>
                            <tr>
                                <td>
                                    <span style="font-family: Arial, sans-serif; font-weight: bold; color:
                                    @if ($key->total_abs/$key->total >= $key->total*1/2)
                                        #FF0000
                                    @elseif ($key->total_abs/$key->total >= $key->total*1/4)
                                        #FFFF00
                                    @else
                                        #00FF00
                                        @endif
                                    ">{{ $key->fullname }} ({{ round($key->total_abs, 1) }}/{{ $key->total }})</span>
                                </td>
                                <td>
                                    <input type="radio" name="{{ $key->id }}" value="0" {{ $key->status == 0 ? 'checked' : ''}}> Đi Học
                                    <input type="radio" name="{{ $key->id }}" value="1" {{ $key->status == 1 ? 'checked' : ''}}> Muộn
                                    <input type="radio" name="{{ $key->id }}" value="2" {{ $key->status == 2 ? 'checked' : ''}}> Nghỉ Có Phép
                                    <input type="radio" name="{{ $key->id }}" value="3" {{ $key->status == 3 ? 'checked' : ''}}> Nghỉ Không Phép
                                </td>
                            </tr>
                        </thead>
                    @endforeach
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="form-group row">
                    <div class="col-2 mx-auto">
                        <button type="submit" class="btn btn-primary" id="btn-2">Cập Nhật</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @push('script')
        <script src="{{ asset('assets/js/select2.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('.js-example-basic-disabled').prop('disabled', true);
            });
            $(document).ready(function() {
                $('.js-example-basic-multiple').select2();
            });

        </script>
    @endpush
@endsection
