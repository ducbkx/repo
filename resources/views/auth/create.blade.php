@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create User</div>

                <div class="panel-body">
                    <form class="form-horizontal"  method="POST" enctype="multipart/form-data" action="{{ route('users.create') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" >

                                @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('avatar') ? ' has-error' : '' }}">
                            <label for="avatar" class="col-md-4 control-label">Avatar</label>

                            <div class="col-md-6">
                                <input id="avatar" type="file" class="form-control" name="avatar" value="{{ old('avatar') }}">

                                @if ($errors->has('avatar'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('avatar') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="gender" class="col-md-4 control-label">Gender</label>
                            <div class="col-md-6">
                                <select name="gender" class="form-control">
                                    @foreach($genders as $value => $text)
                                    <option value="{!! $value !!}">{!! $text !!}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('birthday') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Birth Day</label>

                            <div class="col-md-6">
                                <input id="birthday" type="date" class="form-control" name="birthday" value="{{ old('birthday') }}">

                                @if ($errors->has('birthday'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('birthday') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">
                            <label for="code" class="col-md-4 control-label">Code</label>

                            <div class="col-md-6">
                                <input id="code" type="text" class="form-control" name="code" value="{{ old('code') }}">

                                @if ($errors->has('code'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('code') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Divition" class="col-md-4 control-label">Divition</label>
                            <div class="col-md-6">
                                <select name="division_id" class="form-control">
                                    @foreach($divisions as $value => $division)
                                    <option value="{!! $value !!}">{!! $division['name'] !!}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="role" class="col-md-4 control-label">Role</label>
                            <div class="col-md-6">
                                <select name="role" class="form-control">
                                    @foreach($roles as $value => $text)
                                    <option value="{!! $value !!}">{!! $text !!}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Create User
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')

<script type="text/javascript">
    $(document).ready(function () {
        $(".form-horizontal").validate({
            rules:
                    {
                        name: {required: true, },
                        email: {required: true,
                            email: true},
                        avatar: {required: true,
                            accept: "image/*"},
                        birthday: {required: true,
                            date: true},
                        code: {required: true, },
                    },
            messages:
                    {
                        name: {required: "Bạn chưa nhập tên", },
                        email: {required: "Bạn chưa nhập email",
                            email: "Bạn nhập không đúng định dạng email"},
                        avatar: {required: "Bạn chưa nhập avatar",
                            accept: "Tệp tải lên phải là ảnh"},
                        birthday: {required: "Bạn chưa nhập ngày sinh",
                            date: "Bạn nhập không đúng định dạng ngày"},
                        code: {required: "Bạn chưa nhập mã nhân viên", },
                    },

        });

    });
</script>
@endsection