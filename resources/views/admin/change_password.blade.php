@extends('admin.layouts.app')

@section('content')

    <div class="row">
        <!-- left column -->
        <div class="col-md-6" style="margin-top: 100px;margin-left: 386px;">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Change password</h3>
                </div>
                <form method="post" class="form-horizontal" action="{{ route('update.password') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="box-body">
                        <div class="form-group" style="margin-left: 5px;">
                            <label for="exampleInputEmail1">Old pass</label>
                            <input id="oldpass" type="password" class="form-control @error('oldpass') is-invalid @enderror" name="oldpass" value="{{ $oldpass ?? old('oldpass') }}" required autocomplete="oldpass" autofocus style="width: 98%;">
                            @error('oldpass')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group" style="margin-left: 5px;">
                            <label for="exampleInputEmail1">Password</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" style="width: 98%;">
                            @error('oldpass')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group" style="margin-left: 5px;">
                            <label for="exampleInputEmail1">New Password</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" style="width: 98%;">
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection



