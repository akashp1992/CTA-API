@extends('layouts.master')

@section('content')
    <div class="card card-custom gutter-b">
        <div class="card-header flex-wrap py-3">
            <div class="card-title">
                <h3 class="card-label">VeChain Server Key - Detail</h3>
            </div>
            <div class="card-toolbar">
                {!! prepare_header_html('server_keys', 'display', [$organization_slug, $server_key->id]) !!}
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 mb-4">
                    <strong>Name</strong><br>
                    {{ !empty($server_key->name) ? $server_key->name : '-' }}
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 mb-4">
                    <strong>App ID</strong><br>
                    {{ !empty($server_key->app_id) ? $server_key->app_id : '-' }}
                </div>
                <div class="col-md-3 mb-4">
                    <strong>App Key</strong><br>
                    {{ !empty($server_key->app_key) ?  $server_key->app_key: '-' }}
                </div>
            </div>
        </div>
    </div>
@stop

@section('page_js')
    <script type="text/javascript">
        //
    </script>
@stop
