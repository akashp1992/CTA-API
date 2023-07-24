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

            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                        <h3 class="card-label">{{ __('locale.elements.heading_title.organization_manage') }}</h3>
                    </div>
                    <div class="card-toolbar">
                        {!! prepare_header_html('organizations', 'manage') !!}
                    </div>
                </div>
                <div class="card-body">
                    <?php
                    $redirect_route = !empty($organization)
                        ? route('organizations.update', $organization->id)
                        : route('organizations.store');
                    ?>
                    <form action="{{ $redirect_route }}" method="post"
                          enctype="multipart/form-data" class="organization_form" id="organization_form">
                        {{ csrf_field() }}
                        @if(isset($organization) && !empty($organization))
                            <input type="hidden" name="_method" value="put">
                        @endif

                        <input type="hidden" name="id" class="organization_id"
                               value="{{ isset($organization) && isset($organization->id) && $organization->id > 0 ? $organization->id : 0 }}">

                        <input type="hidden" name="slug"
                               value="{{ isset($organization) && !empty($organization->slug) ? $organization->slug : '' }}">

                        @include('organizations.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('page_js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.organization_form').validate({
                ignore: ':hidden',
                errorClass: "invalid",
                rules: {
                    name: 'required',
                    identifier: 'required',
                    start_date: 'required',
                    business_type: 'required',
                    business_email: 'required',
                    civil_id_number: 'required',
                    contact_person: 'required',
                    start_time: 'required',
                    end_time: 'required',
                    location: 'required',
                    phone: {
                        required: true,
                        number: true,
                        maxlength: 10,
                        minlength: 8,
                    },
                    email: {
                        required: true,
                        email: true
                    }
                }
            });

            $('.time_picker').timepicker({
                defaultTime: '',
                minuteStep: 30,
                showMeridian: true
            });

            $(document).off('blur', 'input[name="name"]');
            $(document).on('blur', 'input[name="name"]', function () {
                let product_name = $(this).val();
                product_name = product_name.replace(/\s+/g, '-').toLowerCase();
                $(document).find('input[name="identifier"]').val(product_name);
                $(document).find('.organization_identifier').html(product_name);
            });

            $(document).off('blur', 'input[name="identifier"]');
            $(document).on('blur', 'input[name="identifier"]', function () {
                let product_name = $(this).val();
                product_name = product_name.replace(/\s+/g, '-').toLowerCase();
                $(document).find('.organization_identifier').html(product_name);
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

            $('.start_date_picker').datepicker({
                rtl: KTUtil.isRTL(),
                todayHighlight: true,
                orientation: "bottom left",
                templates: arrows,
                // startDate: new Date(),
                autoclose: true
            }).on('changeDate', function (selected) {
                let minDate = new Date(selected.date.valueOf());
                $('.end_date_picker').val('');
                $('.end_date_picker').datepicker('setStartDate', minDate);
            });

            $('.end_date_picker').datepicker({
                rtl: KTUtil.isRTL(),
                todayHighlight: true,
                orientation: "bottom left",
                templates: arrows,
                autoclose: true
            });
        });

        function copyText($_this) {
            navigator.clipboard.writeText($_this.attr('data-href'));
        }
    </script>
@stop
