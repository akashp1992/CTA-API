<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\ProjectHasOwner;
use App\Models\ProjectHasTeamMember;
use App\Models\ProjectProcess;
use App\Models\CtaEligibility;
use App\Traits\ApiTrait;
use Exception;
use Illuminate\Support\Facades\Validator;
use Auth;
use Hash;
use DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    use ApiTrait;

    /**
    *  @OA\Get(
    *     path="/api/admin/dashboard/project/process/count",
    *     tags={"Dashboard"},
    *     security={{"bearer_token":{}}},
    *     summary="Get Admin Project process Count List",
    *     security={{"bearer_token":{}}},
    *     operationId="Get Admin Project process Count List",
    *
    *
    *     @OA\Response(
    *         response=200,
    *         description="Success",
    *         @OA\MediaType(
    *             mediaType="application/json",
    *         )
    *     ),
    *     @OA\Response(
    *         response=401,
    *         description="Unauthorized"
    *     ),
    *     @OA\Response(
    *         response=400,
    *         description="Invalid request"
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="not found"
    *     ),
    *     @OA\Response(
    *         response=422,
    *         description="Unprocessable entity"
    *     ),
    * )
    **/
   public function admin_dashboard_project_process_count()
   {
       try {
           $fd_count = ProjectProcess::where('project_status',1)->count();
           $rc_count = ProjectProcess::where('project_status',2)->count();
           $fc_count = ProjectProcess::where('project_status',3)->count();
           $cf_count = ProjectProcess::where('project_status',4)->count();

           $data['Total pending files'] = $fd_count;
           $data['Total pending review'] = $rc_count;
           $data['Total pushed'] = $fc_count;
           $data['Total competed files'] = $cf_count;

           return $this->response([$data], 'Admin Dashboard Project Process Count');
       } catch (Exception $e) {
           return $this->response([], $e->getMessage(), false,400);
       }
   }


   /**
    *  @OA\Get(
    *     path="/api/admin/dashboard/recent/project",
    *     tags={"Dashboard"},
    *     security={{"bearer_token":{}}},
    *     summary="Get all recent project list admin",
    *     operationId="Get all recent Project List admin",
    *
    *
    *     @OA\Response(
    *         response=200,
    *         description="Success",
    *         @OA\MediaType(
    *             mediaType="application/json",
    *         )
    *     ),
    *     @OA\Response(
    *         response=401,
    *         description="Unauthorized"
    *     ),
    *     @OA\Response(
    *         response=400,
    *         description="Invalid request"
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="not found"
    *     ),
    *     @OA\Response(
    *         response=422,
    *         description="Unprocessable entity"
    *     ),
    * )
    **/
   public function admin_all_recent_projects()
   {
       try {
           $recent_project = project::with('projectOwner')->latest('created_at')->get();
           return $this->response($recent_project, 'All recent projects');
       } catch (Exception $e) {
           return $this->response([], $e->getMessage(), false,400);
       }
   }

    /**
    *  @OA\Get(
    *     path="/api/user/dashboard/recent/project",
    *     tags={"Dashboard"},
    *     security={{"bearer_token":{}}},
    *     summary="Get all recent project list user",
    *     operationId="Get all recent Project List user",
    *
    *
    *     @OA\Response(
    *         response=200,
    *         description="Success",
    *         @OA\MediaType(
    *             mediaType="application/json",
    *         )
    *     ),
    *     @OA\Response(
    *         response=401,
    *         description="Unauthorized"
    *     ),
    *     @OA\Response(
    *         response=400,
    *         description="Invalid request"
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="not found"
    *     ),
    *     @OA\Response(
    *         response=422,
    *         description="Unprocessable entity"
    *     ),
    * )
    **/
   public function user_all_recent_projects()
   {
       try {
           $recent_project = project::where('created_by',Auth::id())->with('projectOwner')->latest('created_at')->get();
           return $this->response($recent_project, 'All recent projects');
       } catch (Exception $e) {
           return $this->response([], $e->getMessage(), false,400);
       }
   }

   /**
    *  @OA\Get(
    *     path="/api/user/dashboard/project/process/count",
    *     tags={"Dashboard"},
    *     security={{"bearer_token":{}}},
    *     summary="Get User Project process Count List",
    *     security={{"bearer_token":{}}},
    *     operationId="Get User Project process Count List",
    *
    *
    *     @OA\Response(
    *         response=200,
    *         description="Success",
    *         @OA\MediaType(
    *             mediaType="application/json",
    *         )
    *     ),
    *     @OA\Response(
    *         response=401,
    *         description="Unauthorized"
    *     ),
    *     @OA\Response(
    *         response=400,
    *         description="Invalid request"
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="not found"
    *     ),
    *     @OA\Response(
    *         response=422,
    *         description="Unprocessable entity"
    *     ),
    * )
    **/
   public function user_dashboard_project_process_count()
   {
       try {
           $fd_count = ProjectProcess::where('created_by_user_id',Auth::id())->where('project_status',1)->count();
           $rc_count = ProjectProcess::where('created_by_user_id',Auth::id())->where('project_status',2)->count();
           $fc_count = ProjectProcess::where('created_by_user_id',Auth::id())->where('project_status',3)->count();
           $cf_count = ProjectProcess::where('created_by_user_id',Auth::id())->where('project_status',4)->count();

           $data['Total pending files'] = $fd_count;
           $data['Total pending review'] = $rc_count;
           $data['Total pushed'] = $fc_count;
           $data['Total competed files'] = $cf_count;

           return $this->response([$data], 'User Dashboard Project Process Count');
       } catch (Exception $e) {
           return $this->response([], $e->getMessage(), false,400);
       }
   }

   
   /**
    *  @OA\Get(
    *     path="/api/search/project/by/date",
    *     tags={"Project"},
    *     security={{"bearer_token":{}}},
    *     summary="Search Project By date",
    *     security={{"bearer_token":{}}},
    *     operationId="Search project by date",
    *
    *     @OA\Parameter(
    *         name="start_date",
    *         in="query",
    *         required=true,
    *         description="start date",
    *         @OA\Schema(
    *             type="string"
    *         )
    *     ),
    *   @OA\Parameter(
    *         name="end_date",
    *         in="query",
    *         required=true,
    *         description="end date",
    *         @OA\Schema(
    *             type="string"
    *         )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Success",
    *         @OA\MediaType(
    *             mediaType="application/json",
    *         )
    *     ),
    *     @OA\Response(
    *         response=401,
    *         description="Unauthorized"
    *     ),
    *     @OA\Response(
    *         response=400,
    *         description="Invalid request"
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="not found"
    *     ),
    *     @OA\Response(
    *         response=422,
    *         description="Unprocessable entity"
    *     ),
    * )
    **/
   public function search_project_by_date(Request $request)
   {

       $validator = Validator::make($request->all(), [
           // 'project_id' => 'required|exists:projects,id',
       ]);

       if ($validator->fails()) {
           return $this->response([], $validator->errors()->first(), false, 401);
       }

       try {
           $start_date = Carbon::parse($request->start_date);
           $end_date = Carbon::parse($request->end_date);
           $result = Project::whereDate('created_at', '>=', $start_date)
                               ->whereDate('created_at', '<=', $end_date)
                               ->get();
           return $this->response($result, 'Project List');
       } catch (Exception $e) {
           return $this->response([], $e->getMessage(), false, 400);
       }
   }

    /**
    *  @OA\Post(
    *     path="/api/create/cta/eligibility",
    *     tags={"CtaEligibility"},
    *     summary="Create cta eligibility",
    *     operationId="create cta eligibility",
    *
    *     @OA\Parameter(
    *         name="first_name",
    *         required=true,
    *         in="query",
    *         @OA\Schema(
    *             type="string"
    *         )
    *     ),
    *    @OA\Parameter(
    *         name="last_name",
    *         required=true,
    *         in="query",
    *         @OA\Schema(
    *             type="string"
    *         )
    *     ),
    *     @OA\Parameter(
    *         name="profession",
    *         required=true,
    *         in="query",
    *         description="1 - Business Owner | 2 - Tax Professional | 3 - Beneficial Owner",
    *         @OA\Schema(
    *             type="integer"
    *         )
    *     ),
    *    @OA\Parameter(
    *         name="company_name",
    *         required=true,
    *         in="query",
    *         @OA\Schema(
    *             type="string"
    *         )
    *     ),
    *     @OA\Parameter(
    *         name="entity_name",
    *         required=true,
    *         in="query",
    *         @OA\Schema(
    *             type="string"
    *         )
    *     ),
    *    @OA\Parameter(
    *         name="gross_revenue",
    *         required=true,
    *         in="query",
    *         description="1 - Business Owner | 2 - Tax Professional | 3 - Beneficial Owner",
    *         @OA\Schema(
    *             type="string"
    *         )
    *     ),
    *   @OA\Parameter(
    *         name="company_website",
    *         in="query",
    *         @OA\Schema(
    *             type="string"
    *         )
    *     ),
    *     @OA\Parameter(
    *         name="email",
    *         required=true,
    *         in="query",
    *         @OA\Schema(
    *             type="string"
    *         )
    *     ),
    *     @OA\Parameter(
    *         name="phone",
    *         required=true,
    *         in="query",
    *         @OA\Schema(
    *             type="string"
    *         )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Success",
    *         @OA\MediaType(
    *             mediaType="application/json",
    *         )
    *     ),
    *     @OA\Response(
    *         response=401,
    *         description="Unauthorized"
    *     ),
    *     @OA\Response(
    *         response=400,
    *         description="Invalid request"
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="not found"
    *     ),
    *     @OA\Response(
    *         response=422,
    *         description="Unprocessable entity"
    *     ),
    * )
    **/
   public function create_cta_eligibility(Request $request)
   {
       $validator = Validator::make($request->all(), [
           'first_name' => 'required|max:255',
           'last_name' => 'required|max:255',
           'profession' => 'required|in:1,2,3',
           'company_name' => 'required|max:255',
           'entity_name' => 'required|max:255',
           'gross_revenue' => 'required|in:1,2,3',
           'company_website' => 'nullable|max:255',
           'email' => 'required|email|unique:cta_eligibilities',
           'phone' => 'required|min:10',
           
       ]);

       if ($validator->fails()) {
           return $this->response([], $validator->errors()->first(), false,401);
       }

       try {
           $cta_el = new CtaEligibility;
           $cta_el->uuid = Str::uuid()->toString();
           $cta_el->first_name = $request->first_name;
           $cta_el->last_name = $request->last_name;
           $cta_el->profession = $request->profession;
           $cta_el->company_name = $request->company_name;
           $cta_el->entity_name = $request->entity_name;
           $cta_el->gross_revenue = $request->gross_revenue;
           $cta_el->company_website = $request->company_website;
           $cta_el->email = $request->email;
           $cta_el->save();
           return $this->response($cta_el, 'Eligibility has been added successfully!');
       } catch (Exception $e) {
           return $this->response([], $e->getMessage(), false,400);
       }

   }

}
