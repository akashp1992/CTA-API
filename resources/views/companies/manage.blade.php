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
                        <h3 class="card-label">{{ __('locale.elements.heading_title.company_manage') }}</h3>
                    </div>
                    <div class="card-toolbar">
                        {!! prepare_header_html('companies', 'manage') !!}
                    </div>
                </div>
                <div class="card-body">
                    <?php
                    $redirect_route = !empty($company)
                        ? route('companies.update', $company->id)
                        : route('companies.store');
                    ?>
                    <form action="{{ $redirect_route }}" method="post"
                          enctype="multipart/form-data" class="company_form" id="company_form">
                        {{ csrf_field() }}
                        @if(isset($company) && !empty($company))
                            <input type="hidden" name="_method" value="put">
                        @endif

                        <input type="hidden" name="id" class="company_id"
                               value="{{ isset($company) && isset($company->id) && $company->id > 0 ? $company->id : 0 }}">

                        <input type="hidden" name="slug"
                               value="{{ isset($company) && !empty($company->slug) ? $company->slug : '' }}">

                        <x-hidden-organization-input/>
                        @include('companies.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('page_js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.company_form').validate({
                ignore: ':hidden',
                errorClass: "invalid",
                rules: {
                    name: 'required',
                    arabic_name: 'required',
                    phone: {
                        required: true,
                        number: true,
                        maxlength: 10,
                        minlength: 8,
                        remote: {
                            url: '{{ route('validate.unique') }}',
                            method: 'post',
                            data: {
                                'table': 'companies',
                                'field': 'phone',
                                'id': $(document).find('input[name="id"]').val()
                            }
                        }
                    },
                    prefix: {
                        required: true,
                        maxlength: 4,
                        remote: {
                            url: '{{ route('validate.unique') }}',
                            method: 'post',
                            data: {
                                'table': 'companies',
                                'field': 'prefix',
                                'id': $(document).find('input[name="id"]').val()
                            }
                        }
                    },
                    email: {
                        required: false,
                        email: true,
                        remote: {
                            url: '{{ route('validate.unique') }}',
                            method: 'post',
                            data: {
                                'table': 'companies',
                                'field': 'email',
                                'id': $(document).find('input[name="id"]').val()
                            }
                        }
                    },
                    contact_name: 'required',
                    contact_phone: {
                        required: true,
                        number: true,
                        maxlength: 10,
                        minlength: 8
                    },
                    contact_email: {
                        required: false,
                        email: true
                    }
                },
                messages: {
                    phone: {
                        remote: 'The phone has already been taken.'
                    },
                    email: {
                        remote: 'The email has already been taken.'
                    },
                    prefix: {
                        remote: 'The prefix has already been taken.'
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
        });
    </script>
@stop
