@extends('layouts.app')

@section('title')
    Cập Nhật Quyền Cho Chức Vụ
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <form action="{{ route('update_role_permission') }}" method="post">
                @csrf
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Chức Vụ</label>
                    <div class="col-sm-8">
                        <select name="role" class="form-control js-example-basic-single">
                            <option value="" disabled selected hidden> ---Chọn Chức Vụ--- </option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->description }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Quyền</label>
                    <div class="col-sm-8">
                        <select name="permission[]" multiple="multiple" class="form-control js-example-basic-multiple">
                            <option value="" disabled hidden> ---Chọn Quyền--- </option>
                            @foreach ($permissions as $permission)
                                <option value="{{ $permission->id }}">{{ $permission->description }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-2 mx-auto">
                        <button type="submit" class="btn btn-primary"> Xác Nhận </button>
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
    @endpush
@endsection
