<?php

namespace App\Http\Controllers;

use App\Repositories\ConfigurationsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ConfigurationsController extends Controller
{
    protected $configurationRepository;

    public function __construct()
    {
        $this->configurationRepository = new ConfigurationsRepository();
    }

    public function index()
    {
        try {
            $configurations = $this->configurationRepository->getConfigurations();
            return view('configurations.index', compact('configurations'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()->route('configurations.index')->with('notification', $notification);
        }
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->configurationRepository->update($request);
            $notification = prepare_notification_array('success', 'Configuration updated successfully.');
            DB::commit();
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            DB::rollBack();
        }

        return redirect()->route('configurations.index')->withInput()->with('notification', $notification);
    }
}
