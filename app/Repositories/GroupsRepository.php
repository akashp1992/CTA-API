<?php

namespace App\Repositories;

use App\Models\Group;
use App\Models\GroupHasAccess;

class GroupsRepository
{
    protected $group, $group_has_access;

    public function __construct()
    {
        $this->group            = new Group();
        $this->group_has_access = new GroupHasAccess();
    }

    public function getGroups()
    {
        return $this->group
            ->with([
                'users' => function ($query) {
                    return $query->where('is_root_user', 0);
                }
            ])->get();
    }

    public function getGroupById($slug)
    {
        $group = $this->group
        ->with([
            'accesses',
            'users' => function ($query) {
                return $query->where('is_root_user', 0)
                    ->whereNotIn('id', [auth()->user()->id])
                    ->where('organization_id', session()->get('organization_id'));
            }
        ])
        ->where('slug', $slug)
        ->first();

    if (!isset($group)) {
        throw new \Exception('No query results for model [App\Models\Group] ' . $slug, 201);
    }

    return $group;
    }

    public function store($data)
    {
        regenerate:
        $random_string = strtoupper(substr(md5(uniqid(rand(), true)), 0, 5));
        if ($this->group->where('slug', $random_string)->count()) {
            goto regenerate;
        }

        $data['slug'] = $random_string;
        return $this->group->create($data);
    }

    public function update($data, $id)
    {
        return $this->group->where('slug',$id)->update($data);
    }

    public function delete($slug)
    {
        $group = $this->group->where('slug', $slug)->first();

        if (!isset($group)) {
            throw new \Exception('No query results for model [App\Models\Group] ' . $slug, 201);
        }

        return $group->delete();
    }

    public function storeGroupAccesses($group_id, $system_modules = [])
    {
        $this->group_has_access->where('group_id', $group_id)->delete();

        $system_modules = explode(', ', $system_modules);
        if (!empty($system_modules)) {
            foreach ($system_modules as $system_module) {
                $this->group_has_access->create([
                    'group_id' => $group_id,
                    'module'   => $system_module
                ]);
            }
        }
    }
}
