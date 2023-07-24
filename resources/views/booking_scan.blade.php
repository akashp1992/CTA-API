<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $configuration['name'] }}</title>
    @include('layouts.style')
</head>

<body>

<div class="d-flex flex-column flex-root container">
    <div class="clearfix">&nbsp;</div>
    <div class="card card-custom gutter-b">
        <div class="card-body">
            @if(!empty($configuration['actual_logo']) && !empty($configuration['name']))
                <a href="{{ route('home') }}" class="d-flex justify-content-center">
                    <img
                        src="{{ config('constants.s3.asset_url') . $configuration['actual_logo'] }}"
                        alt="{{ $configuration['name'] }}"
                        style="max-width: 250px;">
                </a>
                <br>
            @endif

            <div class="row">
                <div class="col-md-12">
                    @if(\Illuminate\Support\Facades\Session::has('notification'))
                        <div class="alert alert-{{\Illuminate\Support\Facades\Session::get('notification.type')}}">
                            <span><?php echo \Illuminate\Support\Facades\Session::get('notification.message'); ?></span>
                        </div>
                    @endif
                </div>
            </div>

            <h6 class="mt-10 mb-10 line-height-lg">
                Thank You <br> For booking with us
            </h6>

            <p>
                <strong>Payment Status: </strong><br>
                <span>{{ !empty($data->payment_status) ? ucwords($data->payment_status) : '-' }}</span>
            </p>

            @if(!empty($configuration['phone']))
                <h6 class="mt-5 line-height-lg text-info text-center">Support Phone: {{ $configuration['phone'] }}</h6>
            @endif
        </div>
    </div>
</div>

@include('layouts.scroll_top')
@include('layouts.script')

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
    window.onload = (event) => {
        if (window.localStorage) {
            if (!localStorage.getItem('first_load')) {
                localStorage['first_load'] = true;
                window.location.reload();
            } else {
                localStorage.removeItem('first_load');
            }
        }
    };

    $(document).ready(function () {
        //
    });
</script>
</body>
</html>