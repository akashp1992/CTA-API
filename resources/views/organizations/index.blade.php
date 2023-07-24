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
                        <h3 class="card-label">{{ __('locale.elements.heading_title.organizations') }}</h3>
                    </div>
                    <div class="card-toolbar">
                        {!! prepare_header_html('organizations', 'listing') !!}
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered data_table">
                        <thead>
                        <tr>
                            <th>{{ __('locale.elements.index') }}</th>
                            <th>{{ __('locale.elements.name') }}</th>
                            <th>{{ __('locale.elements.contact_person') }}</th>
                            <th>{{ __('locale.elements.email') }}</th>
                            <th>{{ __('locale.elements.phone') }}</th>
                            <th>{{ __('locale.elements.is_active_q') }}</th>
                            <th>{{ __('locale.elements.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($organizations as $index => $organization)
                            <tr>
                                <td>{{ ++$index }}</td>
                                <td>
                                    <span>{{ !empty($organization->name) ? $organization->name : '-' }}</span>
                                    @if(!empty($organization) && !empty($organization->identifier))
                                        <a href="https://{{ $organization->identifier }}.ridesglobal.fun"
                                           class="float-right" target="_blank">
                                            Link
                                        </a>
                                    @endif
                                </td>
                                <td>{{ !empty($organization->contact_person) ? $organization->contact_person : '-' }}</td>
                                <td>{{ !empty($organization->email) ? $organization->email : '-' }}</td>
                                <td>{{ !empty($organization->phone) ? $organization->phone : '-' }}</td>
                                <td>{!! prepare_active_button('organizations', $organization) !!}</td>
                                <td nowrap="nowrap">{!! prepare_listing_action_buttons('organizations', $organization->slug, $accesses_urls) !!}</td>
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
