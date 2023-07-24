@extends('layouts.master')

@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                        <h3 class="card-label">{{ __('locale.elements.heading_title.user_detail') }}</h3>
                    </div>
                    <div class="card-toolbar">
                        {!! prepare_header_html('users', 'display', $user->slug) !!}
                    </div>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-3 mb-5">
                            <strong>{{ __('locale.elements.group') }}</strong><br>
                            <a href="{{ route('groups.show', [$user->group->slug]) }}"
                               class="text-decoration-none text-primary text-hover-primary">
                                <u>{{ !empty($user->group) && !empty($user->group->name) ? $user->group->name : '-' }}</u>
                            </a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <strong>{{ __('locale.elements.name') }}</strong><br>
                            {{ !empty($user->name) ? $user->name : '-' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>{{ __('locale.elements.email') }}</strong><br>
                            {{ !empty($user->email) ? $user->email : '-' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>{{ __('locale.elements.phone') }}</strong><br>
                            {{ !empty($user->phone) ? $user->phone : '-' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>{{ __('locale.elements.gender') }}</strong><br>
                            {{ !empty($user->gender) ? $user->gender : '-' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>{{ __('locale.elements.created_by') }}</strong><br>
                            {{ isset($user->created_by_user) && !empty($user->created_by_user) ? $user->created_by_user->name : 'System' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>{{ __('locale.elements.updated_by') }}</strong><br>
                            {{ isset($user->updated_by_user) && !empty($user->updated_by_user) ? $user->updated_by_user->name : 'System' }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-5">
                            <strong>{{ __('locale.elements.picture') }}</strong><br>
                            @if(isset($user) && !empty($user->picture))
                                <a href="{{ config('constants.s3.asset_url') . $user->picture }}"
                                   target="_blank">
                                    <i class="fa fa-image fa-10x"></i>
                                </a>
                            @else
                                <span>-</span>
                            @endif
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
            //
        });
    </script>
@stop
