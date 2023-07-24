@extends('guest-layouts.master')

@section('content')
    <div class="login login-3 wizard d-flex flex-column flex-lg-row flex-column-fluid">
        <div class="login-content flex-row-fluid d-flex flex-column p-10">
            <div class="d-flex flex-row-fluid flex-center">
                <div class="card card-custom p-10" style="width: 400px">
                    <div class="card-block">
                        <form method="POST" action="{{ route('password.update') }}" class="form"
                              id="kt_login_singin_form">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">
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

                                <h3 class="font-size-h2">{{ __('Reset Password') }}</h3>
                            </div>

                            <div class="form-group">
                                <label class="font-size-h6">{{ __('E-Mail Address') }}</label>
                                <input
                                    class="form-control @error('email') is-invalid @enderror"
                                    type="text" name="email"
                                    autocomplete="off" value="{{ $email ?? old('email') }}"/>

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
                                       autocomplete="current-password" autofocus>

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="d-flex justify-content-between mt-n5">
                                    <label
                                        class="font-size-h6 pt-5">{{ __('Confirm Password') }}</label>
                                </div>

                                <input id="password-confirm" type="password"
                                       class="form-control"
                                       name="password_confirmation"
                                       autocomplete="new-password">
                            </div>

                            <div class="pb-lg-0 pb-5">
                                <button type="submit" id="kt_login_singin_form_submit_button"
                                        class="btn btn-primary font-size-h6 my-3 mr-3">{{ __('Reset Password') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
