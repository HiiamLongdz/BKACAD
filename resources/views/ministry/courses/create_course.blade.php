@extends('layouts.app')

@section('title')
    Thêm Khóa Mới
@endsection

@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <div class="row">
        <div class="col-12">
            <form action="{{ route('process_create_course') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="">Tên Khóa</label>
                    <input class="form-control @error('course') is-invalid @enderror" type="text"
                        name="course">
                    @error('course')
                    <div class="alert alert-danger mt-2 mb-1" role="alert">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Thêm Ngành</label>
                    <select name="major[]" class="form-control js-example-basic-multiple" id="" multiple="multiple">
                        @foreach ($majors as $major)
                            <option value="{{ $major->id }}">{{ $major->major_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <div class="col-2 mx-auto">
                        <button class="btn btn-primary" type="submit">Thêm</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @push('script')
        <script src="{{ asset('assets/js/select2.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('.js-example-basic-multiple').select2();
            });
        </script>
    @endpush
@endsection
