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
                        <h3 class="card-label">{{ __('locale.elements.heading_title.groups') }}</h3>
                    </div>
                    <div class="card-toolbar">
                        {!! prepare_header_html('groups', 'listing') !!}
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered data_table">
                        <thead>
                        <tr>
                            <th>{{ __('locale.elements.index') }}</th>
                            <th>{{ __('locale.elements.name') }}</th>
                            <th>{{ __('locale.elements.is_active_q') }}</th>
                            <th>{{ __('locale.elements.is_restricted_q') }}</th>
                            <th>{{ __('locale.elements.created_by') }}</th>
                            <th>{{ __('locale.elements.action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($groups as $index => $group)
                            <tr>
                                <td>{{ ++$index }}</td>
                                <td>{{ isset($group->name) ? $group->name : '' }}</td>
                                <td>{!! prepare_active_button('groups', $group) !!}</td>
                                <td>{{ (isset($group->is_restricted) && $group->is_restricted == 1) ? 'Yes' : 'No' }}</td>
                                <td>{{ isset($group->created_by_user) && !empty($group->created_by_user) ? $group->created_by_user->name : 'System' }}</td>
                                <td nowrap="nowrap">{!! prepare_listing_action_buttons('groups', $group->slug, $accesses_urls, $group->id) !!}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('page_js')
    <script type="text/javascript">
        $(document).ready(function () {
            //
        });
    </script>
@stop
