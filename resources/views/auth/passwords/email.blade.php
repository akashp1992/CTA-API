@extends('guest-layouts.master')

@section('content')
    <div class="login login-3 wizard d-flex flex-column flex-lg-row flex-column-fluid">
        <div class="login-content flex-column-fluid d-flex flex-column p-10">
            <div class="d-flex flex-row-fluid flex-center">
                <div class="card card-custom p-10" style="width: 400px">
                    <div class="card-block">
                        <form method="POST" action="{{ route('password.email') }}" class="form"
                              id="kt_login_forgot_form">
                            @csrf

                            @if (session('status'))
                                <div class="alert alert-success mb-5 mb-lg-15" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

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

                                <h3 class="font-size-h3">Forgotten Password ?</h3>
                                <p class="text-muted font-size-h6">Enter your email to reset your
                                    password</p>
                            </div>

                            <div class="form-group">
                                <input id="email" type="email"
                                       class="form-control font-size-h6 @error('email') is-invalid @enderror"
                                       placeholder="{{ __('E-Mail Address') }}" name="email" autocomplete="email"
                                       autofocus/>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group d-flex flex-wrap">
                                <button type="submit" id="kt_login_forgot_form_submit_button"
                                        class="btn btn-primary font-size-h6 my-3 mr-3">{{ __('Send Password Reset Link') }}
                                </button>
                                <a href="{{ route('login') }}" id="kt_login_forgot_cancel"
                                   class="btn btn-light-primary font-size-h6 my-3">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
