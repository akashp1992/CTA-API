<?php

use App\Models\Configuration;
use App\Models\Organization;
use Illuminate\Database\Migrations\Migration;

class AddConfigurationsForAllOrganizationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $organizations = Organization::all();
        $configuration  = new Configuration();
        $configuration->truncate();
        $configurations = config('configurations');
        foreach ($organizations as $organization) {
            if (!empty($configurations)) {
                foreach ($configurations as $parent_value) {
                    $parent_configuration = $configuration->create([
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
                            $configuration->create([
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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
