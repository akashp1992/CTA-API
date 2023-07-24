<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GroupsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\projectController;
use App\Http\Controllers\ProjectFavouriteController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\ErrorController;
use App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/




Route::post('register', [UsersController::class, 'register']);
Route::post('login', [UsersController::class, 'login']);
Route::post('username/check', [UsersController::class, 'check_username']);
Route::post('forgot/password', [UsersController::class,'forgot_password']);
Route::post('create/cta/eligibility', [DashboardController::class, 'create_cta_eligibility']);
Route::post('support/create', [UsersController::class, 'create_support']);
Route::get('support/list', [UsersController::class, 'support_list']);


Route::group(['middleware' => ['auth:api', 'check.access']], function () {

    Route::post('group_create', [GroupsController::class, 'group_create']);
    Route::get('group_list', [GroupsController::class, 'group_list']);
    Route::post('group_delete', [GroupsController::class, 'group_delete']);
    Route::post('group_update/{id}', [GroupsController::class, 'group_update']);
    Route::get('group_by_id/{id}', [GroupsController::class, 'group_by_id']);

    
    // profile
    Route::get('profile', [UsersController::class, 'me']);
    Route::post('profile/edit', [UsersController::class, 'edit_profile']);
    Route::post('change/password', [UsersController::class, 'change_password']);
    Route::get('logout', [UsersController::class, 'logout']);

    //dashboard
     Route::get('admin/dashboard/project/process/count', [DashboardController::class, 'admin_dashboard_project_process_count']);
     Route::get('admin/dashboard/recent/project', [DashboardController::class, 'admin_all_recent_projects']);
     Route::get('user/dashboard/recent/project', [DashboardController::class, 'user_all_recent_projects']);
     Route::get('user/dashboard/project/process/count', [DashboardController::class, 'user_dashboard_project_process_count']);
     Route::get('search/project/by/date', [DashboardController::class, 'search_project_by_date']);

    //project
    Route::post('project/create', [ProjectController::class, 'create_project']);
    Route::get('project/list/createdby/user/id', [ProjectController::class, 'get_project_created_by_user_id']);
    Route::get('get/all/project', [ProjectController::class, 'get_all_project']);
    Route::get('project/list/with/createdby', [ProjectController::class, 'get_project_with_created_by']);
    Route::get('get/perticular/project', [ProjectController::class, 'get_perticular_project']);
    Route::post('project/assign/member', [ProjectController::class, 'project_assign']);
    Route::post('project/process/edit', [ProjectController::class, 'project_process_update']);
    Route::post('project/process/create', [ProjectController::class, 'project_process_create']);
    Route::get('user/project/updated/process/list', [ProjectController::class, 'user_project_updated_process']);
    Route::get('project/search/list', [ProjectController::class, 'project_search_list']);
    Route::post('project/update', [ProjectController::class, 'update_project']);

    //project favourite
    Route::post('project/add/remove/favourite', [ProjectFavouriteController::class, 'project_add_remove_favourite']);
    Route::get('project/favourite/list', [ProjectFavouriteController::class, 'project_favourite_list']);

    //plan
    Route::post('plan', [PlanController::class, 'plan']);
    Route::get('plan/list', [PlanController::class, 'get_plans']);
    Route::post('plan/delete', [PlanController::class, 'delete_plan']);
    Route::post('plan/edit', [PlanController::class, 'edit_plan']);
    Route::post('plan/status', [PlanController::class, 'plan_status']);
    Route::post('plan/has/user', [PlanController::class, 'plan_has_user']);
    Route::get('plan/active/user/count/list', [PlanController::class, 'plan_active_user_lists']);
    Route::get('plan/has/user/details', [PlanController::class, 'plan_has_user_details']);
    Route::get('all/plan/list', [PlanController::class, 'all_plan_lists']);

      //team
      Route::post('create/team/member', [TeamController::class, 'create_team_member']);
      Route::post('edit/team/member', [TeamController::class, 'edit_team_member']);
      Route::post('team/member/status', [TeamController::class, 'team_member_status']);
      Route::post('delete/team/member', [TeamController::class, 'delete_team_member']);
      Route::get('team/member/list', [TeamController::class, 'get_team_members']);
      Route::post('create/team', [TeamController::class, 'create_team']);
      Route::get('team/list', [TeamController::class, 'teams_list']);
      Route::post('delete/team', [TeamController::class, 'delete_team']);
      Route::post('edit/team', [TeamController::class, 'edit_team']);
      Route::post('create/perticular/team/member', [TeamController::class, 'create_perticular_team_member']);
      Route::get('get/team/member/by/team', [TeamController::class, 'get_team_members_by_team']);
      Route::post('add/remove/admin/team/member', [TeamController::class, 'add_remove_admin_team_member']);

      //error
    Route::post('reason/create', [ErrorController::class, 'reason_create']);
    Route::post('reason/edit', [ErrorController::class, 'reason_edit']);
    Route::post('reason/delete', [ErrorController::class, 'reason_delete']);
    Route::get('reason/list', [ErrorController::class, 'reason_lists']);

    Route::post('error/create', [ErrorController::class, 'error_create']);
    Route::post('error/status', [ErrorController::class, 'error_status']);
    Route::get('error/list', [ErrorController::class, 'error_lists']);

    //notification
    Route::get('notification/duration/list', [NotificationController::class, 'list_notification_durations']);
    Route::post('notification/create', [NotificationController::class, 'notification_create']);
    Route::get('notification/list', [NotificationController::class, 'list_notifications']);
    Route::get('notification/list/auth', [NotificationController::class, 'list_notifications_auth']);

});
   