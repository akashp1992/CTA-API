<?php
$organization = session()->get('organization');
$is_RTL_enabled = isset($organization) && $organization->is_RTL_enabled === 1 ? 'rtl' : '';
?>

<!DOCTYPE html>
<html lang="en" direction="{{ $is_RTL_enabled }}" dir="{{ $is_RTL_enabled }}" style="direction: {{ $is_RTL_enabled }}">
<head>
    <base href="">
    <meta charset="utf-8"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    @include('layouts.style')
</head>
@php $current = \Route::currentRouteName(); @endphp
<body>

                @yield('content')

@include('layouts.script')
@yield('page_js')
</body>
</html>
