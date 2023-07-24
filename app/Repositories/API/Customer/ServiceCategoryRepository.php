<?php

namespace App\Repositories\API\Customer;

use App\Models\ServiceCategory;

class ServiceCategoryRepository
{
    protected $service_category;

    public function __construct()
    {
        $this->service_category = new ServiceCategory();
    }

    public function getServiceCategories($request)
    {
        return $this->service_category
            ->with('services', 'services.timeSlot', 'services.dayPrice')
            ->where('category_type', 0)
            ->where('organization_id', $request->get('organization_id'))
            ->get();
    }
}
