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
                        <h3 class="card-label">{{ __('locale.elements.heading_title.organization_detail') }}</h3>
                    </div>
                    <div class="card-toolbar">
                        {!! prepare_header_html('organizations', 'display', $organization->slug) !!}
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-5">
                            <strong>{{ __('locale.elements.is_active') }}</strong><br>
                            {!! prepare_active_button('organizations', $organization) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <strong>{{ __('locale.elements.name') }}</strong><br>
                            {{ !empty($organization->name) ? $organization->name : '-' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>{{ __('locale.elements.identifier') }}</strong><br>
                            <span class="text-primary">
                                https://
                                <span class="text-dark organization_identifier">
                                    {{ !empty($organization) && !empty($organization->identifier) ? $organization->identifier : '<identifier>' }}
                                </span>
                                .ridesglobal.fun
                            </span>
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>{{ __('locale.elements.start_date') }}</strong><br>
                            {{ !empty($organization->start_date) ? \Carbon\Carbon::parse($organization->start_date)->format('dS F, Y') : '-' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>{{ __('locale.elements.end_date') }}</strong><br>
                            {{ !empty($organization->end_date) ? \Carbon\Carbon::parse($organization->end_date)->format('dS F, Y') : 'No Expiration' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>{{ __('locale.elements.business_type') }}</strong><br>
                            {{ !empty($organization->business_type) ? $organization->business_type : '-' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>{{ __('locale.elements.business_email') }}</strong><br>
                            {{ !empty($organization->business_email) ? $organization->business_email : '-' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>{{ __('locale.elements.civil_id_number') }}</strong><br>
                            {{ !empty($organization->civil_id_number) ? $organization->civil_id_number : '-' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>{{ __('locale.elements.contact_person') }}</strong><br>
                            {{ !empty($organization->contact_person) ? $organization->contact_person : '-' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>{{ __('locale.elements.phone') }}</strong><br>
                            {{ !empty($organization->phone) ? $organization->phone : '-' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>{{ __('locale.elements.email') }}</strong><br>
                            {{ !empty($organization->email) ? $organization->email : '-' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>{{ __('locale.elements.users_count') }}</strong><br>
                            {{ !empty($organization->users_count) ? $organization->users_count : '-' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>{{ __('locale.elements.currency') }}</strong><br>
                            {{ !empty($organization->currency_code) ? $organization->currency_code : '-' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>{{ __('locale.elements.payment_gateway') }}</strong><br>
                            {{ !empty($organization->payment_gateway) ? $organization->payment_gateway : '-' }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-5">
                            <strong>{{ __('locale.elements.attachment') }}</strong><br>
                            @if(isset($organization) && !empty($organization->attachment))
                                <a href="{{ config('constants.s3.asset_url') . $organization->attachment }}"
                                   target="_blank">
                                    <i class="fa fa-image fa-10x"></i>
                                </a>
                            @else
                                <span>-</span>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <strong>{{ __('locale.elements.description') }}</strong><br>
                            {{ !empty($organization->description) ? $organization->description : '-' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('page_js')

@stop
