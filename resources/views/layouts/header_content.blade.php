<div id="kt_header" class="header header-fixed">
    <div class="container-fluid d-flex align-items-stretch justify-content-between">
        <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
            <div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
                <div class="d-flex justify-content-center align-items-center">
                    <ul class="menu-nav">
                        <li class="menu-item menu-item-open menu-item-submenu menu-item-rel menu-item-open menu-item-active"
                            data-menu-toggle="click" aria-haspopup="true">
                            <a href="javascript:void(0);" class="menu-link menu-toggle">
                                <span class="menu-text">Quick Access Links</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="menu-submenu menu-submenu-classic menu-submenu-left">
                                <ul class="menu-subnav">

                                    {{-- @if ($is_root_user == 1 || in_array('notes.index', $accesses_urls))
                                        <li class="menu-item {{ get_active_class($current, ['notes.index', 'notes.edit', 'notes.create', 'notes.show']) }}"
                                            aria-haspopup="true">
                                            <a href="{{ route('notes.index') }}" class="menu-link">
                                                @include('svg.miscellaneous')
                                                <span class="menu-text">Sticky Notes</span>
                                            </a>
                                        </li>
                                    @endif

                                    @if ($is_root_user == 1 || in_array('day_closings.generate', $accesses_urls))
                                        <li class="menu-item {{ get_active_class($current, ['day_closings.generate']) }}"
                                            aria-haspopup="true">
                                            <a href="{{ route('day_closings.generate') }}" class="menu-link">
                                                @include('svg.miscellaneous')
                                                <span class="menu-text">Day Close Report</span>
                                            </a>
                                        </li>
                                    @endif --}}
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="topbar">
            <?php
                $organization = session()->get('organization');
                $is_RTL_enabled = isset($organization) && $organization->is_RTL_enabled === 1;
            ?>
            @if($is_root_user == 1)
                <div class="dropdown">
                    <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px" aria-expanded="false">
                        <div class="btn btn-icon btn-clean btn-dropdown btn-lg mr-1">
                            <form action="{{ route('backup_database') }}" method="get">
                                <button class="btn"> <i class="fa fa-database text-primary"></i> </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
            @if($is_RTL_enabled)
                <div class="dropdown">
                    <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px" aria-expanded="false">
                        <div class="btn btn-icon btn-clean btn-dropdown btn-lg mr-1">
                            <img class="h-20px w-20px rounded-sm"
                                 src="{{ \Illuminate\Support\Facades\App::getLocale() === 'en'
                                        ? asset('images/svgs/flags/226-united-states.svg')
                                        : asset('images/svgs/flags/107-kwait.svg') }}"
                                 alt="">
                        </div>
                    </div>

                    <div class="dropdown-menu p-0 m-0 dropdown-menu-anim-up dropdown-menu-sm dropdown-menu-right"
                         style="">
                        <ul class="navi navi-hover py-4">
                            <li class="navi-item">
                                <a href="javascript:void(0);" class="navi-link set_locale" data-locale="en">
                                <span class="symbol symbol-20 mr-3">
                                    <img src="{{ asset('images/svgs/flags/226-united-states.svg') }}" alt="">
                                </span>
                                    <span class="navi-text">English</span>
                                </a>
                            </li>

                            <li class="navi-item active">
                                <a href="javascript:void(0);" class="navi-link set_locale" data-locale="ar">
                                <span class="symbol symbol-20 mr-3">
                                    <img src="{{ asset('images/svgs/flags/107-kwait.svg') }}" alt="">
                                </span>
                                    <span class="navi-text">Arabic</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            @endif
            <div class="topbar-item">
                <div class="btn btn-icon btn-icon-mobile w-auto btn-clean d-flex align-items-center btn-lg px-2"
                     id="kt_quick_user_toggle">
                    <span class="text-dark-75 font-weight-bold mr-2">Hi,</span>
                    <span class="text-dark-50 font-weight-bolder font-size-base d-md-inline mr-3">
                        {{ ucwords(auth()->user()->name ?? '') }}
                        {{ ' ( ' . auth()->user()->group->name . ' ) ' ?? '' }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
