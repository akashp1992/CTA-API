<?php

namespace App\Models;

use App\Traits\CreateAndUpdateTrait;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use CreateAndUpdateTrait, \App\Traits\AuditLog;

    protected $table = 'groups';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();
        // static::addGlobalScope(new OrganizationScope());

//        static::updating(function ($eloquent) {
//            $eloquent->adjust(auth()->user()->id);
//        });
    }

    const SYSTEM_MODULES = [
        'navigation' => [
            'masters' => [
                'service_type'          => ['service_types.index', 'service_types.edit', 'service_types.create', 'service_types.show'],
                'service_category'      => ['service_categories.index', 'service_categories.edit', 'service_categories.create', 'service_categories.show'],
                'service'               => ['services.index', 'services.edit', 'services.create', 'services.show'],
                'user'                  => ['users.index', 'users.edit', 'users.create', 'users.show'],
                'customer'              => ['customers.index', 'customers.create', 'customers.show', 'customers.edit', 'customers.delete'],
                'holiday'               => ['holidays.index', 'holidays.edit', 'holidays.create', 'holidays.show'],
                'suppliers'             => ['suppliers.index', 'suppliers.edit', 'suppliers.create', 'suppliers.show'],
                'coupon'                => ['coupons.index', 'coupons.create', 'coupons.show', 'coupons.edit', 'coupons.delete'],
                'companies'             => ['companies.index', 'companies.create', 'companies.show', 'companies.edit', 'companies.delete'],
                'banner'                => ['banners.index', 'banners.create', 'banners.show', 'banners.edit', 'banners.delete'],
                'page'                  => ['pages.index', 'pages.create', 'pages.show', 'pages.edit', 'pages.delete'],
                'notification_template' => ['notification_templates.index', 'notification_templates.create', 'notification_templates.show', 'notification_templates.edit', 'notification_templates.delete', 'notification.send'],
                'inventory'             => ['inventories.index', 'inventories.edit', 'inventories.create', 'inventories.show'],
                'purchase_inventory'    => ['purchase_inventories.index', 'purchase_inventories.edit', 'purchase_inventories.create', 'purchase_inventories.show'],
                'expense_category'      => ['expense_categories.index', 'expense_categories.edit', 'expense_categories.create', 'expense_categories.show'],
                'expense'               => ['expenses.index', 'expenses.edit', 'expenses.create', 'expenses.show'],
                'note'                  => ['notes.index', 'notes.edit', 'notes.create', 'notes.show', 'notes.delete'],
            ],

            'reports' => [
                'reports'      => ['reports.sales', 'reports.ticket_types', 'reports.payment_types', 'reports.cancel_booking'],
                'day_closings' => ['day_closings.index', 'day_closings.generate', 'day_closings.details'],
            ],

            'administrative_links' => [
                'organization'  => ['organizations.index', 'organizations.create', 'organizations.show', 'organizations.edit', 'organizations.delete'],
                'group'         => ['groups.index', 'groups.create', 'groups.show', 'groups.edit', 'groups.delete'],
                'pos'           => ['pos.index', 'pos.edit', 'pos.create', 'pos.show'],
                'miscellaneous' => ['configurations.index'],
            ],
        ]
    ];

    public function accesses()
    {
        return $this->hasMany(GroupHasAccess::class, 'group_id', 'id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'group_id', 'id');
    }
}
