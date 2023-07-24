<?php

namespace App\Http\Controllers\API\Customer;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    protected $branch;

    public function __construct()
    {
        $this->branch = new Branch();
    }

    public function getBranches(Request $request)
    {
        try {
            $branches = $this->branch->where('organization_id', $request->get('organization_id'))->get();
            if (!isset($branches)) {
                throw new \Exception('Service Category does not exist.', 201);
            }
            return response()
                ->json([
                    'success' => true,
                    'code'    => 200,
                    'message' => 'Branches.',
                    'data'    => [
                        'branches' => $this->prepare_branch_data($branches)
                    ]
                ]);
        } catch (\Exception $e) {
            return response()
                ->json([
                    'success' => false,
                    'code'    => $e->getCode(),
                    'message' => $e->getMessage()
                ]);
        }
    }

    private function prepare_branch_data($branches): array
    {
        $branches_data = [];
        foreach ($branches as $branch) {
                $branches_data [] = [
                    'id'          => check_empty($branch, 'id', 0),
                    'slug'        => check_empty($branch, 'slug', ''),
                    'name'        => check_empty($branch, 'name', ''),
                    'arabic_name' => check_empty($branch, 'arabic_name', ''),
                    'start_time'  => check_empty($branch, 'start_time', ''),
                    'end_time'    => check_empty($branch, 'end_time', ''),
                ];
        }
        return $branches_data;
    }
}
