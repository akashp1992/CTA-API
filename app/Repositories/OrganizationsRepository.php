<?php

namespace App\Repositories;

use App\Models\Organization;
use Carbon\Carbon;

class OrganizationsRepository
{
    protected $organization;

    public function __construct()
    {
        $this->organization = new Organization();
    }

    public function getOrganizations()
    {
        return $this->organization
            ->with('users', 'audit_logs')
            ->get();
    }

    public function getOrganizationById($id)
    {
        return $this->organization->with('users', 'audit_logs')->findOrFail($id);
    }

    public function getOrganizationBySlug($slug)
    {
        $organization = $this->organization
            ->with('users', 'audit_logs')
            ->where('slug', $slug)
            ->first();

        if (!isset($organization)) {
            throw new \Exception('No query results for model [App\Models\Organization] ' . $slug, 201);
        }

        return $organization;
    }

    public function getOrganizationDetailsById($id)
    {
        $organization = $this->organization->where('id', $id)->first();
        if (!isset($organization)) {
            throw new \Exception('No query results for model [App\Models\Organization] ' . $id, 201);
        }

        return $organization;
    }

    public function store($data)
    {
        regenerate:
        $random_string = strtoupper(substr(md5(uniqid(rand(), true)), 0, 5));
        if ($this->organization->where('slug', $random_string)->count()) {
            goto regenerate;
        }

        $data['slug'] = $random_string;
        $data['start_time'] = Carbon::parse($data['start_time'])->format('H:i');
        $data['end_time']   = Carbon::parse($data['end_time'])->format('H:i');
        return $this->organization->create($data);
    }

    public function update($data, $id)
    {
        $data['start_time'] = Carbon::parse($data['start_time'])->format('H:i');
        $data['end_time']   = Carbon::parse($data['end_time'])->format('H:i');
        return $this->organization->findOrFail($id)->update($data);
    }

    public function delete($slug)
    {
        $organization = $this->organization->where('slug', $slug)->first();

        if (!isset($organization)) {
            throw new \Exception('No query results for model [App\Models\Organization] ' . $slug, 201);
        }

        return $organization->delete();
    }
}
