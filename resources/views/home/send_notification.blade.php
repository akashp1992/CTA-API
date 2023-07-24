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

            <div class="row mb-5">
                <div class="col-md-12">
                    <div class="card card-custom">
                        <div class="card-header flex-wrap py-3">
                            <div class="card-title">
                                <h3 class="card-label">Send Notification</h3>
                            </div>
                            <div class="card-toolbar">
                                <a href="{{ route('notification.scheduled') }}" class="btn btn-outline-primary">
                                    Notification Scheduled
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('notification.send.post') }}" method="post"
                                  enctype="multipart/form-data" class="notification_form" id="notification_form">
                                {{ csrf_field() }}

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label" for="customer_type">Customer Type</label><br>
                                            <div class="radio-inline">
                                                @foreach(config('constants.CUSTOMER_TYPES') as $key => $customer_type)
                                                    <label class="radio">
                                                        <input type="radio" name="customer_type"
                                                               value="{{ $customer_type }}"{{ $key == 0 ? 'checked="checked"': '' }}>
                                                        <span></span>
                                                        {{ ucwords(str_replace('_', ' ', $customer_type)) }}
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row customer_selection">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label" for="customer_id">
                                                Customer
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select name="customer_id" id="customer_id"
                                                    class="form-control select2 customer_id">
                                                <option value="">Please select a value</option>
                                                @foreach(\App\Providers\FormList::getCustomers() as $key => $customer)
                                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label" for="notification_type">Notification
                                                Type</label><br>
                                            <div class="radio-inline">
                                                @foreach(config('constants.NOTIFICATION_TYPES') as $key => $notification_type)
                                                    <label class="radio">
                                                        <input type="radio" name="notification_type"
                                                               class="notification_type"
                                                               value="{{ $notification_type }}"{{ $key == 0 ? 'checked="checked"': '' }}>
                                                        <span></span>
                                                        {{ ucwords(str_replace('_', ' ', $notification_type)) }}
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label" for="notification_template">
                                                Notification Template
                                                <span class="text-danger">*</span>
                                            </label><br>
                                            <select name="notification_template" id="notification_template"
                                                    class="form-control notification_template">
                                                <option value="">Please select a value</option>
                                                <option value="Custom">Custom</option>
                                                @foreach(\App\Providers\FormList::getNotificationTemplates('push_notification') as $notification_template)
                                                    <option
                                                        value="{{ $notification_template->id }}"
                                                        data-subject="{{ $notification_template->subject ?? '' }}"
                                                        data-content="{{ $notification_template->content ?? '' }}">
                                                        {{ \Illuminate\Support\Str::limit($notification_template->content) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row custom_subject d-none">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="custom_subject">
                                                Subject
                                            </label>
                                            <input type="text" class="form-control" id="custom_subject"
                                                   name="custom_subject"
                                                   value="{{ old('custom_subject') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row custom_content">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label" for="custom_content">
                                                Content
                                                <span class="text-danger">*</span>
                                            </label>
                                            <textarea rows="3" cols="5" class="form-control" name="custom_content"
                                                      id="custom_content"
                                                      placeholder="Type here something...">{{ old('custom_content') }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="checkbox checkbox-outline">
                                                <input type="checkbox" name="is_notification_scheduled" value="1">
                                                <span></span>
                                                &nbsp; Do you want to schedule this notification?
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row schedule_date d-none">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label" for="scheduled_at">Schedule Date</label>
                                            <input type="text" class="form-control date_picker" id="scheduled_at"
                                                   name="scheduled_at"
                                                   value="{{ old('scheduled_at', \Carbon\Carbon::now()->format('m/d/Y')) }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <a href="{{ route('home') }}"
                                               class="btn btn-outline-secondary mr-3">Home</a>
                                            <button type="button" class="btn btn-primary send_notification">Send
                                                Notification
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <template class="push_notification_templates">
                <option value="">Please select a value</option>
                <option value="Custom">Custom</option>
                @foreach(\App\Providers\FormList::getNotificationTemplates('push_notification') as $notification_template)
                    <option
                        value="{{ $notification_template->id }}"
                        data-subject="{{ $notification_template->subject ?? '' }}"
                        data-content="{{ $notification_template->content ?? '' }}">
                        {{ \Illuminate\Support\Str::limit($notification_template->content) }}
                    </option>
                @endforeach
            </template>

            <template class="SMS_templates">
                <option value="">Please select a value</option>
                <option value="Custom">Custom</option>
                @foreach(\App\Providers\FormList::getNotificationTemplates('SMS') as $notification_template)
                    <option
                        value="{{ $notification_template->id }}"
                        data-subject="{{ $notification_template->subject ?? '' }}"
                        data-content="{{ $notification_template->content ?? '' }}">
                        {{ \Illuminate\Support\Str::limit($notification_template->content) }}
                    </option>
                @endforeach
            </template>

            <template class="email_templates">
                <option value="">Please select a value</option>
                <option value="Custom">Custom</option>
                @foreach(\App\Providers\FormList::getNotificationTemplates('email') as $notification_template)
                    <option
                        value="{{ $notification_template->id }}"
                        data-subject="{{ $notification_template->subject ?? '' }}"
                        data-content="{{ $notification_template->content ?? '' }}">
                        {{ \Illuminate\Support\Str::limit($notification_template->content) }}
                    </option>
                @endforeach
            </template>

        </div>
    </div>
@stop

@section('page_js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.notification_form').validate({
                ignore: ':hidden',
                errorClass: "invalid",
                rules: {
                    customer_id: 'required',
                    notification_template: 'required',
                    custom_content: 'required',
                },
                errorPlacement: function (error, element) {
                    if (element.hasClass('select2') && element.next('.select2-container').length) {
                        error.insertAfter(element.next('.select2-container'));
                    } else {
                        error.insertAfter(element);
                    }
                }
            });

            $(document).find('.select2').select2({
                placeholder: 'Please select a customer',
                allowClear: true,
            });

            $(document).off('click', '.send_notification');
            $(document).on('click', '.send_notification', function () {
                let $_this = $(this);
                swal({
                    title: "Are you sure?",
                    text: "You want to send notification!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((will_send) => {
                        if (will_send) {
                            $_this.closest('form').submit();
                        }
                    });
            });

            $(document).off('click', 'input[name="customer_type"]');
            $(document).on('click', 'input[name="customer_type"]', function () {
                $(document).find('.customer_selection').removeClass('d-none');
                if ($(this).val() === 'each_active_customer') {
                    $(document).find('.customer_id').val(null).trigger('change');
                    $(document).find('.customer_selection').addClass('d-none');
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
                startDate: new Date(),
                autoclose: true,
            });

            $(document).off('click', 'input[name="is_notification_scheduled"]');
            $(document).on('click', 'input[name="is_notification_scheduled"]', function () {
                $(document).find('.schedule_date').addClass('d-none');
                if ($(this).prop('checked')) {
                    $(document).find('.schedule_date').removeClass('d-none');
                }
            });

            $(document).off('click', 'input[name="notification_type"]');
            $(document).on('click', 'input[name="notification_type"]', function () {
                let template_html = document.querySelector('.' + $(this).val() + '_templates');
                let clone_node = template_html.content.cloneNode(true);
                let clone_html = document.importNode(clone_node, true);
                $(document).find('select[name="notification_template"]').html(clone_html);

                $(document).find('.custom_content').find('textarea').summernote('destroy');
                $(document).find('.custom_content').find('textarea').val('');
                $(document).find('.custom_subject').find('input').val('');

                if ($(this).val() === 'email') {
                    $(document).find('.custom_subject').removeClass('d-none');
                    $(document).find('.custom_content').find('textarea').summernote();
                } else {
                    $(document).find('.custom_subject').addClass('d-none');
                }
            });

            $(document).off('change', 'select[name="notification_template"]');
            $(document).on('change', 'select[name="notification_template"]', function () {
                let selected_option = $(document).find('.notification_template :selected');
                let data_content = selected_option.attr('data-content');
                data_content = data_content !== undefined ? data_content : '';

                if ($(document).find('.notification_type:checked').val() === 'email') {
                    $(document).find('.custom_subject').find('input').val(selected_option.attr('data-subject'));
                    $(document).find('.custom_content').find('textarea').summernote('destroy');
                    $(document).find('.custom_content').find('textarea').summernote('code', data_content);
                } else {
                    $(document).find('.custom_content').find('textarea').val(data_content);
                }
            });
        });
    </script>
@stop
