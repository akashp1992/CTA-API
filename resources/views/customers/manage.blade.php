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
                        <h3 class="card-label">{{ __('locale.elements.heading_title.customer_manage') }}</h3>
                    </div>
                    <div class="card-toolbar">
                        {!! prepare_header_html('customers', 'manage') !!}
                    </div>
                </div>
                <div class="card-body">
                    <?php
                    $redirect_route = !empty($customer)
                        ? route('customers.update', $customer->id)
                        : route('customers.store');
                    ?>
                    <form action="{{ $redirect_route }}" method="post"
                          enctype="multipart/form-data" class="customer_form" id="customer_form">
                        {{ csrf_field() }}
                        @if(isset($customer) && !empty($customer))
                            <input type="hidden" name="_method" value="put">
                        @endif

                        <input type="hidden" name="id" class="customer_id"
                               value="{{ isset($customer) && isset($customer->id) && $customer->id > 0 ? $customer->id : 0 }}">

                        <input type="hidden" name="slug"
                               value="{{ isset($customer) && !empty($customer->slug) ? $customer->slug : '' }}">

                        <x-hidden-organization-input/>
                        @include('customers.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('page_js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.customer_form').validate({
                ignore: ':hidden',
                errorClass: "invalid",
                rules: {
                    name: 'required',
                    picture: {
                        accept: "image/*"
                    },
                    phone: {
                        required: true,
                        number: true,
                        maxlength: 10,
                        minlength: 8
                    },
                    email: {
                        required: false,
                        email: true
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

            $(document).find('.select2').select2({
                placeholder: 'Please select a value',
                allowClear: true,
                closeOnSelect: false
            });

            $(document).off('click', '.customer_type');
            $(document).on('click', '.customer_type', function () {
                $(document).find('.organization_id_selection').addClass('d-none');
                if($(this).val() === 'admin'){
                    $(document).find('.organization_id_selection').removeClass('d-none');
                }
            });
        });
    </script>
@stop
