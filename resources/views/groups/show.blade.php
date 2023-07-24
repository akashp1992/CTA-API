@extends('layouts.master')

@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                        <h3 class="card-label">{{ __('locale.elements.heading_title.group_detail') }}</h3>
                    </div>
                    <div class="card-toolbar">
                        {!! prepare_header_html('groups', 'display', $group->slug) !!}
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-5">
                            <strong>{{ __('locale.elements.is_active') }}</strong><br>
                            {!! prepare_active_button('groups', $group) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-5">
                            <strong>{{ __('locale.elements.name') }}</strong><br>
                            {{ !empty($group->name) ? $group->name : '-' }}
                        </div>
                        <div class="col-md-3 mb-5">
                            <strong>{{ __('locale.elements.created_by') }}</strong><br>
                            {{ isset($group->created_by_user) && !empty($group->created_by_user) ? $group->created_by_user->name : 'System' }}
                        </div>
                        <div class="col-md-3 mb-5">
                            <strong>{{ __('locale.elements.updated_by') }}</strong><br>
                            {{ isset($group->updated_by_user) && !empty($group->updated_by_user) ? $group->updated_by_user->name : 'System' }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-5">
                            <strong>{{ __('locale.elements.description') }}</strong><br>
                            {{ !empty($group->description) ? $group->description : '-' }}
                        </div>
                    </div>

                    <p class="mt-5">
                        <strong>{{ __('locale.elements.users') }}</strong>
                        <span class="text-muted">( {{ __('locale.elements.users_text') }} )</span>
                    </p>
                    <table class="table table-bordered data_table">
                        <thead>
                        <tr>
                            <th>{{ __('locale.elements.index') }}</th>
                            <th>{{ __('locale.elements.name') }}</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>{{ __('locale.elements.is_active_q') }}</th>
                            <th>Created By</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($group->users) && count($group->users) > 0)
                            @foreach($group->users as $index => $user)
                                <tr>
                                    <td>{{ ++$index }}</td>
                                    <td>{{ !empty($user->name) ? $user->name : '-' }}</td>
                                    <td>{{ !empty($user->email) ? $user->email : '-' }}</td>
                                    <td>{{ !empty($user->phone) ? $user->phone : '-' }}</td>
                                    <td>{!! prepare_active_button('users', $user) !!}</td>
                                    <td>{{ isset($user->created_by_user) && !empty($user->created_by_user) ? $user->created_by_user->name : 'System' }}</td>
                                    <td nowrap="nowrap">{!! prepare_listing_action_buttons('users', $user->slug, $accesses_urls) !!}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="9">No record found.</td>
                            </tr>
                        @endif
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
