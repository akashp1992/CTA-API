<?php $organization_id = session()->get('organization_id', 0); ?>

<div class="row">
    <div class="col-md-4">
        <div class="card card-custom gutter-b">
            <div class="card-header flex-wrap py-3">
                <div class="card-title">
                    <h3 class="card-label">{{ __('locale.statistics.administrative.title') }}</h3>
                </div>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap pl-0 pr-0">
                        <span class="font-weight-bold">{{ __('locale.statistics.administrative.organizations') }}</span>
                        <span class="font-weight-bold text-secondary">
                            {{ \App\Models\Organization::get()->count() }}
                        </span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap pl-0 pr-0">
                        <span class="font-weight-bold">{{ __('locale.statistics.administrative.user_groups') }}</span>
                        <span class="font-weight-bold text-secondary">
                            {{ \App\Models\Group::get()->count() }}
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-custom gutter-b">
            <div class="card-header flex-wrap py-3">
                <div class="card-title">
                    <h3 class="card-label">{{ __('locale.statistics.others.title') }}</h3>
                </div>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap pl-0 pr-0">
                        <span class="font-weight-bold">{{ __('locale.statistics.others.users') }}</span>
                        <span class="font-weight-bold text-secondary">
                            {{ \App\Models\User::get()
                                    ->where('organization_id', session()->get('organization_id'))
                                    ->where('is_active', 1)
                                    ->count() }}
                        </span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap pl-0 pr-0">
                        <span class="font-weight-bold">{{ __('locale.statistics.others.cms_pages') }}</span>
                        <span class="font-weight-bold text-secondary">
                            {{ \App\Models\Page::where('organization_id', session()->get('organization_id'))
                                    ->get()
                                    ->count() }}
                        </span>
                    </li>
                    {{-- <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap pl-0 pr-0">
                        <span class="font-weight-bold">{{ __('locale.statistics.others.product_and_service_category') }}</span>
                        <span class="font-weight-bold text-secondary">
                            @if(auth()->user()->is_root_user == 1)
                                {{ \App\Models\ServiceCategory::where([['is_active', 1],['organization_id', $organization_id]])->get()->count() }}
                            @else
                                {{ \App\Models\ServiceCategory::join('organizations', 'service_categories.organization_id', '=', 'organizations.id')->where([
                                    ['service_categories.is_active', 1], ['organizations.id', auth()->user()->organization_id]
                                ])->count() }}
                            @endif
                        </span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap pl-0 pr-0">
                        <span class="font-weight-bold">{{ __('locale.statistics.others.products_and_services') }}</span>
                        <span class="font-weight-bold text-secondary">
                            @if(auth()->user()->is_root_user == 1)
                                {{ \App\Models\Service::where([['is_active', 1],['organization_id', $organization_id]])->get()->count() }}
                            @else
                                {{
                                    \App\Models\Service::join('organizations', 'services.organization_id', '=', 'organizations.id')->where([
                                    ['services.is_active', 1], ['organizations.id', auth()->user()->organization_id]
                                    ])->count()
                                }}
                            @endif
                        </span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap pl-0 pr-0">
                        <span class="font-weight-bold">{{ __('locale.statistics.others.coupons') }}</span>
                        <span class="font-weight-bold text-secondary">
                            {{ \App\Models\Coupon::where('organization_id', session()->get('organization_id'))
                                    ->get()
                                    ->count() }}
                        </span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap pl-0 pr-0">
                        <span class="font-weight-bold">{{ __('locale.statistics.others.banners') }}</span>
                        <span class="font-weight-bold text-secondary">
                            {{ \App\Models\Banner::where('organization_id', session()->get('organization_id'))
                                    ->get()
                                    ->count() }}
                        </span>
                    </li> --}}
                </ul>
            </div>
        </div>
    </div>
    {{-- <div class="col-md-4">
        <div class="card card-custom gutter-b">
            <div class="card-header flex-wrap py-3">
                <div class="card-title">
                    <h3 class="card-label">{{ __('locale.statistics.revenue.title') }}</h3>
                </div>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap pl-0 pr-0">
                        <span class="font-weight-bold">{{ __('locale.statistics.revenue.sales_by_services') }}</span>
                        <span class="font-weight-bold text-secondary">
                            {{ $sales_by_services ?? 0 }}
                        </span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap pl-0 pr-0">
                        <span class="font-weight-bold">{{ __('locale.statistics.revenue.sales_by_products') }}</span>
                        <span class="font-weight-bold text-secondary">
                            {{ $sales_by_products ?? 0 }}
                        </span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap pl-0 pr-0">
                        <span class="font-weight-bold">{{ __('locale.statistics.revenue.sales_by_gift_vouchers') }}</span>
                        <span class="font-weight-bold text-secondary">
                            {{ $sales_by_gift_vouchers ?? 0 }}
                        </span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap pl-0 pr-0">
                        <span class="font-weight-bold">{{ __('locale.statistics.revenue.trampoline') }}</span>
                        <span class="font-weight-bold text-secondary">
                            {{ \App\Models\Service::where([['is_active', 1], ['service_type', 'trampoline']])->get(['id'])->count() }}
                        </span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap pl-0 pr-0">
                        <span class="font-weight-bold">{{ __('locale.statistics.revenue.playground') }}</span>
                        <span class="font-weight-bold text-secondary">
                            {{ \App\Models\Service::where([['is_active', 1], ['service_type', 'playground']])->get(['id'])->count() }}
                        </span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap pl-0 pr-0">
                        <span class="font-weight-bold">{{ __('locale.statistics.revenue.both') }}</span>
                        <span class="font-weight-bold text-secondary">
                            {{ \App\Models\Service::where([['is_active', 1], ['service_type', 'both']])->get(['id'])->count() }}
                        </span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap pl-0 pr-0">
                        <span class="font-weight-bold">{{ __('locale.statistics.revenue.total_cash') }}</span>
                        <span class="font-weight-bold text-secondary">
                            {{ number_format((float)round($total_cash ?? 0), 3, '.', '') }}
                        </span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap pl-0 pr-0">
                        <span class="font-weight-bold">{{ __('locale.statistics.revenue.total_knet') }}</span>
                        <span class="font-weight-bold text-secondary">
                            {{ number_format((float)round($total_knet ?? 0), 3, '.', '') }}
                        </span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap pl-0 pr-0">
                        <span class="font-weight-bold">{{ __('locale.statistics.revenue.todays_bookings') }}</span>
                        <span class="font-weight-bold text-secondary">
                            {{ $todays_booking ?? 0 }}
                        </span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap pl-0 pr-0">
                        <span class="font-weight-bold">{{ __('locale.statistics.revenue.tomorrows_bookings') }}</span>
                        <span class="font-weight-bold text-secondary">
                            {{ $tomorrows_booking ?? 0 }}
                        </span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap pl-0 pr-0">
                        <span class="font-weight-bold">{{ __('locale.statistics.revenue.total_sales') }}</span>
                        <span class="font-weight-bold text-secondary">
                            {{ number_format((float)round($total_sales ?? 0), 3, '.', '') }}
                        </span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap pl-0 pr-0">
                        <span class="font-weight-bold">{{ __('locale.statistics.revenue.Other_sales') }}</span>
                        <span class="font-weight-bold text-secondary">
                            {{ $other_sales ?? 0 }}
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </div> --}}
</div>
