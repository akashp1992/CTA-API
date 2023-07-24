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
                        <h3 class="card-label">{{ __('locale.elements.heading_title.customer_detail') }}</h3>
                    </div>
                    <div class="card-toolbar">
                        {!! prepare_header_html('customers', 'display', $customer->slug) !!}
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <strong>{{ __('locale.elements.name') }}</strong><br>
                            {{ !empty($customer->name) ? $customer->name : '-' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>{{ __('locale.elements.email') }}</strong><br>
                            {{ !empty($customer->email) ? $customer->email : '-' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>{{ __('locale.elements.phone') }}</strong><br>
                            {{ !empty($customer->phone) ? $customer->phone : '-' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>{{ __('locale.elements.gender') }}</strong><br>
                            {{ !empty($customer->gender) ? $customer->gender : '-' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>{{ __('locale.elements.created_by') }}</strong><br>
                            {{ isset($customer->created_by_user) && !empty($customer->created_by_user) ? $customer->created_by_user->name : 'System' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>{{ __('locale.elements.updated_by') }}</strong><br>
                            {{ isset($customer->updated_by_user) && !empty($customer->updated_by_user) ? $customer->updated_by_user->name : 'System' }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-5">
                            <strong>{{ __('locale.elements.picture') }}</strong><br>
                            @if(isset($customer) && !empty($customer->picture))
                                <a href="{{ config('constants.s3.asset_url') . $customer->picture }}"
                                   target="_blank">
                                    <i class="fa fa-image fa-10x"></i>
                                </a>
                            @else
                                <span>-</span>
                            @endif
                        </div>
                    </div>

                    <hr>
                    <ul class="nav nav-tabs tabs mt-10" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tab_addresses" role="tab">{{ __('locale.elements.addresses') }}</a>
                        </li>
                    </ul>

                    <div class="tab-content tabs card-block mt-10">
                        <div class="tab-pane active" id="tab_addresses" role="tabpanel">
                            <p>
                                <strong>{{ __('locale.elements.addresses') }}</strong>
                                <span class="text-muted">( {{ __('locale.elements.customer_addresses') }} )</span>
                            </p>
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>{{ __('locale.elements.index') }}</th>
                                    <th>{{ __('locale.elements.name') }}</th>
                                    <th>Block</th>
                                    <th>Street</th>
                                    <th>House</th>
                                    <th>Avenue</th>
                                    <th>Floor</th>
                                    <th>Flat</th>
                                    <th>Landmark</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($customer->addresses) && count($customer->addresses) > 0)
                                    @foreach($customer->addresses as $index => $address)
                                        <tr>
                                            <td>{{ ++$index }}</td>
                                            <td>{{ isset($address->governorate) && !empty($address->governorate->title) ? $address->governorate->title : '' }}</td>
                                            <td>{{ isset($address->area) && !empty($address->area->title) ? $address->area->title : '' }}</td>
                                            <td>{{ !empty($address->name) ? $address->name : '-' }}</td>
                                            <td>{{ !empty($address->block) ? $address->block : '-' }}</td>
                                            <td>{{ !empty($address->street) ? $address->street : '-' }}</td>
                                            <td>{{ !empty($address->house_name) ? $address->house_name : '-' }}</td>
                                            <td>{{ !empty($address->avenue) ? $address->avenue : '-' }}</td>
                                            <td>{{ !empty($address->floor) ? $address->floor : '-' }}</td>
                                            <td>{{ !empty($address->flat) ? $address->flat : '-' }}</td>
                                            <td>{{ !empty($address->landmark) ? $address->landmark : '-' }}</td>
                                            <td nowrap="nowrap">
                                                <a href="{{ route('addresses.edit', [$customer->slug, $address->slug]) }}">Edit</a>
                                                <span class="text-primary">&nbsp; | &nbsp;</span>

                                                <a href="javascript:void(0);" class="delete_item">Delete</a>
                                                <form class="delete_item_form"
                                                      action="{{ route('addresses.destroy', [$customer->slug, $address->slug]) }}"
                                                      method="POST" style="display: none;">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    {{ csrf_field() }}
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="11">No record found.</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
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
