<?php

use App\Http\Controllers\Api\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\PostImpersonateController;
use App\Http\Controllers\Api\Auth\RefreshTokenControllerController;
use App\Http\Controllers\Api\Auth\ResetPasswordController;
use App\Http\Controllers\Api\Auth\SignUpController;
use App\Http\Controllers\Api\Checkout\GetPlanCheckoutPathController;
use App\Http\Controllers\Api\Checkout\GetPlansController;
use App\Http\Controllers\Api\Checkout\GetPortalPathController;
use App\Http\Controllers\Api\Checkout\GetPriceCheckoutPathController;
use App\Http\Controllers\Api\Checkout\GetPricesController;
use App\Http\Controllers\Api\Dashboard\DeleteDashboardsController;
use App\Http\Controllers\Api\Dashboard\GetDashboardByUuidController;
use App\Http\Controllers\Api\Dashboard\GetDashboardsController;
use App\Http\Controllers\Api\Dashboard\GetDashboardTriggersByUuidController;
use App\Http\Controllers\Api\Dashboard\PostDashboardsController;
use App\Http\Controllers\Api\Dashboard\PutDashboardsController;
use App\Http\Controllers\Api\Notifications\GetNotificationsController;
use App\Http\Controllers\Api\Open\GetOpenDataController;
use App\Http\Controllers\Api\Services\GetServicesController;
use App\Http\Controllers\Api\Socialite\RedirectToDriverController;
use App\Http\Controllers\Api\Socialite\StoreUserServiceController;
use App\Http\Controllers\Api\Triggers\DeleteTriggersController;
use App\Http\Controllers\Api\Triggers\GetGraphStatsController;
use App\Http\Controllers\Api\Triggers\GetParametersGraphStatsController;
use App\Http\Controllers\Api\Triggers\GetPublicDashboardTriggerParameterStatsController;
use App\Http\Controllers\Api\Triggers\GetPublicDashboardTriggerStatsController;
use App\Http\Controllers\Api\Triggers\GetPublicGraphStatsController;
use App\Http\Controllers\Api\Triggers\GetPublicParametersGraphStatsController;
use App\Http\Controllers\Api\Triggers\GetTriggerParameterStatsController;
use App\Http\Controllers\Api\Triggers\GetTriggersController;
use App\Http\Controllers\Api\Triggers\GetTriggerStatsController;
use App\Http\Controllers\Api\Triggers\PostTriggersController;
use App\Http\Controllers\Api\Triggers\PutTriggersController;
use App\Http\Controllers\Api\TriggerTypes\GetTriggerTypesController;
use App\Http\Controllers\Api\Users\GetUserController;
use App\Http\Controllers\Api\Users\GetUserUsageController;
use App\Http\Controllers\Api\Users\PostUserDefaultsController;
use App\Http\Controllers\Api\UserServices\DeleteUserServiceController;
use App\Http\Controllers\Api\UserServices\GetUserServicesController;
use App\Http\Controllers\Api\UserServices\PostServiceController;
use App\Http\Controllers\Tally\PostTallyController;
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

// Auth
Route::post('/signup', SignUpController::class);
Route::post('/login', LoginController::class);
Route::post('/logout', LogoutController::class);
Route::post('/forgot-password', ForgotPasswordController::class);
Route::post('/reset-password', ResetPasswordController::class);
Route::post('/refresh', RefreshTokenControllerController::class);

// Impersonate
Route::post('/auth/impersonate/', PostImpersonateController::class);

// Open data
Route::get('/open', GetOpenDataController::class);

// User
Route::get('/users', GetUserController::class);
Route::post('/users/defaults', PostUserDefaultsController::class);
Route::get('/users/services', GetUserServicesController::class);
Route::post('/users/services', PostServiceController::class);
Route::delete('/users/services/{userService}', DeleteUserServiceController::class);

// Usage
Route::get('/users/usage', GetUserUsageController::class);

// Checkout
Route::get('/checkout/prices', GetPricesController::class);
Route::get('/checkout/plans', GetPlansController::class);
Route::get('/checkout/portal-path', GetPortalPathController::class);
Route::get('/checkout/prices/{price}', GetPriceCheckoutPathController::class);
Route::get('/{team}/checkout/plan/{planId}/{period}', GetPlanCheckoutPathController::class);

// Notifications
Route::get('/teams/{team}/notifications', GetNotificationsController::class);

// Trigger types
Route::get('/trigger-types', GetTriggerTypesController::class);

// Triggers
Route::post('/{team}/triggers', PostTriggersController::class);
Route::put('/triggers/{trigger:uuid}', PutTriggersController::class);
Route::delete('/triggers/{trigger:uuid}', DeleteTriggersController::class);
Route::get('/{team}/triggers', GetTriggersController::class);

// Dashboard
Route::get('/{team}/dashboards', GetDashboardsController::class);
Route::post('/{team}/dashboards', PostDashboardsController::class);
Route::put('/dashboards/{dashboard}', PutDashboardsController::class);
Route::delete('/dashboards/{dashboard}', DeleteDashboardsController::class);
Route::get('/dashboards/{dashboard:uuid}', GetDashboardByUuidController::class);
Route::get('/dashboards/{dashboard:uuid}/triggers', GetDashboardTriggersByUuidController::class);

// Graphs
Route::get('/triggers/{trigger:uuid}/graph-stats', GetGraphStatsController::class);
Route::get('/triggers/{trigger:uuid}/parameters-graph-stats', GetParametersGraphStatsController::class);
$dashboardAndTrigger = '/dashboards/{dashboard:uuid}/triggers/{trigger:uuid}';
Route::get($dashboardAndTrigger.'/graph-stats', GetPublicGraphStatsController::class)
    ->withoutScopedBindings();
Route::get($dashboardAndTrigger.'/parameters-graph-stats', GetPublicParametersGraphStatsController::class)
    ->withoutScopedBindings();

// ↓ - Deprecated Graphs Endpoints
Route::get('/triggers/{trigger:uuid}/stats', GetTriggerStatsController::class); // deprecated
Route::get('/triggers/{trigger:uuid}/parameters-stats', GetTriggerParameterStatsController::class); // deprecated
Route::get($dashboardAndTrigger.'/stats', GetPublicDashboardTriggerStatsController::class)
    ->withoutScopedBindings();
Route::get($dashboardAndTrigger.'/parameters-stats', GetPublicDashboardTriggerParameterStatsController::class)
    ->withoutScopedBindings();
// ↑ - Deprecated

// Services
Route::get('/services', GetServicesController::class);

// Tally
Route::post('/tally', PostTallyController::class);

// Socialite
Route::get('/auth/{service:driver}/redirect', RedirectToDriverController::class);
Route::get('/auth/{service:driver}/callback', StoreUserServiceController::class);

// ---------------------------------------------------------------------------------------------------------------------
// Modules
// ---------------------------------------------------------------------------------------------------------------------
require __DIR__.'/../src/Channels/Http/Routes/api.php';
require __DIR__.'/../src/Teams/Http/Routes/api.php';
