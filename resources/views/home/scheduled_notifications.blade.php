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
                        <h3 class="card-label">Scheduled Notifications</h3>
                    </div>
                    <div class="card-toolbar">
                        <a href="{{ route('notification.send') }}" class="btn btn-outline-secondary font-weight-bolder">
                            <span class="svg-icon svg-icon-md">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                     width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <polygon points="0 0 24 0 24 24 0 24"/>
                                        <path
                                            d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z"
                                            fill="#000000" fill-rule="nonzero"
                                            transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999) "/>
                                        <path
                                            d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z"
                                            fill="#000000" fill-rule="nonzero" opacity="0.3"
                                            transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999) "/>
                                    </g>
                                </svg>
                            </span>
                            Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered data_table">
                        <thead>
                        <tr>
                            <th>{{ __('locale.elements.index') }}</th>
                            <th>Customer</th>
                            <th>Scheduled Date</th>
                            <th>Type</th>
                            <th>Notification Content</th>
                            <th>Is Sent?</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($notifications as $index => $notification)
                            <tr>
                                <td>{{ ++$index }}</td>
                                <td>{{ isset($notification) && isset($notification->customer) ? $notification->customer->name : '-' }}</td>
                                <td>{{ !empty($notification->scheduled_at) ? \Carbon\Carbon::parse($notification->scheduled_at)->format('dS F, Y') : '-' }}</td>
                                <td>{{ !empty($notification->type) ? ucwords(str_replace('_', ' ', $notification->type)) : '-' }}</td>
                                <td>
                                    <a href="javascript:void(0);"
                                       class="show_content"
                                       data-subject="{{ !empty($notification->subject) ? $notification->subject : '-' }}"
                                       data-content="{{ !empty($notification->content) ? $notification->content : '-' }}">
                                        <i class="fa fa-external-link-alt text-primary"></i>
                                    </a>
                                </td>
                                <td>
                                    @if(isset($notification) && $notification->is_sent === 1)
                                        <i class="fa fa-check text-success"></i>
                                    @else
                                        <i class="fa fa-times text-danger"></i>
                                    @endif
                                </td>
                                <td>
                                    @if(isset($notification) && $notification->is_sent === 0)
                                        <div class="btn-group mr-2" role="group">
                                            <button type="button"
                                                    class="btn btn-sm btn-outline-primary send_notification"
                                                    data-href="{{ route('notification.scheduled.manage', ['send', $notification->id]) }}"
                                                    data-toggle="popover" title="Send Notification"
                                                    data-content="This action button will help you to send notification instant">
                                                Send Notification
                                            </button>

                                            <button type="button"
                                                    class="btn btn-sm btn-outline-danger delete_notification"
                                                    data-href="{{ route('notification.scheduled.manage', ['delete', $notification->id]) }}"
                                                    data-toggle="popover" title="Delete Notification"
                                                    data-content="This action button will help you to delete notification">
                                                Delete Notification
                                            </button>
                                        </div>
                                    @else
                                        <span class="text-info">ALREADY SENT</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal fade show_content_modal"
                 id="show_content_modal" data-backdrop="static"
                 tabindex="-1" role="dialog" aria-labelledby="staticBackdrop"
                 aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">
                                Show Notification Content
                            </h5>
                            <button type="button" class="close" data-dismiss="modal"
                                    aria-label="Close">
                                <i aria-hidden="true" class="ki ki-close"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap pl-0 pr-0">
                                    <span class="font-weight-bold">Subject</span>
                                    <span class="text-secondary modal_subject"></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap pl-0 pr-0">
                                    <span class="font-weight-bold">Content</span>
                                    <span class="text-secondary modal_content"></span>
                                </li>
                            </ul>
                        </div>
                        <div class="modal-footer">
                            <button type="button"
                                    class="btn btn-light-primary font-weight-bold"
                                    data-dismiss="modal">Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('page_js')
    <script type="text/javascript">
        $(document).ready(function () {
            $(document).off('click', '.show_content');
            $(document).on('click', '.show_content', function () {
                $(document).find('.show_content_modal').modal('show');
                $(document).find('.modal_subject').text($(this).attr('data-subject'));
                $(document).find('.modal_content').text($(this).attr('data-content'));
            });

            $(document).off('click', '.send_notification');
            $(document).on('click', '.send_notification', function () {
                let $_this = $(this);

                swal({
                    title: "Are you sure?",
                    text: "Once sent, you will not be able to revert this item!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((will_send) => {
                    if (will_send) {
                        window.location.href = $_this.attr('data-href');
                    }
                });
            });

            $(document).off('click', '.delete_notification');
            $(document).on('click', '.delete_notification', function () {
                let $_this = $(this);

                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this item!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((will_delete) => {
                    if (will_delete) {
                        window.location.href = $_this.attr('data-href');
                    }
                });
            });
        });
    </script>
@stop
