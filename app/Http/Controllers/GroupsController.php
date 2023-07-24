<?php

namespace App\Http\Controllers;

use App\Repositories\GroupsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiTrait;

use App\Models\GroupHasAccess;

class GroupsController extends Controller
{
    use ApiTrait;

    protected $groupRepository;

    public function __construct()
    {
        $this->groupRepository = new GroupsRepository();
        $this->group_has_access = new GroupHasAccess();
    }

    public function group_list()
    {
        try {
            $groups = $this->groupRepository->getGroups();
            return $this->response($groups, 'Groups List!');
        }  catch (Exception $e) {
            return $this->response([], $e->getMessage(), false, 400);
        }
    }

  
    public function group_create(Request $request)
    {       
        try {
            $data                                   = $request->except('system_modules');
            $data['is_active']                      = isset($data['is_active']) ? $data['is_active'] : 0;
            $data['is_restricted'] = 1;

            $validator = Validator::make($data, array('name' => 'required'));
            if ($validator->fails()) {
                return $this->response([], $validator->errors()->first(), false, 401);
            }

            $group          = $this->groupRepository->store($data);
            $system_modules = $request->get('system_modules', []);
            $this->groupRepository->storeGroupAccesses($group->id, $system_modules);

            return $this->response($group, 'Group Created!');
          
        } catch (\Exception $e) {
            return $this->response([], $e->getMessage(), false, 400);
        }
    }

    public function group_by_id($id)
    {
        try {
            $group = $this->groupRepository->getGroupById($id);

            $selected_access = [];
            if (isset($group->accesses) && !empty($group->accesses)) {
                foreach ($group->accesses as $access) {
                    $selected_access[] = ucwords(str_replace('.index', ' ', $access->module));
                }
            }
            return $this->response([$group,$selected_access], 'Group with access list');
        
        }catch (\Exception $e) {
            return $this->response([], $e->getMessage(), false, 400);
        }
    }

  

    public function group_update(Request $request, $id)
    {
        try {
            $data      = $request->except(['_method', 'system_modules','slug']);
            $validator = Validator::make($data, array('name' => 'nullable'));
            if ($validator->fails()) {
                throw new \Exception($validator->getMessageBag()->first(), 201);
            }

            $data['is_active'] = isset($data['is_active']) ? $data['is_active'] : 0;
            $group = $this->groupRepository->update($data, $request->get('slug'));

            $system_modules = $request->get('system_modules', []);
            $this->groupRepository->storeGroupAccesses($id, $system_modules);

            $group_access = $this->group_has_access->where('group_id', $id)->get();

            return $this->response($group_access, 'Group has been updated');
        } catch (\Exception $e) {
            return $this->response([], $e->getMessage(), false, 400);
        }
    }

    public function group_delete(Request $request)
    {
        try {
            $this->groupRepository->delete($request->all());
            return $this->response([], 'Group has been deleted');
        } catch (\Exception $e) {
            return $this->response([], $e->getMessage(), false, 400);
        }
    }
}
