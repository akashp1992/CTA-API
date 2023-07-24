<?php
$is_RTL_enabled = \Illuminate\Support\Facades\App::getLocale() === 'ar' ? 'rtl' : '';
?>

<!DOCTYPE html>
<html lang="en" direction="{{ $is_RTL_enabled ?? '' }}" dir="{{ $is_RTL_enabled ?? '' }}" style="direction: {{ $is_RTL_enabled ?? '' }}">
<head>
    <base href="">
    <meta charset="utf-8"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    @include('layouts.style')
</head>
@php $current = \Route::currentRouteName(); @endphp

<body id="kt_body"
      class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading {{ isset($current) && in_array($current, ['pos.create', 'reports.sales']) ? 'aside-minimize' : '' }}">

@include('layouts.header')

<div class="d-flex flex-column flex-root">
    <div class="d-flex flex-row flex-column-fluid page">
        @include('layouts.sidebar')
        <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
            @include('layouts.header_content')
            <div class="content pt-0 d-flex flex-column flex-column-fluid" id="kt_content">
                @yield('content')
            </div>
            @include('layouts.footer')
        </div>
    </div>
</div>

<div id="kt_quick_user" class="offcanvas offcanvas-right p-10">
    <div class="offcanvas-header d-flex align-items-center justify-content-between pb-5">
        <h3 class="font-weight-bold m-0">{{ __('locale.navigation_bar.user_profile') }}</h3>
        <a href="javascript:void(0);" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_user_close">
            <i class="ki ki-close icon-xs text-muted"></i>
        </a>
    </div>

    <div class="offcanvas-content pr-5 mr-n5">
        <div class="d-flex align-items-center mt-5">
            <div class="symbol symbol-100 mr-5">
                <div class="symbol-label" style="background-image:url({{ asset('theme/media/blank.png') }})"></div>
            </div>
            <div class="d-flex flex-column">
                <a href="javascript:void(0);" class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary">
                    {{ ucwords(auth()->user()->name ?? 'Guest') }}
                </a>
                <div class="navi mt-2">
                    <a href="mailto:{{ auth()->user()->email ?? '' }}" class="navi-item mb-3">
                        <span class="navi-text text-muted text-hover-primary">
                            {{ auth()->user()->email ?? '-' }}
                        </span>
                    </a>

                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();"
                       class="btn btn-sm btn-light-primary py-2 px-5"
                    >Sign Out</a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
        <div class="navi navi-spacer-x-0 p-0 mt-10">
            <a href="{{ route('profile') }}" class="navi-item">
                <div class="navi-link">
                    <div class="navi-text">
                        <div class="font-weight-bold">{{ __('locale.navigation_bar.my_profile') }}</div>
                        <div class="text-muted">{{ __('locale.navigation_bar.my_profile_placeholder') }}</div>
                    </div>
                </div>
            </a>
        </div>
        <div class="separator separator-dashed border-dark mt-5 mb-5"></div>
        <div class="navi navi-spacer-x-0 p-0">
            <a href="{{ route('change_password') }}" class="navi-item">
                <div class="navi-link">
                    <div class="navi-text">
                        <div class="font-weight-bold">{{ __('locale.navigation_bar.change_password') }}</div>
                        <div class="text-muted">{{ __('locale.navigation_bar.change_password_placeholder') }}</div>
                    </div>
                </div>
            </a>
        </div>
        <?php $organizations = \App\Providers\FormList::getOrganizations(auth()->user()); ?>
        @if(count($organizations) > 0)
            <div class="separator separator-dashed border-dark mt-5 mb-5"></div>
            <div class="navi navi-spacer-x-0 p-0 mt-3 cursor-pointer">
                <div class="navi-link">
                    <div class="navi-text">
                        <div class="font-weight-bold">{{ __('locale.navigation_bar.organizations') }}</div>
                        <div class="text-muted">{{ __('locale.navigation_bar.organizations_placeholder') }}
                        </div>
                        <div class="mt-5 ml-5">
                            @foreach($organizations as $organization)
                                <div class="mt-3">
                                    <a href="javascript:void(0);" data-organization-id="{{ $organization->id }}"
                                       class="organization_selection text-hover-primary {{ session()->has('organization_id') && session()->get('organization_id') == $organization->id ? 'text-primary' : 'text-dark' }}">
                                        <span class="mr-2">-</span>
                                        {{ $organization->name }}
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@include('layouts.scroll_top')
@include('layouts.script')
@yield('page_js')
</body>
</html>
