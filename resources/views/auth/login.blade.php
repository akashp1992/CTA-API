@extends('guest-layouts.master')

@section('content')
    <div class="login login-3 wizard d-flex flex-column flex-lg-row flex-column-fluid">
        <div class="login-content flex-row-fluid d-flex flex-column p-10">
            <div class="d-flex flex-row-fluid flex-center">
                <div class="card card-custom p-10" style="width: 400px">
                    <div class="card-block">
                        <form method="POST" action="{{ route('login') }}" class="form" id="kt_login_singin_form">
                            @csrf
                            <div class="pb-5 pb-lg-15">
                                <div class="d-flex flex-column-auto flex-column">
                                    @if(!empty($configuration['actual_logo']) && !empty($configuration['name']))
                                        <a href="{{ route('home') }}" class="text-center">
                                            <img
                                                src="{{ config('constants.s3.asset_url') . $configuration['actual_logo'] }}"
                                                alt="{{ $configuration['name'] }}"
                                                style="margin-bottom: 50px!important;max-width: 100%;">
                                        </a>
                                    @endif
                                </div>

                                <h3 class="font-size-h2">Sign In</h3>
                                @if (Route::has('register'))
                                    <div class="text-muted font-weight-bold font-size-h4">New Here?
                                        <a href="{{ route('register') }}"
                                           class="text-primary font-weight-bolder">Create Account</a></div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label class="font-size-h6">{{ __('E-Mail Address') }}</label>
                                <input
                                    class="form-control @error('email') is-invalid @enderror"
                                    type="text" name="email"
                                    autocomplete="off" value="{{ old('email') }}" autofocus/>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="d-flex justify-content-between mt-n5">
                                    <label
                                        class="font-size-h6 pt-5">{{ __('Password') }}</label>
                                </div>

                                <input id="password" type="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       name="password"
                                       autocomplete="current-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="pb-lg-0 pb-5">
                                <button type="submit" id="kt_login_singin_form_submit_button"
                                        class="btn btn-primary font-size-h6 my-3 mr-3">Sign In
                                </button>
                            </div>

                            <div class="form-group mt-5 float-right">
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}"
                                       class="text-primary font-size-h6 text-hover-primary pull-right">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
