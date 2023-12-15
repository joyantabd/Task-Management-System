<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LogActivityController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TaskAssignController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TeamController;
use App\Manager\ScriptManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('login',[AuthController::class,'login']);
Route::post('logout',[AuthController::class,'logout']);
Route::get('report/{id}',[ReportController::class,'index']);


// Admin Route
Route::group(['middleware' => ['auth:admin']], function() {
    Route::apiResource('teams',TeamController::class);
    Route::apiResource('member',MemberController::class);
    Route::apiResource('task',TaskController::class);
    Route::apiResource('task_assign',TaskAssignController::class);
    
    Route::get('team_info',[TeamController::class,'getTeam']);
    Route::get('task_info',[TaskController::class,'getTask']);
    Route::get('team_member_info/{id}',[MemberController::class,'getTeamMember']);

    Route::apiResource('activity_log',LogActivityController::class);
});

// User Route
Route::group(['middleware' => ['auth:manager']], function() {
    Route::get('assigned_task',[TaskAssignController::class,'tasklist']);
    Route::get('task_assign_id/{id}',[TaskAssignController::class,'taskdone']);

});
