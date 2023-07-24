<?php

namespace App\Providers;

use App\Models\Customer;
use App\Models\ExpenseCategory;
use App\Models\Expense;
use App\Models\Group;
use App\Models\Company;
use App\Models\NotificationTemplate;
use App\Models\Organization;
use App\Models\Pos;
use App\Models\ServiceCategory;
use App\Models\Service;
use App\Models\ServiceType;
use App\Models\User;
use App\Models\Coupon;
use App\Models\Booking;
use App\Models\Inventory;
use App\Models\Supplier;
use Illuminate\Support\ServiceProvider;

use Carbon\Carbon;

class FormList extends ServiceProvider
{
    public static function getUsers()
    {
        return User::where('is_active', 1)
            ->where('organization_id', session()->get('organization_id'))
            ->get();
    }

    public static function getUserName($id)
    {
        return User::whereId($id)
            ->where('organization_id', session()->get('organization_id'))
            ->value('name');
    }

    public static function getGroups()
    {
        return Group::where('is_active', 1)->pluck('name', 'id')->toArray();
    }

    public static function getCustomers()
    {
        return Customer::where('is_active', 1)
            ->where('organization_id', session()->get('organization_id'))
            ->get();
    }

    public static function getRestrictedCustomers()
    {
        return Customer::where('is_active', 1)->where('organization_id', session()->get('organization_id'))->pluck('phone', 'id')->toArray();
    }

    public static function getDays()
    {
        return ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
    }

    public static function getTimeZones()
    {
        $timezones = [];
        $zones     = timezone_identifiers_list();
        foreach ($zones as $zone) {
            $exploded_zone = explode('/', $zone);
            if (in_array($exploded_zone[0], ['Africa', 'America', 'Antarctica', 'Arctic', 'Asia', 'Atlantic', 'Australia', 'Europe', 'Indian', 'Pacific'])) {
                if (isset($exploded_zone[1]) != '') {
                    $timezones[ $exploded_zone[0] ][] = $zone;
                }
            }
        }

        return $timezones;
    }

    public static function getOrganizations($auth_user)
    {
        $organization = new Organization();

        $organizations = collect();
        if ($auth_user->is_root_user == 1 || in_array(1, [$auth_user->group_id])) {
            $organizations = $organization
                ->where('is_active', 1)
                ->get();
        } else {
            $organizations = $organization
                ->where('id', $auth_user->organization_id)
                ->where('is_active', 1)
                ->get();
        }

        return $organizations;
    }

    public static function getServiceCategories()
    {
        return ServiceCategory::where('is_active', 1)
            ->where('organization_id', session()->get('organization_id'))
            ->pluck('name', 'id')
            ->toArray();
    }

    public static function getItemCategoriesDropdownByType($category_type)
    {
        $service_category = new ServiceCategory();
        return $service_category
            ->where([
                ['is_active', 1],
                ['category_type', $category_type],
                ['organization_id', session()->get('organization_id')]
            ])
            ->get();
    }

    public static function getExpenseCategories()
    {
        return ExpenseCategory::where('is_active', 1)
            ->where([
                ['organization_id', session()->get('organization_id')],
            ])
            ->pluck('name', 'id')
            ->toArray();
    }

    public static function getHolidayTypes($type = null)
    {
        $types = [
            'HOLIDAY'         => 'Holiday',
            'LEAVE'           => 'Leave',
            'ABSENT'          => 'Absent',
            'WORKING_HOLIDAY' => 'Working Holiday',
            'NO_SHOW'         => 'No Show',
            'VACATION'        => 'Vacation',
            'HALFDAY'         => 'Half Day'
        ];
        if (!empty($type)) {
            return $types[ $type ];
        }
        return $types;
    }

    public static function getHolidayLeaves($leave = null)
    {
        $leaves = [
            'FULLDAY'    => 'Full Day',
            'FIRSTHALF'  => 'First Half',
            'SECONDHALF' => 'Second Half'
        ];
        if (!empty($leave)) {
            return $leaves[ $leave ];
        }
        return $leaves;
    }

