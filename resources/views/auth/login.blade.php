@extends('admin.layouts.authNew')

@section('content')

    <div class="main-content">
        <div class="login-section _left">
            <div class="logo">
                <a href="{{ route('login') }}"><img src="{{ asset('admin/img/image.png') }}" alt="Credit Costs"></a>
            </div>

            <div class="login-form">
                <form action="{{ route('login') }}" method="post">
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

                    <div class="input-item">
                        <div class="input-content">
                            <div class="svg-content">
                                <i style="font-size: 18px;" class="fa fa-key"></i>
                            </div>
                            <div class="main-input">
                                <input autocomplete="new-password-new-123a@#$#" class="form-control" name="password" type="password" placeholder="Password">
                            </div>
                            {{--<span class="shw-pwd"><i class="fa fa-eye"></i></span>--}}
                        </div>
                    </div>
                    @error('password')
                    <p class="text-right text-danger"><span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span></p>
                    @enderror

                    <div class="checkbox icheck">
                        <label for="remember">
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                        </label>
                    </div>

                    <div class="form-footer">
                        <div class="footer-item">
                            <div class="forget-password _left">
                                <a href="{{ route('password.request') }}">Forget Password?</a>
                            </div>

                            <div class="login-btn _left">
                                <Button class="btn btn-lg btn-primary">Sign In</Button>
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


