<?php

namespace App\Http\Controllers;

use App\Repositories\CompaniesRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CompaniesController extends Controller
{
    protected $companies_repository;

    public function __construct()
    {
        $this->companies_repository = new CompaniesRepository();
    }

    public function index()
    {
        try {
            $companies = $this->companies_repository->getCompanys();
            return view('companies.index', compact('companies'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('companies.index')
                ->with('notification', $notification);
        }
    }

    public function create()
    {
        return view('companies.manage');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), array(
                'name'          => 'required',
                'phone'         => 'required|unique:companies',
                'email'         => 'nullable|email|unique:companies',
                'prefix'        => 'required|unique:companies,prefix|min:1|max:4|string',
                'contact_name'  => 'required',
                'contact_phone' => 'required'
            ));
            if ($validator->fails()) {
                $notification = prepare_notification_array('danger', implode('<br>', $validator->getMessageBag()->all()));
                return redirect()
                    ->route('companies.create')
                    ->withInput()
                    ->with('notification', $notification);
            }

            $company_data = $request->only(
                'organization_id', 'name', 'arabic_name', 'prefix', 'email', 'phone', 'address',
                'contact_name', 'contact_email', 'contact_phone', 'is_active'
            );

            $company_data['is_active'] = isset($company_data['is_active']) ? $company_data['is_active'] : 0;
            $company_data['prefix']    = strtolower($company_data['prefix']);
            $this->companies_repository->store($company_data);

            $notification = prepare_notification_array('success', 'Company has been added.');
            DB::commit();
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            DB::rollBack();
        }

        return redirect()
            ->route('companies.index')
            ->withInput()
            ->with('notification', $notification);
    }

    public function show($id)
    {
        try {
            $company = $this->companies_repository->getCompanyById($id);
            return view('companies.show', compact('company'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('companies.index')
                ->with('notification', $notification);
        }
    }

    public function edit($id)
    {
        try {
            $company = $this->companies_repository->getCompanyById($id);
            return view('companies.manage', compact('company'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('companies.index')
                ->with('notification', $notification);
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), array(
                'name'          => 'required',
                'phone'         => 'required|unique:companies,phone,' . $id . ',id',
                'email'         => 'nullable|email|unique:companies,email,' . $id . ',id',
                'contact_name'  => 'required',
                'contact_phone' => 'required'
            ));
            if ($validator->fails()) {
                $notification = prepare_notification_array('danger', implode('<br>', $validator->getMessageBag()->all()));
                return redirect()
                    ->route('companies.edit', [$request->get('slug')])
                    ->withInput()
                    ->with('notification', $notification);
            }

            $company_data = $request->only(
                'organization_id', 'name', 'arabic_name', 'email', 'phone', 'address',
                'contact_name', 'contact_email', 'contact_phone', 'is_active'
            );

            $company_data['is_active'] = isset($company_data['is_active']) ? $company_data['is_active'] : 0;

            $this->companies_repository->update($company_data, $id);

            DB::commit();

            $redirect_to  = 'companies.index';
            $notification = prepare_notification_array('success', 'Company has been updated.');
            if ($request->has('request_from') && $request->get('request_from') == 'profile') {
                $redirect_to  = 'profile';
                $notification = prepare_notification_array('success', 'Your profile has been updated.');
            }

            return redirect()
                ->route($redirect_to)
                ->withInput()
                ->with('notification', $notification);
        } catch (\Exception $e) {
            DB::rollBack();
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('companies.edit', [$request->get('slug')])
                ->withInput()
                ->with('notification', $notification);
        }
    }

    public function destroy($id)
    {
        try {
            $this->companies_repository->delete($id);
            $notification = prepare_notification_array('success', 'Company has been deleted.');
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
        }

        return redirect()
            ->route('companies.index')
            ->with('notification', $notification);
    }
}
