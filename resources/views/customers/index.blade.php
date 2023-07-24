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
                        <h3 class="card-label">{{ __('locale.elements.heading_title.customers') }}</h3>
                    </div>
                    <div class="card-toolbar">
                        @if(auth()->user()->is_root_user == 1)
                        <a href="{{ route('imports', ['customers']) }}" class="btn btn-primary font-weight-bolder">Import CSV</a>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        @endif
                        {!! prepare_header_html('customers', 'listing') !!}
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered customer_listing">
                        <thead>
                        <tr>
                            <th>{{ __('locale.elements.index') }}</th>
                            <th>{{ __('locale.elements.name') }}</th>
                            <th>{{ __('locale.elements.email') }}</th>
                            <th>{{ __('locale.elements.phone') }}</th>
                            <th>{{ __('locale.elements.is_active_q') }}</th>
                            <th>{{ __('locale.elements.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('page_js')
    <script type="text/javascript">
        $(function () {
            $('.customer_listing').DataTable({
                aaSorting: [],
                processing: true,
                language: {
                    "loadingRecords": "&nbsp;",
                    "processing": '<img src="{{ asset('images/ajax-loader.gif') }}" alt=""> Loading...'
                },
                serverSide: true,
                ajax: "{{ route('customers.ajax') }}",
                columns: [
                    {data: 'DT_RowIndex', defaultContent: ''},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'phone', name: 'phone'},
                    {data: 'update_state'},
                    {data: 'action', name: 'action'},
                ]
            });
        });
    </script>
@stop
