@extends('layouts.master')

@section('content')

    <?php $auth_user = auth()->user(); ?>

    <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-1">
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Profile</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column-fluid mt-5">
        <div class="container">
            <div class="d-flex flex-row">
                <div class="flex-row-fluid ml-lg-8">

                    <div class="row">
                        <div class="col-md-12">
                            @if(\Illuminate\Support\Facades\Session::has('notification'))
                                <div class="alert alert-{{\Illuminate\Support\Facades\Session::get('notification.type')}}">
                                    <span><?php echo \Illuminate\Support\Facades\Session::get('notification.message'); ?></span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="card card-custom card-stretch">
                        <div class="card-header py-3">
                            <div class="card-title align-items-start flex-column">
                                <h3 class="card-label font-weight-bolder text-dark">Personal Information</h3>
                                <span class="text-muted font-weight-bold font-size-sm mt-1">Update your personal information</span>
                            </div>
                        </div>

                        <div class="card-body">
                            <?php $user = auth()->user(); ?>
                            <form action="{{ route('users.update', $user->id) }}" method="post"
                                  enctype="multipart/form-data" class="user_form" id="user_form">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="put">
                                <input type="hidden" name="id" class="user_id" value="{{ $user->id }}">
                                <input type="hidden" name="request_from" value="profile">
                                @include('users.form', ['request_from' => 'profile'])
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('page_js')
    <script type="text/javascript">
        $('.user_form').validate({
            ignore: ':hidden',
            errorClass: "invalid",
            rules: {
                institute_id: 'required',
                group_id: 'required',
                name: 'required',
                picture: {
                    accept: "image/*"
                },
                phone: {
                    required: true,
                    number: true,
                    maxlength: 10,
                    minlength: 8,
                    remote: {
                        url: '{{ route('validate.unique') }}',
                        method: 'post',
                        data: {
                            'table': 'users',
                            'field': 'phone',
                            'id': $(document).find('input[name="id"]').val()
                        }
                    }
                },
                email: {
                    required: true,
                    email: true,
                    remote: {
                        url: '{{ route('validate.unique') }}',
                        method: 'post',
                        data: {
                            'table': 'users',
                            'field': 'email',
                            'id': $(document).find('input[name="id"]').val()
                        }
                    }
                }
            },
            messages: {
                phone: {
                    remote: 'The phone has already been taken.'
                },
                email: {
                    remote: 'The email has already been taken.'
                }
            }
        });

        let arrows;
        if (KTUtil.isRTL()) {
            arrows = {
                leftArrow: '<i class="la la-angle-right"></i>',
                rightArrow: '<i class="la la-angle-left"></i>'
            }
        } else {
            arrows = {
                leftArrow: '<i class="la la-angle-left"></i>',
                rightArrow: '<i class="la la-angle-right"></i>'
            }
        }

        $('.date_picker').datepicker({
            rtl: KTUtil.isRTL(),
            todayHighlight: true,
            orientation: "bottom left",
            templates: arrows,
            endDate: new Date()
        });
    </script>
@stop
