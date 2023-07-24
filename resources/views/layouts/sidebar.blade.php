@php $current = \Route::currentRouteName(); @endphp

<div class="aside aside-left aside-fixed d-flex flex-column flex-row-auto" id="kt_aside">
    <div class="brand flex-column-auto {{ $current === 'home' ? 'h-auto' : '' }}" id="kt_brand">
        @if($current === 'home')
            @if(!empty($configuration['actual_logo']) && !empty($configuration['name']))
                <a href="{{ route('home') }}" class="brand-logo">
                    <img
                        src="{{ config('constants.s3.asset_url') . $configuration['actual_logo'] }}"
                        alt="{{ $configuration['name'] }}"
                        style="margin-top: 10px;margin-bottom: 10px;max-width: 150px;">
                </a>
            @endif
        @else
            @if(!empty($configuration['name']))
                <a href="{{ route('home') }}" class="brand-logo">
                    <span class="text-white font-size-h5">
                        {{ $configuration['name'] }}
                    </span>
                </a>
            @endif
        @endif

        <button class="brand-toggle btn btn-sm px-0 {{ $current === 'customer_subscriptions.show' ? 'active' : '' }}"
                id="kt_aside_toggle">
            <span class="svg-icon svg-icon svg-icon-xl">
                @include('svg.aside_toggle')
            </span>
        </button>
    </div>

    <div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
        <div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1"
             data-menu-dropdown-timeout="500">
            <ul class="menu-nav">
                <li class="menu-item {{ get_active_class($current, ['home']) }}" aria-haspopup="true">
                    <a href="{{ route('home') }}" class="menu-link">
                        @include('svg.miscellaneous')
                        <span class="menu-text">{{ __('locale.sidebar.dashboard') }}</span>
                    </a>
                </li>

                {{-- @if ($is_root_user == 1 || in_array('pos.create', $accesses_urls))
                    <li class="menu-item {{ get_active_class($current, ['pos.create']) }}" aria-haspopup="true"
                        data-menu-toggle="hover">
                        <a href="{{ route('pos.create') }}" class="menu-link menu-toggle" id="pos-screen">
                            @include('svg.miscellaneous')
                            <span class="menu-text">{{ __('locale.sidebar.pos') }}</span>
                        </a>
                    </li>
                @endif --}}

                <hr>

                {{-- @if($is_root_user == 1 || in_array('service_types.index', $accesses_urls))
                    <li class="menu-item {{ get_active_class($current, ['service_types.index', 'service_types.edit', 'service_types.create', 'service_types.show']) }}"
                        aria-haspopup="true">
                        <a href="{{ route('service_types.index') }}" class="menu-link">
                            @include('svg.miscellaneous')
                            <span class="menu-text">{{ __('locale.sidebar.service_types') }}</span>
                        </a>
                    </li>
                @endif --}}

                {{-- @if($is_root_user == 1 || in_array('service_categories.index', $accesses_urls))
                    <li class="menu-item {{ get_active_class($current, ['service_categories.index', 'service_categories.edit', 'service_categories.create', 'service_categories.show']) }}"
                        aria-haspopup="true">
                        <a href="{{ route('service_categories.index') }}" class="menu-link">
                            @include('svg.miscellaneous')
                            <span class="menu-text">{{ __('locale.sidebar.product_and_service_category') }}</span>
                        </a>
                    </li>
                @endif --}}

                {{-- @if($is_root_user == 1 || in_array('services.index', $accesses_urls))
                    <li class="menu-item {{ get_active_class($current, ['services.index', 'services.edit', 'services.create', 'services.show']) }}"
                        aria-haspopup="true">
                        <a href="{{ route('services.index') }}" class="menu-link">
                            @include('svg.miscellaneous')
                            <span class="menu-text">{{ __('locale.sidebar.products_and_services') }}</span>
                        </a>
                    </li>
                @endif --}}

                {{-- @if($is_root_user == 1 || in_array('inventories.index', $accesses_urls))
                    <li class="menu-item {{ get_active_class($current, ['inventories.index', 'inventories.create', 'inventories.show']) }}"
                        aria-haspopup="true">
                        <a href="{{ route('inventories.index') }}" class="menu-link">
                            @include('svg.miscellaneous')
                            <span class="menu-text">{{ __('locale.sidebar.inventories') }}</span>
                        </a>
                    </li>
                @endif --}}

                {{-- @if($is_root_user == 1 || in_array('purchase_inventories.index', $accesses_urls))
                    <li class="menu-item {{ get_active_class($current, ['purchase_inventories.index', 'purchase_inventories.create', 'purchase_inventories.show']) }}"
                        aria-haspopup="true">
                        <a href="{{ route('purchase_inventories.index') }}" class="menu-link">
                            @include('svg.miscellaneous')
                            <span class="menu-text">{{ __('locale.sidebar.purchase_inventories') }}</span>
                        </a>
                    </li>
                @endif --}}

                {{-- @if($is_root_user == 1
                        || (in_array('service_categories.index', $accesses_urls)
                        ||  in_array('services.index', $accesses_urls)
                        ||  in_array('inventories.index', $accesses_urls)
                        ||  in_array('purchase_inventories.index', $accesses_urls)
                ))
                    <hr>
                @endif --}}

                {{-- @if ($is_root_user == 1 ||
                    (in_array('expenses.index', $accesses_urls)
                        || in_array('expense_categories.index', $accesses_urls)
                ))
                    <li class="menu-item menu-item-submenu {{ get_open_class($current, [
                        'expense_categories.index', 'expense_categories.edit', 'expense_categories.create', 'expense_categories.show',
                        'expenses.index', 'expenses.edit', 'expenses.create', 'expenses.show',
                    ]) }}"
                        aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            @include('svg.miscellaneous')
                            <span class="menu-text">{{ __('locale.sidebar.expense_management.title') }}</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item menu-item-parent" aria-haspopup="true">
                                    <span class="menu-link">
                                        <span
                                            class="menu-text">{{ __('locale.sidebar.expense_management.title') }}</span>
                                    </span>
                                </li>

                                @if($is_root_user == 1 || in_array('expense_categories.index', $accesses_urls))
                                    <li class="menu-item {{ get_active_class($current, ['expense_categories.index', 'expense_categories.edit', 'expense_categories.create', 'expense_categories.show']) }}"
                                        aria-haspopup="true" data-menu-toggle="hover">
                                        <a href="{{ route('expense_categories.index') }}" class="menu-link menu-toggle">
                                            <i class="menu-bullet menu-bullet-line">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text">{{ __('locale.sidebar.expense_management.expense_categories') }}</span>
                                        </a>
                                    </li>
                                @endif

                                @if($is_root_user == 1 || in_array('expenses.index', $accesses_urls))
                                    <li class="menu-item {{ get_active_class($current, ['expenses.index', 'expenses.edit', 'expenses.create', 'expenses.show']) }}"
                                        aria-haspopup="true" data-menu-toggle="hover">
                                        <a href="{{ route('expenses.index') }}" class="menu-link menu-toggle">
                                            <i class="menu-bullet menu-bullet-line">
                                                <span></span>
                                            </i>
                                            <span
                                                class="menu-text">{{ __('locale.sidebar.expense_management.expense_voucher') }}</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif --}}

                @if ($is_root_user == 1 ||
                    (in_array('users.index', $accesses_urls)
                        // || in_array('customers.index', $accesses_urls)
                        // || in_array('holidays.index', $accesses_urls)
                        // || in_array('suppliers.index', $accesses_urls)
                        // || in_array('coupons.index', $accesses_urls)
                        || in_array('companies.index', $accesses_urls)
                        // || in_array('banners.index', $accesses_urls)
                        || in_array('pages.index', $accesses_urls)
                ))
                    <li class="menu-item menu-item-submenu
                        {{ get_open_class($current, [
                            'users.index', 'users.edit', 'users.create', 'users.show',
                            'customers.index', 'customers.edit', 'customers.create', 'customers.show',
                            // 'holidays.index', 'holidays.edit', 'holidays.create', 'holidays.show',
                            // 'suppliers.index', 'suppliers.edit', 'suppliers.create', 'suppliers.show',
                            // 'coupons.index', 'coupons.edit', 'coupons.create', 'coupons.show',
                            'companies.index', 'companies.edit', 'companies.create', 'companies.show',
                            // 'banners.index', 'banners.edit', 'banners.create', 'banners.show',
                            'pages.index', 'pages.edit', 'pages.create', 'pages.show',
                        ]) }}"
                        aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            @include('svg.miscellaneous')
                            <span class="menu-text">{{ __('locale.sidebar.masters.title') }}</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item menu-item-parent" aria-haspopup="true">
                                    <span class="menu-link">
                                        <span class="menu-text">{{ __('locale.sidebar.masters.title') }}</span>
                                    </span>
                                </li>

                                @if ($is_root_user == 1 || in_array('users.index', $accesses_urls))
                                    <li class="menu-item {{ get_active_class($current, ['users.index', 'users.edit', 'users.create', 'users.show']) }}"
                                        aria-haspopup="true" data-menu-toggle="hover">
                                        <a href="{{ route('users.index') }}" class="menu-link menu-toggle">
                                            <i class="menu-bullet menu-bullet-line">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">{{ __('locale.sidebar.masters.users') }}</span>
                                        </a>
                                    </li>
                                @endif

                                @if ($is_root_user == 1 || in_array('customers.index', $accesses_urls))
                                    <li class="menu-item {{ get_active_class($current, ['customers.index', 'customers.edit', 'customers.create', 'customers.show']) }}"
                                        aria-haspopup="true" data-menu-toggle="hover">
                                        <a href="{{ route('customers.index') }}" class="menu-link menu-toggle">
                                            <i class="menu-bullet menu-bullet-line">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">{{ __('locale.sidebar.masters.customers') }}</span>
                                        </a>
                                    </li>
                                @endif

                                {{-- @if ($is_root_user == 1 || in_array('holidays.index', $accesses_urls))
                                    <li class="menu-item {{ get_active_class($current, ['holidays.index', 'holidays.edit', 'holidays.create', 'holidays.show']) }}"
                                        aria-haspopup="true" data-menu-toggle="hover">
                                        <a href="{{ route('holidays.index') }}" class="menu-link menu-toggle">
                                            <i class="menu-bullet menu-bullet-line">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">{{ __('locale.sidebar.masters.holidays') }}</span>
                                        </a>
                                    </li>
                                @endif --}}

                                {{-- @if($is_root_user == 1 || in_array('suppliers.index', $accesses_urls))
                                    <li class="menu-item {{ get_active_class($current, ['suppliers.index', 'suppliers.edit', 'suppliers.create', 'suppliers.show']) }}"
                                        aria-haspopup="true" data-menu-toggle="hover">
                                        <a href="{{ route('suppliers.index') }}" class="menu-link menu-toggle">
                                            <i class="menu-bullet menu-bullet-line">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">{{ __('locale.sidebar.masters.suppliers') }}</span>
                                        </a>
                                    </li>
                                @endif --}}

                                {{-- @if ($is_root_user == 1 || in_array('coupons.index', $accesses_urls))
                                    <li class="menu-item {{ get_active_class($current, ['coupons.index', 'coupons.edit', 'coupons.create', 'coupons.show']) }}"
                                        aria-haspopup="true" data-menu-toggle="hover">
                                        <a href="{{ route('coupons.index') }}" class="menu-link menu-toggle">
                                            <i class="menu-bullet menu-bullet-line">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">{{ __('locale.sidebar.masters.coupons') }}</span>
                                        </a>
                                    </li>
                                @endif --}}

                                @if($is_root_user == 1 || in_array('companies.index', $accesses_urls))
                                    <li class="menu-item {{ get_active_class($current, ['companies.index', 'companies.edit', 'companies.create', 'companies.show']) }}"
                                        aria-haspopup="true" data-menu-toggle="hover">
                                        <a href="{{ route('companies.index') }}"
                                           class="menu-link menu-toggle">
                                            <i class="menu-bullet menu-bullet-line">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">{{ __('locale.sidebar.masters.companies') }}</span>
                                        </a>
                                    </li>
                                @endif

                                {{-- @if ($is_root_user == 1 || in_array('banners.index', $accesses_urls))
                                    <li class="menu-item {{ get_active_class($current, ['banners.index', 'banners.edit', 'banners.create', 'banners.show']) }}"
                                        aria-haspopup="true" data-menu-toggle="hover">
                                        <a href="{{ route('banners.index') }}" class="menu-link menu-toggle">
                                            <i class="menu-bullet menu-bullet-line">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">{{ __('locale.sidebar.masters.banners') }}</span>
                                        </a>
                                    </li>
                                @endif --}}

                                @if ($is_root_user == 1 || in_array('pages.index', $accesses_urls))
                                    <li class="menu-item {{ get_active_class($current, ['pages.index', 'pages.edit', 'pages.create', 'pages.show']) }}"
                                        aria-haspopup="true" data-menu-toggle="hover">
                                        <a href="{{ route('pages.index') }}" class="menu-link menu-toggle">
                                            <i class="menu-bullet menu-bullet-line">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">{{ __('locale.sidebar.masters.cms_pages') }}</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif

                {{-- @if($is_root_user == 1
                    || (in_array('notification_templates.index', $accesses_urls)
                        || in_array('notification.send', $accesses_urls)
                    ))
                    <li class="menu-item menu-item-submenu
                        {{ get_open_class($current, [
                            'notification_templates.index', 'notification_templates.edit', 'notification_templates.create',
                            'notification_templates.show', 'notification.send', 'notification.scheduled'
                        ]) }}"
                        aria-haspopup="true"
                        data-menu-toggle="hover">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            @include('svg.miscellaneous')
                            <span class="menu-text">{{ __('locale.sidebar.notifications.title') }}</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item menu-item-parent" aria-haspopup="true">
                                    <span class="menu-link">
                                        <span class="menu-text">{{ __('locale.sidebar.notifications.title') }}</span>
                                    </span>
                                </li>

                                @if ($is_root_user == 1 || in_array('notification_templates.index', $accesses_urls))
                                    <li class="menu-item {{ get_active_class($current, ['notification_templates.index', 'notification_templates.edit', 'notification_templates.create', 'notification_templates.show']) }}"
                                        aria-haspopup="true" data-menu-toggle="hover">
                                        <a href="{{ route('notification_templates.index') }}"
                                           class="menu-link menu-toggle">
                                            <i class="menu-bullet menu-bullet-line">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">
                                                {{ __('locale.sidebar.notifications.notification_templates') }}
                                            </span>
                                        </a>
                                    </li>
                                @endif

                                @if($is_root_user == 1 || in_array('notification.send', $accesses_urls))
                                    <li class="menu-item {{ get_active_class($current, ['notification.send', 'notification.scheduled']) }}"
                                        aria-haspopup="true" data-menu-toggle="hover">
                                        <a href="{{ route('notification.send') }}" class="menu-link menu-toggle">
                                            <i class="menu-bullet menu-bullet-line">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">
                                                {{ __('locale.sidebar.notifications.notification_send') }}
                                            </span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif --}}

                {{-- @if ($is_root_user == 1
                        || in_array('day_closings.index', $accesses_urls)
                        || in_array('reports.sales', $accesses_urls)
                        || in_array('reports.ticket_types', $accesses_urls)
                        || in_array('reports.payment_types', $accesses_urls)
                        || in_array('reports.cancel_booking', $accesses_urls)
                )
                    <li class="menu-item menu-item-submenu
                        {{ get_open_class($current, [
                            'day_closings.index', 'day_closings.generate', 'day_closings.details',
                            'reports.sales',
                            'reports.ticket_types',
                            'reports.payment_types',
                            'reports.cancel_booking'
                        ]) }}"
                        aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            @include('svg.miscellaneous')
                            <span class="menu-text">{{ __('locale.sidebar.reports.title') }}</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item menu-item-parent" aria-haspopup="true">
                                    <span class="menu-link">
                                        <span class="menu-text">{{ __('locale.sidebar.reports.title') }}</span>
                                    </span>
                                </li>
                                @if($is_root_user == 1 || in_array('day_closings.index', $accesses_urls))
                                    <li class="menu-item {{ get_active_class($current, ['day_closings.index', 'day_closings.generate', 'day_closings.details']) }}"
                                        aria-haspopup="true" data-menu-toggle="hover">
                                        <a href="{{ route('day_closings.index') }}"
                                        class="menu-link menu-toggle d-flex align-items-center">
                                            <i class="menu-bullet menu-bullet-line">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">
                                                {{ auth()->user()->group_id === 4 ? 'My ' : '' }}
                                                {{ __('locale.sidebar.reports.day_close_report') }}
                                            </span>
                                        </a>
                                    </li>
                                @endif
                                @if($is_root_user == 1 || in_array('reports.sales', $accesses_urls))
                                    <li class="menu-item {{ get_active_class($current, ['reports.sales']) }}"
                                        aria-haspopup="true" data-menu-toggle="hover">
                                        <a href="{{ route('reports.sales') }}"
                                        class="menu-link menu-toggle d-flex align-items-center">
                                            <i class="menu-bullet menu-bullet-line">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">
                                                {{ auth()->user()->group_id === 4 ? 'My ' : '' }}
                                                {{ __('locale.sidebar.reports.sales_details_report') }}
                                            </span>
                                        </a>
                                    </li>
                                @endif
                                @if($is_root_user == 1 || in_array('reports.ticket_types', $accesses_urls))
                                    <li class="menu-item {{ get_active_class($current, ['reports.ticket_types']) }}"
                                        aria-haspopup="true" data-menu-toggle="hover">
                                        <a href="{{ route('reports.ticket_types') }}"
                                        class="menu-link menu-toggle d-flex align-items-center">
                                            <i class="menu-bullet menu-bullet-line">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">
                                                {{ auth()->user()->group_id === 4 ? 'My ' : '' }}
                                                {{ __('locale.sidebar.reports.sales_by_tickets_type') }}
                                            </span>
                                        </a>
                                    </li>
                                @endif
                                @if($is_root_user == 1 || in_array('reports.payment_types', $accesses_urls))
                                    <li class="menu-item {{ get_active_class($current, ['reports.payment_types']) }}"
                                        aria-haspopup="true" data-menu-toggle="hover">
                                        <a href="{{ route('reports.payment_types') }}"
                                        class="menu-link menu-toggle d-flex align-items-center">
                                            <i class="menu-bullet menu-bullet-line">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">
                                                {{ auth()->user()->group_id === 4 ? 'My ' : '' }}
                                                {{ __('locale.sidebar.reports.payment_type') }}
                                            </span>
                                        </a>
                                    </li>
                                @endif
                                @if($is_root_user == 1 || in_array('reports.cancel_booking', $accesses_urls))
                                    <li class="menu-item {{ get_active_class($current, ['reports.cancel_booking']) }}"
                                        aria-haspopup="true" data-menu-toggle="hover">
                                        <a href="{{ route('reports.cancel_booking') }}"
                                        class="menu-link menu-toggle d-flex align-items-center">
                                            <i class="menu-bullet menu-bullet-line">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">
                                                {{ auth()->user()->group_id === 4 ? 'My ' : '' }}
                                                {{ __('locale.sidebar.reports.cancel_booking') }}
                                            </span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif --}}

                @if($is_root_user == 1
                        || (in_array('organizations.index', $accesses_urls)
                        ||  in_array('groups.index', $accesses_urls)
                        ||  in_array('configurations.index', $accesses_urls))
                    )
                    <hr>
                @endif

                @if ($is_root_user == 1 || in_array('organizations.index', $accesses_urls))
                    <li class="menu-item {{ get_active_class($current, ['organizations.index', 'organizations.edit', 'organizations.create', 'organizations.show']) }}"
                        aria-haspopup="true" data-menu-toggle="hover">
                        <a href="{{ route('organizations.index') }}" class="menu-link menu-toggle">
                            @include('svg.miscellaneous')
                            <span class="menu-text">{{ __('locale.sidebar.organizations') }}</span>
                        </a>
                    </li>
                @endif

                @if ($is_root_user == 1 || in_array('groups.index', $accesses_urls))
                    <li class="menu-item {{ get_active_class($current, ['groups.index', 'groups.edit', 'groups.create', 'groups.show']) }}"
                        aria-haspopup="true" data-menu-toggle="hover">
                        <a href="{{ route('groups.index') }}" class="menu-link menu-toggle">
                            @include('svg.miscellaneous')
                            <span class="menu-text">{{ __('locale.sidebar.user_groups') }}</span>
                        </a>
                    </li>
                @endif

                @if ($is_root_user == 1 || in_array('configurations.index', $accesses_urls))
                    <li class="menu-item {{ get_active_class($current, ['configurations.index']) }}"
                        aria-haspopup="true" data-menu-toggle="hover">
                        <a href="{{ route('configurations.index') }}" class="menu-link menu-toggle">
                            @include('svg.miscellaneous')
                            <span class="menu-text">{{ __('locale.sidebar.configurations') }}</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>
