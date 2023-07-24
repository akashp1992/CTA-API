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
                        <h3 class="card-label">{{ __('locale.elements.heading_title.users') }}</h3>
                    </div>
                    <div class="card-toolbar">
                        {!! prepare_header_html('users', 'listing') !!}
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered data_table">
                        <thead>
                        <tr>
                            <th>{{ __('locale.elements.index') }}</th>

                            @if($is_root_user == 1 || auth()->user()->group_id == 1)
                                <th>{{ __('locale.elements.group') }}</th>
                            @endif

                            <th>{{ __('locale.elements.name') }}</th>
                            <th>{{ __('locale.elements.email') }}</th>
                            <th>{{ __('locale.elements.phone') }}</th>
                            <th>{{ __('locale.elements.is_active_q') }}</th>
                            <th>{{ __('locale.elements.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $index => $user)
                            <tr>
                                <td>{{ ++$index }}</td>

                                @if($is_root_user == 1 || auth()->user()->group_id == 1)
                                    <td>
                                        @if(isset($user->group_id) && $user->group_id > 0)
                                            <a href="{{ route('groups.show', [$user->group->slug]) }}"
                                               class="text-decoration-none text-primary text-hover-primary">
                                                <u>{{ isset($user->group) ? $user->group->name : '-' }}</u>
                                            </a>
                                        @else
                                            <span>-</span>
                                        @endif
                                    </td>
                                @endif

                                <td>{{ !empty($user->name) ? $user->name : '-' }}</td>
                                <td>{{ !empty($user->email) ? $user->email : '-' }}</td>
                                <td>{{ !empty($user->phone) ? $user->phone : '-' }}</td>
                                <td>{!! prepare_active_button('users', $user) !!}</td>
                                <td nowrap="nowrap">{!! prepare_listing_action_buttons('users', $user->slug, $accesses_urls) !!}</td>
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
