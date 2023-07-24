<?php

use Illuminate\Database\Migrations\Migration;

class AddConfigurationsForAdvanceToken extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $settings_configurations = \App\Models\Configuration::where('key', 'settings')->get();

        if (!empty($settings_configurations) && count($settings_configurations) > 0) {
            foreach ($settings_configurations as $settings_configuration) {
                \App\Models\Configuration::create([
                    'organization_id' => $settings_configuration->organization_id,
                    'parent_id'       => $settings_configuration->id,
                    'key'             => 'advance_percentage_for_online',
                    'display_text'    => 'Advance Percentage ( Online )',
                    'is_visible'      => 1,
                    'value'           => 10,
                    'input_type'      => 'text'
                ]);

                \App\Models\Configuration::create([
                    'organization_id' => $settings_configuration->organization_id,
                    'parent_id'       => $settings_configuration->id,
                    'key'             => 'advance_percentage_for_pos',
                    'display_text'    => 'Advance Percentage ( POS )',
                    'is_visible'      => 1,
                    'value'           => 10,
                    'input_type'      => 'text'
                ]);

                \App\Models\Configuration::where('key', 'week_day_off')
                    ->update([
                        'options' => json_encode(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'])
                    ]);
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
        //
    }
}
