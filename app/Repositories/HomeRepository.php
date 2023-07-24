<?php

namespace App\Repositories;

use App\Models\Banner;
use App\Models\Coupon;
use App\Models\Company;
use App\Models\Customer;
use App\Models\ServiceType;
use App\Models\Supplier;
use App\Models\Driver;
use App\Models\Holiday;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Group;
use App\Models\Inventory;
use App\Models\Organization;
use App\Models\Page;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\User;
use App\Models\NotificationTemplate;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class HomeRepository
{
    protected $feedback, $attendance, $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function getAttendances($request)
    {
        $selected_date = $request->has('date')
        ? Carbon::createFromFormat('d/m/Y', $request->get('date'))
        : Carbon::now();

        $period = CarbonPeriod::create($selected_date->startOfWeek()->format('Y-m-d'), $selected_date->endOfWeek()->format('Y-m-d'));
        $dates_between = $period->toArray();

        $date_range = [];
        if (!empty($dates_between)) {
            foreach ($dates_between as $date_between) {
                $date_range[] = $date_between->format('Y-m-d');
            }
        }

        $institute_id = $request->has('institute_id') ? $request->get('institute_id') : 1;
        $user_ids = $this->user
            ->where('institute_id', $institute_id)
            ->pluck('id')
            ->toArray();

        $attendance_user_ids = $this->attendance
            ->whereDate('created_at', '>=', $selected_date->startOfWeek()->format('Y-m-d'))
            ->whereDate('created_at', '<=', $selected_date->endOfWeek()->format('Y-m-d'))
            ->pluck('user_id')
            ->toArray();

        $attendance_user_ids = array_values(array_unique($attendance_user_ids));
        $actual_user_ids = array_values(array_intersect($user_ids, $attendance_user_ids));

        $users = $this->user
            ->with([
                'institute',
                'attendances' => function ($q) use ($selected_date) {
                    return $q->whereDate('created_at', '>=', $selected_date->startOfWeek()->format('Y-m-d'))
                        ->whereDate('created_at', '<=', $selected_date->endOfWeek()->format('Y-m-d'))
                        ->orderBy('created_at');
                },
            ])
            ->whereIn('id', $actual_user_ids)
            ->orderBy('id', 'asc')
            ->get();

        $attendance_array = [];
        if (!empty($users) && count($users) > 0) {
            foreach ($users as $user_key => $user) {
                $attendance_states = $date_range;
                $attendance_states = array_flip($attendance_states);

                if (!empty($attendance_states)) {
                    foreach ($attendance_states as $key => $attendance_state) {
                        $attendance_states[$key] = 0;
                    }
                }

                $attendance_states['user_id'] = $user->id;
                $attendance_states['user_name'] = !empty($user->name) ? $user->name : '';
                $attendance_states['institute'] = isset($user->institute) && !empty($user->institute->name) ? $user->institute->name : '';

                if (!empty($user->attendances) && count($user->attendances) > 0) {
                    foreach ($user->attendances as $attendance) {
                        $attendance_states[$attendance->created_at->format('Y-m-d')] = 1;
                    }
                }

                $attendance_array[$user_key] = $attendance_states;
            }
        }

        return array('attendances' => $attendance_array, 'dates_between' => $dates_between);
    }

    public function getFeedback()
    {
        return $this->feedback->where('for', 'application')->get();
    }

    public function getFeedbackDetail($review_id)
    {
        return $this->feedback->findOrFail($review_id);
    }

    public function removeFile($request)
    {
        switch ($request->get('module')) {
            case 'users':
                User::where('id', $request->get('id'))
                    ->update([
                        $request->get('field') => '',
                    ]);
                break;
            case 'banners':
                Banner::where('id', $request->get('id'))
                    ->update([
                        $request->get('field') => '',
                    ]);
                break;
            case 'customers':
                Customer::where('id', $request->get('id'))
                    ->update([
                        $request->get('field') => '',
                    ]);
                break;
            default:
                break;
        }
    }

    public function updateState($module, $id)
    {
        $model = '';
        switch ($module) {
            case 'organizations':
                $model = new Organization();
                break;
            case 'groups':
                $model = new Group();
                break;
            case 'users':
                $model = new User();
                break;
            case 'service_types':
                $model = new ServiceType();
                break;
            case 'service_categories':
                $model = new ServiceCategory();
                break;
            case 'customers':
                $model = new Customer();
                break;
            case 'suppliers':
                $model = new Supplier();
                break;
            case 'drivers':
                $model = new Driver();
                break;
            case 'banners':
                $model = new Banner();
                break;
            case 'holidays':
                $model = new Holiday();
                break;
            case 'services':
                $model = new Service();
                break;
            case 'pages':
                $model = new Page();
                break;
            case 'coupons':
                $model = new Coupon();
                break;
            case 'companies':
                $model = new Company();
                break;
            case 'expenses':
                $model = new Expense();
                break;
            case 'expense_categories':
                $model = new ExpenseCategory();
                break;
            case 'inventories':
                $model = new Inventory();
                break;
            case 'notification_templates':
                $model = new NotificationTemplate();
                break;
        }

        $response = $model->where('id', $id)->first();
        if (!isset($response)) {
            throw new \Exception('No record found.', 201);
        }

        $response->is_active = $response->is_active == 1 ? 0 : 1;
        $response->save();
        return $response->is_active;
    }
}
