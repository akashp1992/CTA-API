<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Organization;
use App\Repositories\UsersRepository;
use App\Repositories\OrganizationsRepository;

use Carbon\Carbon;

class OrganizationsController extends Controller
{
    protected $users_repository, $organizations_repository, $organization;

    public function __construct()
    {
        $this->organization             = new Organization();
        $this->users_repository         = new UsersRepository();
        $this->organizations_repository = new OrganizationsRepository();
    }

    public function index()
    {
        try {
            $organizations = $this->organizations_repository->getOrganizations();
            return view('organizations.index', compact('organizations'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('organizations.index')
                ->with('notification', $notification);
        }
    }

    public function create()
    {
        return view('organizations.manage');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data      = $request->except('old_attachment');
            $validator = Validator::make($data, array(
                'name'            => 'required',
                'identifier'      => 'required',
                'start_date'      => 'required',
                'business_type'   => 'required',
                'business_email'  => 'required',
                'civil_id_number' => 'required',
                'contact_person'  => 'required',
                'phone'           => 'required',
                'email'           => 'required|email'
            ));
            if ($validator->fails()) {
                $notification = prepare_notification_array('danger', implode('<br>', $validator->getMessageBag()->all()));
                return redirect()
                    ->route('organizations.create')
                    ->withInput()
                    ->with('notification', $notification);
            }

            $data['start_date']     = Carbon::parse($data['start_date'])->format('Y-m-d');
            $data['end_date']       = !empty($data['end_date']) ? Carbon::parse($data['end_date'])->format('Y-m-d') : null;
            $data['is_active']      = isset($data['is_active']) && $data['is_active'] === 1 ? 1 : 0;
            $data['is_RTL_enabled'] = isset($data['is_RTL_enabled']) && $data['is_RTL_enabled'] === 1 ? 1 : 0;
            $data['is_time_print']  = isset($data['is_time_print']) ? $data['is_time_print'] : 0;
            $data['is_name_print']  = isset($data['is_name_print']) ? $data['is_name_print'] : 0;
            $data['attachment']     = upload_attachment($request, 'attachment', 'uploads/organizations');
            $organization           = $this->organizations_repository->store($data);

            // save configurations...
            $configurations = config('configurations');
            $configuration  = new \App\Models\Configuration();
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

            $notification = prepare_notification_array('success', 'Organization has been added.');
            DB::commit();
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            DB::rollBack();
        }

        return redirect()
            ->route('organizations.index')
            ->withInput()
            ->with('notification', $notification);
    }

    public function show($id)
    {
        try {
            $organization = $this->organizations_repository->getOrganizationBySlug($id);
            return view('organizations.show', compact('organization'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('organizations.index')
                ->with('notification', $notification);
        }
    }

    public function edit($id)
    {
        try {
            $organization = $this->organizations_repository->getOrganizationBySlug($id);
            return view('organizations.manage', compact('organization'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('organizations.index')
                ->with('notification', $notification);
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $data      = $request->except('_method');
            $validator = Validator::make($data, array(
                'name'            => 'required',
                'identifier'      => 'required',
                'start_date'      => 'required',
                'business_type'   => 'required',
                'business_email'  => 'required',
                'civil_id_number' => 'required',
                'contact_person'  => 'required',
                'phone'           => 'required',
                'email'           => 'required|email'
            ));
            if ($validator->fails()) {
                $notification = prepare_notification_array('danger', implode('<br>', $validator->getMessageBag()->all()));
                return redirect()
                    ->route('organizations.edit', [$request->get('slug')])
                    ->withInput()
                    ->with('notification', $notification);
            }

            $data['start_date']     = Carbon::parse($data['start_date'])->format('Y-m-d');
            $data['end_date']       = !empty($data['end_date']) ? Carbon::parse($data['end_date'])->format('Y-m-d') : null;
            $data['is_active']      = isset($data['is_active']) && $data['is_active'] == 1 ? 1 : 0;
            $data['is_RTL_enabled'] = isset($data['is_RTL_enabled']) && $data['is_RTL_enabled'] == 1 ? 1 : 0;
            $data['is_time_print']  = isset($data['is_time_print']) ? $data['is_time_print'] : 0;
            $data['is_name_print']  = isset($data['is_name_print']) ? $data['is_name_print'] : 0;
            $data['attachment']     = upload_attachment($request, 'attachment', 'uploads/organizations');
            $this->organizations_repository->update($data, $id);

            DB::commit();

            $organization_id = session()->get('organization_id');
            if ($organization_id == $id) {
                $organization = $this->organizations_repository->getOrganizationById($id);

                session()->put('organization_id', $organization->id);
                session()->put('organization_name', $organization->name);
                session()->put('organization', $organization);
                exec('php artisan view:clear');
            }

            $notification = prepare_notification_array('success', 'Organization has been updated.');
            return redirect()
                ->route('organizations.index')
                ->withInput()
                ->with('notification', $notification);
        } catch (\Exception $e) {
            DB::rollBack();
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('organizations.edit', [$request->get('slug')])
                ->withInput()
                ->with('notification', $notification);
        }
    }

    public function destroy($id)
    {
        try {
            $this->organizations_repository->delete($id);
            $notification = prepare_notification_array('success', 'Organization has been deleted.');
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
        }

        return redirect()
            ->route('organizations.index')
            ->with('notification', $notification);
    }
}
