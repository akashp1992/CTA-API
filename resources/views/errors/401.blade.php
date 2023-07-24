<!DOCTYPE html>

<html lang="en-us" class="no-js">

<head>
    <title>{{ $configuration['name'] }}</title>
    <meta charset="utf-8">
    <meta name="description" content="#">
    <meta name="keywords" content="{{ $configuration['name'] }}">
    <meta name="author" content="#">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Favicon -->
    <link rel="icon" href="{{ config('constants.s3.asset_url') . $configuration['favicon'] }}" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/errors/css/style.css') }}"/>
</head>

<body>

<a href="{{ route('home') }}" class="logo-link" title="back home">
    <img src="{{ config('constants.s3.asset_url') . $configuration['logo'] }}" width="150"
         alt="{{ $configuration['name'] }}">
</a>

<div class="content">
    <div class="content-box">
        <div class="big-content">
            <div class="list-square">
                <span class="square"></span>
                <span class="square"></span>
                <span class="square"></span>
            </div>

            <!-- Main lines for the content logo in the background -->
            <div class="list-line">
                <span class="line"></span>
                <span class="line"></span>
                <span class="line"></span>
                <span class="line"></span>
                <span class="line"></span>
                <span class="line"></span>
            </div>
            <i class="fa fa-search" aria-hidden="true"></i>
            <div class="clear"></div>
        </div>

        <h1>Oops! Error 401 Unauthorized.</h1>
        <p>
            It looks like you don't have permission to access this page.
            <br><br>
            <a href="{{ route('home') }}" class="btn btn-default">Back</a>
        </p>
    </div>
</div>
<footer class="light">
    <ul>
        <li><a href="javascript:void(0);">Support</a></li>
        <li><a href="javascript:void(0);"><i class="fa fa-facebook"></i></a></li>
        <li><a href="javascript:void(0);"><i class="fa fa-twitter"></i></a></li>
    </ul>
</footer>
<script src="{{ asset('theme/errors/js/jquery.min.js') }}"></script>
<script src="{{ asset('theme/errors/js/bootstrap.min.js') }}"></script>
<!-- Slideshow plugin -->
<script src="{{ asset('theme/errors/js/vegas.js') }}"></script>

</body>

</html>