    public static function getServiceCategory()
    {
        return ServiceCategory::where('is_active', 1)
            ->where('organization_id', session()->get('organization_id'))
            ->get();
    }

    public static function getServices($service_category_type = 'both')
    {
        $today = Carbon::today()->format('l');
        $service_category_type = $service_category_type === 'both' ? ['service', 'product'] : [$service_category_type];
        return Service::join('service_has_day_price', 'services.id', '=', 'service_has_day_price.service_id')
            ->select('services.*', 'service_has_day_price.name as day_name', 'service_has_day_price.price as day_price')
            ->where([
                ['services.is_active', 1],
                ['services.organization_id', session()->get('organization_id')],
                ['service_has_day_price.name', $today]
            ])
            ->whereIn('services.service_category_type', $service_category_type)
            ->get();
    }

    public static function getServiceById($service_id)
    {
        return Service::where('is_active', 1)
            ->where('organization_id', session()->get('organization_id'))
            ->where('id', $service_id)
            ->first();
    }

    public static function fetchTodaysService($id, $organization_id)
    {
        $today = Carbon::today()->format('l');
        return Service::join('service_has_day_price', 'services.id', '=', 'service_has_day_price.service_id')
            ->select('services.*', 'service_has_day_price.name as day_name', 'service_has_day_price.price as day_price')
            ->where([
                ['services.is_active', 1],
                ['services.organization_id', $organization_id],
                ['service_has_day_price.name', $today],
                ['services.id', $id]
            ])
            ->first();
    }

    public static function getExpenses()
    {
        return Expense::where('is_active', 1)
            ->where([
                ['organization_id', session()->get('organization_id')],
            ])
            ->pluck('name', 'id')
            ->toArray();
    }

    public static function getCustomersPhoneNumbers()
    {
        return Customer::where('is_active', 1)
            ->where('is_active', 1)
            ->where('organization_id', session()->get('organization_id'))
            ->pluck('phone', 'id')
            ->toArray();
    }

    public static function getCustomersInvoiceNumbers()
    {
        return Pos::where('organization_id', session()->get('organization_id'))
            ->pluck('invoice_number', 'id')
            ->toArray();
    }

    public static function getCompanies()
    {
        return Company::where('is_active', 1)
            ->where('organization_id', session()->get('organization_id'))
            ->pluck('name', 'id')
            ->toArray();
    }

    public static function getCouponsDetails()
    {
        return Coupon::with('customer')
            ->where('organization_id', session()->get('organization_id'))
            ->pluck('code', 'id')
            ->toArray();
    }

    public static function getInvoiceNumbers()
    {
        return Booking::where('organization_id', session()->get('organization_id'))->pluck('bill_number', 'id')->toArray();
    }

    public static function getProductInventories()
    {
        return Inventory::where('organization_id', session()->get('organization_id'))->get();
    }

    public static function getSuppliers()
    {
        $supplier = new Supplier();
        return $supplier
            ->where('organization_id', session()->get('organization_id'))
            ->where('is_active', 1)
            ->pluck('name', 'id')
            ->toArray();
    }

    public static function getItemCategories()
    {
        return ServiceCategory::where('is_active', 1)
            ->where([
                ['organization_id', session()->get('organization_id')]
            ])->get()->toArray();
    }

    public static function getNotificationTemplates($type = 'SMS')
    {
        return NotificationTemplate::where('is_active', 1)
            ->where('type', $type)
            ->where('organization_id', session()->get('organization_id'))
            ->get();
    }

    public static function getServiceTypes()
    {
        return ServiceType::where('organization_id', session()->get('organization_id'))
            ->where('is_active', 1)
            ->get();
    }

    public static function getAllOrganizations()
    {
        return Organization::where('is_active', 1)->get();
    }
}
