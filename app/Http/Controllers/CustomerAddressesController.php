<?php

namespace App\Http\Controllers;

use App\Repositories\CustomerAddressesRepository;
use App\Repositories\CustomersRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CustomerAddressesController extends Controller
{
    protected $customers_repository, $customer_addresses_repository;

    public function __construct()
    {
        $this->customers_repository          = new CustomersRepository();
        $this->customer_addresses_repository = new CustomerAddressesRepository();
    }

    public function create($slug)
    {
        try {
            $customer = $this->customers_repository->getCustomerById($slug);
            return view('customer_addresses.manage', compact('customer'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('customers.show', [$slug])
                ->with('notification', $notification);
        }
    }

    public function store(Request $request, $customer_slug)
    {
        DB::beginTransaction();
        try {
            $data      = $request->all();
            $validator = Validator::make($data, array(
                'governorate_id' => 'required',
                'area_id'        => 'required',
                'slot_id'        => 'required',
                'name'           => 'required',
                'phone'          => 'required'
            ));
            if ($validator->fails()) {
                $notification = prepare_notification_array('danger', implode('<br>', $validator->getMessageBag()->all()));
                return redirect()
                    ->route('addresses.create', [$customer_slug])
                    ->withInput()
                    ->with('notification', $notification);
            }

            $customer            = $this->customers_repository->getCustomerById($customer_slug);
            $data['customer_id'] = $customer->id;

            $this->customer_addresses_repository->store($data);
            $notification = prepare_notification_array('success', 'Address has been added.');
            DB::commit();
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            DB::rollBack();
        }

        return redirect()
            ->route('customers.show', [$customer_slug])
            ->withInput()
            ->with('notification', $notification);
    }

    public function edit($customer_slug, $address_slug)
    {
        try {
            $customer = $this->customers_repository->getCustomerById($customer_slug);
            $address  = $this->customer_addresses_repository->getAddressById($address_slug);
            return view('customer_addresses.manage', compact('customer', 'address'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('customers.show', [$customer_slug])
                ->with('notification', $notification);
        }
    }

    public function update(Request $request, $customer_slug, $id)
    {
        DB::beginTransaction();
        try {
            $data      = $request->all();
            $validator = Validator::make($data, array(
                'governorate_id' => 'required',
                'area_id'        => 'required',
                'slot_id'        => 'required',
                'name'           => 'required',
                'phone'          => 'required'
            ));
            if ($validator->fails()) {
                $notification = prepare_notification_array('danger', implode('<br>', $validator->getMessageBag()->all()));
                return redirect()
                    ->route('customers.show', [$customer_slug])
                    ->withInput()
                    ->with('notification', $notification);
            }

            $this->customer_addresses_repository->update($data, $id);

            DB::commit();
            $notification = prepare_notification_array('success', 'Address has been updated.');
        } catch (\Exception $e) {
            DB::rollBack();
            $notification = prepare_notification_array('danger', $e->getMessage());
        }

        return redirect()
            ->route('customers.show', $customer_slug)
            ->withInput()
            ->with('notification', $notification);
    }

    public function destroy($customer_slug, $id)
    {
        try {
            $this->customer_addresses_repository->delete($id);
            $notification = prepare_notification_array('success', 'Address has been deleted.');
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
        }

        return redirect()
            ->route('customers.show', [$customer_slug])
            ->with('notification', $notification);
    }
}
