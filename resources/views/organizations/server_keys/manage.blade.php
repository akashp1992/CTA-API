@extends('layouts.master')

@section('content')
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
        <div class="card-header flex-wrap">
            <div class="card-title">
                <h3 class="card-label">VeChain Server Key - Manage</h3>
            </div>
            <div class="card-toolbar">
                <a href="{{ route('organizations.show', [$organization_slug]) }}" class="btn btn-primary font-weight-bolder">
                    Back
                </a>
            </div>
        </div>
        <div class="card-body">
            <?php
            /** @var string $organization_slug */
            $redirect_route = !empty($server_key)
                ? route('server_keys.update', [$organization_slug, $server_key->id])
                : route('server_keys.store', $organization_slug);
            ?>
            <form action="{{ $redirect_route }}" method="post"
                  enctype="multipart/form-data" class="VeChain_server_keys_form" id="VeChain_server_keys_form">
                {{ csrf_field() }}
                @if(isset($server_key) && !empty($server_key))
                    <input type="hidden" name="_method" value="put">
                @endif
                <input type="hidden" name="slug" class="slug" value="{{$organization_slug }}">
                @include('organizations.server_keys.form')
            </form>
        </div>
    </div>
@stop

@section('page_js')
    <script type="text/javascript">
        $('.VeChain_server_keys_form').validate({
            ignore: ':hidden',
            errorClass: "invalid",
            rules: {
                app_key: 'required',
                app_id: 'required',
                name: 'required'
            }
        });
    </script>
@stop
