<?php

namespace App\Http\Controllers;

use App\Repositories\CustomersRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Models\CustomerHasAdminOrganization;

class CustomersController extends Controller
{
    protected $customers_repository;

    public function __construct()
    {
        $this->customers_repository = new CustomersRepository();
    }

    public function index()
    {
        try {
            return view('customers.index');
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('customers.index')
                ->with('notification', $notification);
        }
    }

    public function getCustomers(Request $request)
    {
        $accesses_urls = [];
        $user_group    = '';

        if (auth()->check()) {
            $user_group          = auth()->user()->group;
            $user_group_accesses = isset($user_group) && !empty($user_group) ? $user_group->accesses : [];
            if (isset($user_group_accesses) && !empty($user_group_accesses)) {
                foreach ($user_group_accesses as $access) {
                    $accesses_urls[] = $access->module;
                }
            }
        }
        if ($request->ajax()) {
            $data = $this->customers_repository->getCustomers();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($customer) use ($accesses_urls) {
                    return prepare_listing_action_buttons('customers', $customer->slug, $accesses_urls);
                })
                ->addColumn('update_state', function ($customer) {
                    return prepare_active_button('customers', $customer);
                })
                ->rawColumns(['action', 'update_state'])
                ->make(true);
        }
    }

    public function create()
    {
        return view('customers.manage');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), array('name' => 'required', 'phone' => 'required'));
            if ($validator->fails()) {
                $notification = prepare_notification_array('danger', implode('<br>', $validator->getMessageBag()->all()));
                return redirect()
                    ->route('customers.create')
                    ->withInput()
                    ->with('notification', $notification);
            }

            $customer_data = $request->only('organization_id', 'name', 'phone', 'email', 'password', 'picture', 'gender', 'type', 'is_active', 'birth_date', 'height', 'weight', 'internal_notes');

            $customer_data['picture']   = upload_attachment($request, 'picture', 'uploads/customers');
            $customer_data['password']  = bcrypt($customer_data['password']);
            $customer_data['is_active'] = isset($customer_data) && isset($customer_data['is_active']) ? 1 : 0;
            $customer = $this->customers_repository->store($customer_data);

            $organization_ids = $request->get('organization_ids', []);
            if (!empty($organization_ids) && count($organization_ids) > 0) {
                foreach ($organization_ids as $organization_id) {
                    CustomerHasAdminOrganization::create([
                        'customer_id'     => $customer->id,
                        'organization_id' => $organization_id,
                    ]);
                }
            }

            $notification = prepare_notification_array('success', 'Customer has been added.');
            DB::commit();
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            DB::rollBack();
        }

        $redirect_back = $request->has('redirect_back') ? $request->get('redirect_back') : 'customers.index';

        return redirect()
            ->route($redirect_back)
            ->with('phone', $request->get('phone'))
            ->with('notification', $notification);
    }

    public function show($id)
    {
        try {
            $customer = $this->customers_repository->getCustomerById($id);
            return view('customers.show', compact('customer'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('customers.index')
                ->with('notification', $notification);
        }
    }

    public function edit($id)
    {
        try {
            $customer = $this->customers_repository->getCustomerById($id);
            return view('customers.manage', compact('customer'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('customers.index')
                ->with('notification', $notification);
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), array('name' => 'required', 'phone' => 'required'));
            if ($validator->fails()) {
                $notification = prepare_notification_array('danger', implode('<br>', $validator->getMessageBag()->all()));
                return redirect()
                    ->route('customers.edit', [$request->get('slug')])
                    ->withInput()
                    ->with('notification', $notification);
            }

            $customer_data = $request->only('organization_id', 'name', 'phone', 'email', 'gender', 'type', 'is_active', 'birth_date', 'height', 'weight', 'internal_notes');

            $customer_data['picture']   = upload_attachment($request, 'picture', 'uploads/customers');
            $customer_data['is_active'] = isset($customer_data) && isset($customer_data['is_active']) ? 1 : 0;
            $this->customers_repository->update($customer_data, $id);

            CustomerHasAdminOrganization::where('customer_id', $id)->delete();
            $organization_ids = $request->get('organization_ids', []);
            if (!empty($organization_ids) && count($organization_ids) > 0 && $request->get('type') === 'admin') {
                foreach ($organization_ids as $organization_id) {
                    CustomerHasAdminOrganization::create([
                        'customer_id'     => $id,
                        'organization_id' => $organization_id,
                    ]);
                }
            }

            $notification = prepare_notification_array('success', 'Customer has been updated.');
            DB::commit();
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            DB::rollBack();
        }

        $redirect_back = $request->has('redirect_back') ? $request->get('redirect_back') : 'customers.index';

        return redirect()
            ->route($redirect_back)
            ->with('phone', $request->get('phone'))
            ->with('notification', $notification);
    }

    public function destroy($id)
    {
        try {
            $this->customers_repository->delete($id);
            $notification = prepare_notification_array('success', 'Customer has been deleted.');
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
        }

        return redirect()
            ->route('customers.index')
            ->with('notification', $notification);
    }

    public function getCustomerByPhone(Request $request)
    {
        $customer = $this->customers_repository->getCustomerByPhone($request->get('phone'));

        if (isset($customer)) {
            return response()
                ->json([
                    'success' => true,
                    'code'    => 200,
                    'message' => 'Customer has been retrieved.',
                    'data'    => [
                        'customer' => $customer
                    ]
                ]);
        }

        return response()
            ->json([
                'success' => false,
                'code'    => 201,
                'message' => 'No customer found for the given phone.'
            ]);
    }
}
