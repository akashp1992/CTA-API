@extends('layouts.master')

@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                        <h3 class="card-label">{{ __('locale.elements.heading_title.company_detail') }}</h3>
                    </div>
                    <div class="card-toolbar">
                        {!! prepare_header_html('companies', 'display', $company->slug) !!}
                    </div>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <strong>{{ __('locale.elements.name') }}</strong><br>
                            {{ !empty($company->name) ? $company->name : '-' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>{{ __('locale.elements.name_arabic') }}</strong><br>
                            {{ !empty($company->arabic_name) ? $company->arabic_name : '-' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>{{ __('locale.elements.prefix') }}</strong><br>
                            {{ !empty($company->prefix) ? $company->prefix : '-' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>{{ __('locale.elements.phone') }}</strong><br>
                            {{ !empty($company->phone) ? $company->phone : '-' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>{{ __('locale.elements.email') }}</strong><br>
                            {{ !empty($company->email) ? $company->email : '-' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>{{ __('locale.elements.contact_person_name') }}</strong><br>
                            {{ !empty($company->contact_name) ? $company->contact_name : '-' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>{{ __('locale.elements.contact_person_email') }}</strong><br>
                            {{ !empty($company->contact_email) ? $company->contact_email : '-' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>{{ __('locale.elements.contact_person_phone') }}</strong><br>
                            {{ !empty($company->contact_phone) ? $company->contact_phone : '-' }}
                        </div>
                        <div class="col-md-12 mb-6">
                            <strong>{{ __('locale.elements.address') }}</strong><br>
                            {{ !empty($company->address) ? $company->address : '-' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>{{ __('locale.elements.created_by') }}</strong><br>
                            {{ isset($company->created_by_company) && !empty($company->created_by_company) ? $company->created_by_company->name : 'System' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>{{ __('locale.elements.updated_by') }}</strong><br>
                            {{ isset($company->updated_by_company) && !empty($company->updated_by_company) ? $company->updated_by_company->name : 'System' }}
                        </div>
                    </div>
                    <hr class="mt-10 mb-10 border-secondary">

                    <p class="mt-5">
                        <strong>{{ __('locale.elements.section_heading.bulk_coupons') }}</strong><br>
                    </p>
                    <table class="table table-bordered data_table">
                        <thead>
                            <tr>
                                <th>{{ __('locale.elements.index') }}</th>
                                <th>Type</th>
                                <th>Code</th>
                                <th>Value</th>
                                <th>Coupon Cost</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                                @foreach($company->coupon as $index => $coupon)
                                    <tr>
                                        <td>{{ ++$index }}</td>
                                        <td>{{ !empty($coupon->type) ? $coupon->type : '-' }}</td>
                                        <td>{{ !empty($coupon->code) ? $coupon->code : '-' }}</td>
                                        <td>{{ !empty($coupon->value) ? $coupon->value : '-' }}</td>
                                        <td>{{ !empty($coupon->coupon_cost) ? $coupon->coupon_cost : '-' }}</td>
                                        <td>{{ !empty($coupon->start_date) ? $coupon->start_date : '-' }}</td>
                                        <td>{{ !empty($coupon->end_date) ? $coupon->end_date : '-' }}</td>
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
