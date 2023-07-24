<?php

namespace App\Repositories;

use App\Models\Company;

class CompaniesRepository
{
    protected $company;

    public function __construct()
    {
        $this->company = new Company();
    }

    public function getCompanys()
    {
        return $this->company
            ->where('organization_id', session()->get('organization_id'))
            ->get();
    }

    public function getCompanyById($slug)
    {
        $company = $this->company
            ->with(['coupon'])
            ->where('slug', $slug)
            ->first();

        if (!isset($company)) {
            throw new \Exception('No query results for model [App\Models\Company] ' . $slug, 201);
        }

        return $company;
    }

    public function getCompanyByEmail($email)
    {
        return $this->company->where('email', $email)->first();
    }

    public function getCompanyByPhone($phone)
    {
        return $this->company->where('phone', $phone)->first();
    }

    public function store($data)
    {
        regenerate:
        $random_string = strtoupper(substr(md5(uniqid(rand(), true)), 0, 5));
        if ($this->company->where('slug', $random_string)->count()) {
            goto regenerate;
        }

        $data['slug'] = $random_string;
        return $this->company->create($data);
    }

    public function update($data, $id)
    {
        return $this->company->findOrFail($id)->update($data);
    }

    public function delete($slug)
    {
        $company = $this->company->where('slug', $slug)->first();

        if (!isset($company)) {
            throw new \Exception('No query results for model [App\Models\Company] ' . $slug, 201);
        }

        return $company->delete();
    }
}
