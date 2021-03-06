<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EmploymentsController;
use App\Http\Controllers\Misc\EnumsController;
use App\Http\Controllers\Misc\InfoController;
use App\Http\Controllers\Misc\LocationController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectMemberController;
use App\Http\Controllers\ProspectController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\StateMemberController;
use App\Http\Controllers\TrainingAttendanceController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('ping', function () {
    return response()->json('pong');
});

Route::middleware('throttle:5')->post('apply', [ProspectController::class, 'store']);

Route::middleware('throttle:10')->prefix('auth')->group(function () {
    Route::post('get-started', [RegistrationController::class, 'getStarted']);
    Route::post('verify-email', [RegistrationController::class, 'verifyEmail']);
    Route::post('account', [RegistrationController::class, 'createAccount']);
    Route::post('login', LoginController::class);
    Route::post('forgot-password', [PasswordController::class, 'sendPasswordResetCode']);
    Route::post('verify-password-code', [PasswordController::class, 'verifyPasswordResetCode']);
    Route::post('reset-password', [PasswordController::class, 'setNewPassword']);
});

Route::prefix('misc')->group(function () {
    Route::get('states', [LocationController::class, 'states']);
    Route::get('categories', [CategoryController::class, 'index']);
    Route::middleware('throttle:5')->post('contact-us', [InfoController::class, 'contact']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('auth/profile', [ProfileController::class, 'show']);
    Route::match(['post', 'patch'], 'auth/profile', [ProfileController::class, 'update']);
    Route::get('auth/profile/gmb-progress', [ProfileController::class, 'projectProgress']);
    Route::get('auth/notifications', [ProfileController::class, 'getNotifications']);
    Route::patch('auth/notifications', [ProfileController::class, 'updateNotificationsRead']);
    Route::get('auth/attendance', [ProfileController::class, 'getTrainingAttendance']);

    Route::resource('users', UserController::class)->except('destroy');
    Route::post('users/{user}/trainings/{training}', [UserController::class, 'recordAttendance']);

    Route::resource('news', ArticlesController::class)->parameters(['news' => 'article']);

    Route::resource('jobs', EmploymentsController::class);

    Route::post('trainings/{training}/attendance', [TrainingAttendanceController::class, 'store']);
    Route::post('trainings/{training}/attendance/import', [TrainingAttendanceController::class, 'import']);
    Route::resource('trainings', TrainingController::class);

    Route::get('projects', [ProjectController::class, 'index']);
    Route::get('projects/{project}', [ProjectController::class, 'show']);
    Route::patch('projects/{project}', [ProjectController::class, 'update']);
    Route::post('projects/{project}/business', [ProjectController::class, 'storeGmbSubmission']);
    Route::post('projects/{project}/members', [ProjectMemberController::class, 'store']);

    Route::get('businesses', [ProjectController::class, 'getAllGmbSubmissions']);
    Route::get('businesses/{business}', [ProjectController::class, 'getGmbSubmission']);
    Route::patch('businesses/{business}', [ProjectController::class, 'UpdateGmbSubmission']);
    Route::post('businesses/import', [ProjectController::class, 'import']);

    Route::patch('project-members/{member}', [ProjectMemberController::class, 'update']);
    Route::delete('project-members/{member}', [ProjectMemberController::class, 'destroy']);

    Route::get('states/{state}/members', [StateMemberController::class, 'index']);
    Route::post('states/{state}/members', [StateMemberController::class, 'store']);
    Route::patch('state-members/{member}', [StateMemberController::class, 'update']);
    Route::delete('state-members/{member}', [StateMemberController::class, 'destroy']);
    Route::post('states/{state}/import/users', [UserController::class, 'import']);

    Route::get('prospects', [ProspectController::class, 'index']);
    Route::patch('prospects', [ProspectController::class, 'updateProspectsStatus']);
    Route::patch('prospects/{prospect}', [ProspectController::class, 'update']);

    Route::resource('resources', ResourceController::class)->only(['store', 'update', 'destroy']);

    Route::resource('announcements', AnnouncementController::class)->except('destroy');

    Route::prefix('enums')->group(function () {
        Route::get('batches', [EnumsController::class, 'batches']);
        Route::get('project-statuses', [EnumsController::class, 'projectStatuses']);
        Route::get('project-types', [EnumsController::class, 'projectTypes']);
        Route::get('project-member-types', [EnumsController::class, 'projectMemberTypes']);
        Route::get('prospect-statuses', [EnumsController::class, 'prospectStatuses']);
        Route::get('training-statuses', [EnumsController::class, 'trainingStatuses']);
        Route::get('state-member-types', [EnumsController::class, 'stateMemberTypes']);
        Route::get('gmb-statuses', [EnumsController::class, 'gMBStatuses']);
    });
});
