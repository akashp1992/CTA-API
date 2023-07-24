@extends('layouts.master')

@section('content')

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @if(\Illuminate\Support\Facades\Session::has('notification'))
                        <div class="alert alert-{{\Illuminate\Support\Facades\Session::get('notification.type')}}">
                            <span><?php echo \Illuminate\Support\Facades\Session::get('notification.message'); ?></span>
                        </div>
                    @endif
                </div>
            </div>

            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                        <h3 class="card-label">Change Password</h3>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('update_password') }}" method="post"
                          class="update_password_form" id="update_password_form">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" class="user_id"
                               value="{{ auth()->check() ? auth()->user()->id : 0 }}">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label" for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                           value="{{ auth()->check() ? auth()->user()->email : '' }}"
                                           disabled="disabled">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label" for="old_password">Old Password</label>
                                    <input type="password" class="form-control" id="old_password"
                                           name="old_password" value="">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label" for="password">Password</label>
                                    <input type="password" class="form-control" id="password"
                                           name="password" value="">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label" for="confirm_password">Confirm
                                        Password</label>
                                    <input type="password" class="form-control" id="confirm_password"
                                           name="confirm_password" value="">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary update_password_button">
                                        Update Password
                                    </button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('page_js')
    <script type="text/javascript">
			$(document).off('click', '.update_password_button');
			$(document).on('click', '.update_password_button', function () {
				swal({
					title: "Are you sure?",
					text: "Once updated, you will be redirect to the login screen!",
					icon: "warning",
					buttons: true,
					dangerMode: true,
				})
					.then((will_delete) => {
						if (will_delete) {
							$(document).find('.update_password_form').submit();
						}
					});
			});
    </script>
@stop
