<?php

namespace App\Repositories;

use App\Models\Configuration;
use Illuminate\Http\Request;

class ConfigurationsRepository
{
    protected $configuration;

    public function __construct()
    {
        $this->configuration = new Configuration();
    }

    public function getConfigurations()
    {
        return $this->configuration
            ->with(['user', 'child_configurations' => function ($query) {
                return $query->where('is_visible', 1);
            }])
            ->where('parent_id', 0)
            ->where('organization_id', session()->get('organization_id'))
            ->get();
    }

    public function update(Request $request)
    {
        $configurations      = $request->get('configurations');
        $configuration_files = $request->file();
        if (isset($configurations) && !empty($configurations)) {
            foreach ($configurations as $configuration_key => $configuration_value) {
                if (isset($configuration_value) && !empty($configuration_value)) {
                    foreach ($configuration_value as $sub_configuration_key => $sub_configuration_value) {
                        if (isset($configuration_files['configurations'][ $configuration_key ])) {
                            $file_data = $configuration_files['configurations'][ $configuration_key ];
                            if (isset($file_data[ $sub_configuration_key ]) && in_array($sub_configuration_key, array_keys($file_data))) {
                                $picture = $file_data[ $sub_configuration_key ];
                                if (is_object($picture) && $picture->isValid() && $picture->getSize() < 10000000
                                    && in_array($picture->getMimeType(), ['image/jpeg', 'image/png', 'image/bmp', 'image/x-icon'])) {
                                    $picture_file_with_ext = $picture->getClientOriginalName();
                                    $destination_path      = public_path('uploads/configurations');
                                    $picture->move($destination_path, $picture_file_with_ext);
                                    $sub_configuration_value = upload_image_to_bucket($picture_file_with_ext, 'uploads/configurations');
                                }
                            }
                        }
                        $this->configuration
                            ->where('parent_id', $configuration_key)
                            ->where('key', $sub_configuration_key)
                            ->where('organization_id', session()->get('organization_id'))
                            ->update([
                                'value' => $sub_configuration_value
                            ]);
                    }
                }
            }
        }
    }
}
