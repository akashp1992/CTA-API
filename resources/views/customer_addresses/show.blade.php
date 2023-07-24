@extends('layouts.master')

@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                        <h3 class="card-label">Customer Detail</h3>
                    </div>
                    <div class="card-toolbar">
                        {!! prepare_header_html('customers', 'display', $customer->slug) !!}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="card card-custom gutter-b">
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap pl-0 pr-0">
                                    <span class="font-weight-bold">Name</span>
                                    <span class="text-secondary">
                                                        {{ !empty($customer->name) ? $customer->name : '-' }}
                                                    </span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap pl-0 pr-0">
                                    <span class="font-weight-bold">Email</span>
                                    <span class="text-secondary">
                                                        {{ !empty($customer->email) ? $customer->email : '-' }}
                                                    </span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap pl-0 pr-0">
                                    <span class="font-weight-bold">Phone</span>
                                    <span class="text-secondary">
                                                        {{ !empty($customer->phone) ? $customer->phone : '-' }}
                                                    </span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap pl-0 pr-0">
                                    <span class="font-weight-bold">Gender</span>
                                    <span class="text-secondary">
                                                        {{ !empty($customer->gender) ? $customer->gender : '-' }}
                                                    </span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap pl-0 pr-0">
                                    <span class="font-weight-bold">Created By User</span>
                                    <span class="text-secondary">
                                                        {{ isset($customer->created_by_user) && !empty($customer->created_by_user) ? $customer->created_by_user->name : 'System' }}
                                                    </span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap pl-0 pr-0">
                                    <span class="font-weight-bold">Updated By User</span>
                                    <span class="text-secondary">
                                                        {{ isset($customer->updated_by_user) && !empty($customer->updated_by_user) ? $customer->updated_by_user->name : 'System' }}
                                                    </span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap pl-0 pr-0">
                                    <span class="font-weight-bold">Picture</span>
                                    @if(isset($customer) && !empty($customer->picture))
                                        <a href="{{ config('constants.s3.asset_url') . $customer->picture }}"
                                           target="_blank">
                                            <i class="fa fa-image"></i>
                                        </a>
                                    @else
                                        <span>-</span>
                                    @endif
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card card-custom gutter-b">
                        <div class="card-header flex-wrap py-3">
                            <div class="card-title">
                                <h3 class="card-label">Addresses</h3>
                            </div>
                            <div class="card-toolbar">
                                <a href="javascript:void(0);" class="btn btn-outline-primary">Add Address</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>{{ __('locale.elements.index') }}</th>
                                    <th>{{ __('locale.elements.name') }}</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($customer->addresses) && count($customer->addresses) > 0)
                                    @foreach($customer->addresses as $index => $address)
                                        <tr>
                                            <td>{{ ++$index }}</td>
                                            <td>{{ !empty($address->name) ? $address->name : '-' }}</td>
                                            <td>{{ !empty($address->phone) ? $address->phone : '-' }}</td>
                                            <td>
                                            <?php
                                            $address = '';
                                            $address .= !empty($address->block) ? $address->block . ', ' : '';
                                            $address .= !empty($address->street) ? $address->street . ', ' : '';
                                            $address .= !empty($address->house_name) ? $address->house_name . ', ' : '';
                                            $address .= !empty($address->avenue) ? $address->avenue . ', ' : '';
                                            $address .= !empty($address->floor) ? $address->floor . ', ' : '';
                                            $address .= !empty($address->flat) ? $address->flat . ', ' : '';
                                            $address .= !empty($address->landmark) ? $address->landmark : '';
                                            echo $address;
                                            ?>
                                            <td>Action</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5">No record found.</td>
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
