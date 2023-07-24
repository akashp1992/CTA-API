<title>{{ $configuration['name'] }}</title>
<meta name="description" content="{{ $configuration['name'] }}"/>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
<link rel="canonical" href="{{ $configuration['name'] }}"/>

<!--begin::Fonts-->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700"/>
<!--end::Fonts-->

<!--begin::Fonts-->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&display=swap" rel="stylesheet">
<!--end::Fonts-->

<!--begin::Page Vendors Styles(used by this page)-->
<link href="//www.amcharts.com/lib/3/plugins/export/export.css" rel="stylesheet" type="text/css" />
<!--end::Page Vendors Styles-->

<?php
$is_RTL_enabled = \Illuminate\Support\Facades\App::getLocale() === 'ar' ? '.rtl' : '';
?>

<!--begin::Page Vendors Styles(used by this page)-->
<link href="{{ asset('theme/plugins/custom/fullcalendar/fullcalendar.bundle'. $is_RTL_enabled .'.css') }}" rel="stylesheet" type="text/css"/>
<!--end::Page Vendors Styles-->

<!--begin::Page Vendors Styles(used by this page)-->
<link href="{{ asset('theme/plugins/custom/datatables/datatables.bundle'. $is_RTL_enabled .'.css') }}" rel="stylesheet" type="text/css" />
<!--end::Page Vendors Styles-->

<!--begin::Global Theme Styles(used by all pages)-->
<link href="{{ asset('theme/plugins/global/plugins.bundle'. $is_RTL_enabled .'.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('theme/plugins/custom/prismjs/prismjs.bundle'. $is_RTL_enabled .'.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('theme/css/style.bundle'. $is_RTL_enabled .'.css') }}" rel="stylesheet" type="text/css"/>
<!--end::Global Theme Styles-->

<!--begin::Layout Themes(used by all pages)-->
<link href="{{ asset('theme/css/themes/layout/header/base/light'. $is_RTL_enabled .'.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('theme/css/themes/layout/header/menu/light'. $is_RTL_enabled .'.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('theme/css/themes/layout/brand/dark'. $is_RTL_enabled .'.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('theme/css/themes/layout/aside/dark'. $is_RTL_enabled .'.css') }}" rel="stylesheet" type="text/css"/>
<!--end::Layout Themes-->

<link href="{{ asset('css/custom.css') }}" rel="stylesheet" type="text/css"/>

<link rel="icon" href="{{ config('constants.s3.asset_url') . $configuration['favicon'] }}" type="image/x-icon">
@yield('style')
