<?php

namespace App\Http\Controllers\API\Customer;

use App\Http\Controllers\Controller;
use App\Repositories\API\Customer\ServiceCategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceCategoryController extends Controller
{
    protected $service_category_repository;

    public function __construct()
    {
        $this->service_category_repository = new ServiceCategoryRepository();
    }

    public function getServiceCategories(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), ['organization_id'    => 'required']);
            if ($validator->fails()) {
                throw new \Exception($validator->getMessageBag()->first(), 201);
            }

            $service_categories = $this->service_category_repository->getServiceCategories($request);
            if (!isset($service_categories)) {
                throw new \Exception('Service Category does not exist.', 201);
            }
            return response()
                ->json([
                    'success' => true,
                    'code'    => 200,
                    'message' => 'Service Categories.',
                    'data'    => [
                        'service_categories' => $this->prepare_service_category_data($service_categories)
                    ]
                ]);
        } catch (\Exception $e) {
            return response()
                ->json([
                    'success' => false,
                    'code'    => $e->getCode(),
                    'message' => $e->getMessage()
                ]);
        }
    }

    private function prepare_service_category_data($service_categories): array
    {
        $service_categories_data = [];
        foreach ($service_categories as $key => $service_category) {
            $services = [];
            if (!empty($service_category->services) && count($service_category->services) > 0) {
                foreach ($service_category->services as $services_response) {
                    $service_time_slot = [];        
                    $service_day_price = [];        
                    if (isset($services_response)) {
                        if (!empty($services_response) && count($services_response->timeSlot) > 0) {
                            foreach ($services_response->timeSlot as $time_slot) {
                                $service_time_slot[] = [
                                    'id'          => $time_slot->id,
                                    'start_time'        => check_empty($time_slot, 'start_time', ''),
                                    'end_time'        => check_empty($time_slot, 'end_time', ''),
                                ];
                            }
                        }
                        if (!empty($services_response) && count($services_response->dayPrice) > 0) {
                            foreach ($services_response->dayPrice as $day_price) {
                                $service_day_price[] = [
                                    'id'          => $day_price->id,
                                    'name'        => check_empty($day_price, 'name', ''),
                                    'price'        => check_empty($day_price, 'price', '')
                                ];
                            }
                        }
                        $services[] = [
                            'id'          => $services_response->id,
                            'slug'        => check_empty($services_response, 'slug', ''),
                            'name'       => check_empty($services_response, 'name', ''),
                            'arabic_name' => check_empty($services_response, 'arabic_name', ''),
                            'description' => check_empty($services_response, 'description', ''),
                            'duration_in_minutes' => check_empty($services_response, 'duration_in_minutes', ''),
                            'service_category_type' => ($services_response->service_category_type) ? 'product' : 'service',
                            'price' => check_empty($services_response, 'price', ''),
                            'service_type' => check_empty($services_response, 'service_type', ''),
                            'attachment'                 => !empty($services_response) && !empty($services_response->attachment)
                                                            ? config('constants.s3.asset_url') . $services_response->attachment
                                                            : '',
                            'is_active'   => isset($services_response->is_active) && $services_response->is_active == 1,
                            'time_slot'   => $service_time_slot,
                            'day_price'   => $service_day_price,
                        ];
                    }
                }
            }
            // if(count($service_categories[$key]->services) > 0){
                $service_categories_data [] = [
                    'id'                      => check_empty($service_category, 'id', 0),
                    'slug'                    => check_empty($service_category, 'slug', ''),
                    'name'                    => check_empty($service_category, 'name', ''),
                    'arabic_name'                   => check_empty($service_category, 'arabic_name', ''),
                    'description'                   => check_empty($service_category, 'description', ''),
                    'attachment'                 => !empty($service_category) && !empty($service_category->attachment)
                        ? config('constants.s3.asset_url') . $service_category->attachment
                        : '',
                    'is_active'               => isset($service_category->is_active) && $service_category->is_active > 0,
                    'services'               => $services,
                ];
            // }
        }
        
        return $service_categories_data;
    }
}
