<?php

namespace App\Repositories;

use App\Models\CustomerHasAddress;

class CustomerAddressesRepository
{
    protected $customer_has_address;

    public function __construct()
    {
        $this->customer_has_address = new CustomerHasAddress();
    }

    public function getAddressById($slug)
    {
        $address = $this->customer_has_address
            ->where('slug', $slug)
            ->first();

        if (!isset($address)) {
            throw new \Exception('No query results for model [App\Models\Address] ' . $slug, 201);
        }

        return $address;
    }

    public function store($data)
    {
        regenerate:
        $random_string = strtoupper(substr(md5(uniqid(rand(), true)), 0, 5));
        if ($this->customer_has_address->where('slug', $random_string)->count()) {
            goto regenerate;
        }

        $data['slug'] = $random_string;
        return $this->customer_has_address->create($data);
    }

    public function update($data, $id)
    {
        return $this->customer_has_address->findOrFail($id)->update($data);
    }

    public function delete($slug)
    {
        $address = $this->customer_has_address->where('slug', $slug)->first();

        if (!isset($address)) {
            throw new \Exception('No query results for model [App\Models\Address] ' . $slug, 201);
        }

        return $address->delete();
    }
}
