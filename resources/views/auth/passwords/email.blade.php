@extends('admin.layouts.authNew')

@section('content')

    <div class="main-content">
        <div class="login-section _left">
            <div class="logo">
                <a href="{{ route('login') }}"><img src="{{ asset('admin/img/image.png') }}" alt="Credit Costs"></a>
            </div>

            <div class="login-form">
                <form action="{{ route('password.email') }}" method="post">
                    @csrf

                    <div class="input-item">
                        <div class="input-content">
                            <div class="svg-content">
                                <i class="fa fa-user"></i>
                            </div>
                            <div class="main-input">
                                <input type="email" name="email" class="form-control" placeholder="Email">
                            </div>
                        </div>
                    </div>
                    @error('email')
                    <p class="text-right text-danger"><span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span></p>
                    @enderror
                    <div class="checkbox icheck">
                    </div>
                    <div class="form-footer">
                        <div class="footer-item">
                            <div class="">
                                <Button class="btn btn-lg btn-primary">Send Password Reset Link</Button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="banner-section _left">
        </div>
    </div>


@endsection
