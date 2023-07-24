<?php

namespace App\Repositories;

use App\Models\Booking;
use App\Models\Customer;

class CustomersRepository
{
    protected $customer;

    public function __construct()
    {
        $this->customer = new Customer();
    }

    public function getCustomers()
    {
        return $this->customer
            ->with('addresses')
            ->where('organization_id', session()->get('organization_id'))
            ->get();
    }

    public function getCustomerById($slug)
    {
        $customer = $this->customer
            ->with('addresses', 'admin_organizations')
            ->where('slug', $slug)
            ->first();

        if (!isset($customer)) {
            throw new \Exception('No query results for model [App\Models\Customer] ' . $slug, 201);
        }

        return $customer;
    }

    public function getCustomerDetailsById($id)
    {
        $customer = $this->customer
            ->where('id', $id)
            ->first();

        return $customer;
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
        $customer_detail = $this->customer->findOrFail($id);
        $customer_detail->update($data);
        return $customer_detail;
    }

    public function delete($slug)
    {
        $customer = $this->customer->where('slug', $slug)->first();

        if (!isset($customer)) {
            throw new \Exception('No query results for model [App\Models\Customer] ' . $slug, 201);
        }

        return $customer->delete();
    }

    public function getCustomerByPhone($phone)
    {
        return $this->customer
            ->where('phone', $phone)
            ->where('organization_id', session()->get('organization_id'))
            ->first();
    }

    public function getCustomerBookings($phone)
    {
        return Booking::join('customers', 'bookings.customer_id', '=', 'customers.id')
            ->select('bookings.schedule_date', 'bookings.ticket_count', 'bookings.ticket_cost', 'bookings.final_cost')
            ->where('phone', $phone)->get();
    }
}
