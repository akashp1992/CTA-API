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
                        <h3 class="card-label">{{ __('locale.elements.heading_title.companies') }}</h3>
                    </div>
                    <div class="card-toolbar">
                        {!! prepare_header_html('companies', 'listing') !!}
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered data_table">
                        <thead>
                        <tr>
                            <th>{{ __('locale.elements.index') }}</th>
                            <th>{{ __('locale.elements.name') }}</th>
                            <th>{{ __('locale.elements.prefix') }}</th>
                            <th>{{ __('locale.elements.phone') }}</th>
                            <th>{{ __('locale.elements.is_active_q') }}</th>
                            <th>{{ __('locale.elements.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($companies as $index => $company)
                            <tr>
                                <td>{{ ++$index }}</td>
                                <td>{{ !empty($company->name) ? $company->name : '-' }}</td>
                                <td>{{ !empty($company->prefix) ? $company->prefix : '-' }}</td>
                                <td>{{ !empty($company->phone) ? $company->phone : '-' }}</td>
                                <td>{!! prepare_active_button('companies', $company) !!}</td>
                                <td nowrap="nowrap">{!! prepare_listing_action_buttons('companies', $company->slug, $accesses_urls) !!}</td>
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
