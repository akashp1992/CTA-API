<?php

namespace Database\Seeders;

use App\Models\Organization;
use Illuminate\Database\Seeder;

class ConfigurationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $configurations = config('configurations');

        $configuration = new \App\Models\Configuration();
        $configuration->truncate();

        $organizations = Organization::whereRaw('1=1')->get();
        if (!empty($organizations) && count($organizations) > 0) {
            foreach ($organizations as $organization) {

                // configurations
                foreach ($configurations as $parent_value) {
                    $parent_configuration = $configuration
                        ->create([
                            'organization_id' => $organization->id,
                            'parent_id'       => 0,
                            'key'             => $parent_value['key'],
                            'display_text'    => $parent_value['display_text'],
                            'is_visible'      => 1,
                            'value'           => $parent_value['value'],
                            'input_type'      => $parent_value['input_type'],
                        ]);


                    if (!empty($parent_value['children'])) {
                        foreach ($parent_value['children'] as $child_value) {
                            $configuration
                                ->create([
                                    'organization_id' => $organization->id,
                                    'parent_id'       => $parent_configuration->id,
                                    'key'             => $child_value['key'],
                                    'display_text'    => $child_value['display_text'],
                                    'is_visible'      => 1,
                                    'value'           => $child_value['value'],
                                    'input_type'      => $child_value['input_type'],
                                    'options'         => isset($child_value['options']) ? json_encode($child_value['options']) : null
                                ]);
                        }
                    }
                }
            }
        }
    }
}
