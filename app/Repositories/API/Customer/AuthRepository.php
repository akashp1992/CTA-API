<?php

namespace App\Repositories\API\Customer;

use App\Models\Customer;
use App\Models\CustomerHasAdminOrganization;

class AuthRepository
{
    protected $customer;

    public function __construct()
    {
        $this->customer = new Customer();
        $this->customer_admin_organization = new CustomerHasAdminOrganization();
    }

    public function getCustomerById($request)
    {
        return $this->customer
            ->where('organization_id', $request->get('organization_id'))
            ->findOrFail($request->get('customer_id'));
    }

    public function getCustomerByPhone($request)
    {
        return $this->customer
            ->where('organization_id', $request->get('organization_id'))
            ->where('phone', $request->get('phone'))
            ->first();
    }

    public function getCustomerByEmail($request)
    {
        return $this->customer
            ->where('organization_id', $request->get('organization_id'))
            ->where('email', $request->get('email'))
            ->first();
    }

    public function removeSession($data)
    {
        return $this->customer
            ->where('id', $data['customer_id'])
            ->where('token', $data['token'])
            ->update([
                'token'            => null,
                'token_expired_at' => null
            ]);
    }

    public function store($data)
    {
        regenerate:
        $random_string = strtoupper(substr(md5(uniqid(rand(), true)), 0, 5));
        if ($this->customer->where('slug', $random_string)->count()) {
            goto regenerate;
        }

        $data['slug'] = $random_string;
        $data['code'] = 'CUS-' . mt_rand(100000, 999999);
        return $this->customer->create($data);
    }

    public function update($data, $id)
    {
        return $this->customer->where('id', $id)->update($data);
    }

    public function getCustomerAdminOrganizations($customer){
        return $this->customer_admin_organization
            ->join('organizations', 'customer_has_admin_organizations.organization_id', '=', 'organizations.id')
            ->select('organizations.id', 'organizations.slug', 'organizations.name')
            ->where('customer_has_admin_organizations.customer_id', $customer->id)->get();
    }
}
