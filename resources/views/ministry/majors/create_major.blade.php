@extends('layouts.app')

@section('title')
    Thêm Ngành Mới
@endsection

@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <div class="row">
        <div class="col-6 mx-auto">
            <form action="{{ route('process_create_major') }}" method="post">
                @csrf
                <div class="form-group">
                    <label>Mã Ngành</label>
                    <input type="text" class="form-control @error('fullname') is-invalid @enderror" name="major_id" />
                    @error('major_id')
                    <div class="alert alert-danger mt-2 mb-1" role="alert">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Tên Ngành</label>
                    <input class="form-control @error('major_id') is-invalid @enderror" type="text"
                        name="major_name">
                    @error('major_name')
                    <div class="alert alert-danger mt-2 mb-1" role="alert">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Thêm Môn</label>
                    <select name="subject[]" class="form-control js-example-basic-multiple" id="" multiple="multiple">
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->subject_name }}</option>
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
