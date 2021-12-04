<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\AuthenticationController;

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


Route::get('testing', function ()
{
    return "This endpoint is reachable and the URL is valid";
});
Route::post('login', [AuthenticationController::class, 'authenticate']);
Route::post('register', [AuthenticationController::class, 'adminRegister']);
Route::post('register', [AuthenticationController::class, 'residentRegister']);
Route::post('forgot_password', [AuthenticationController::class, 'forgotPassword']);
Route::post('user_reset_password', [AuthenticationController::class, 'UserResetPassword']);
Route::post('residents', [\App\Http\Controllers\API\ResidentAPIController::class, 'store']);
Route::get('streets', [\App\Http\Controllers\API\StreetAPIController::class, 'index']);
Route::get('visitor_pass_authentication', [\App\Http\Controllers\API\VisitorPassAPIController::class, 'passAuthentication']);
Route::post('estate_code_validation', [\App\Http\Controllers\API\EstateAPIController::class, 'validateEstateCode']);
Route::get('city_filter_by_state/{state_id}', [\App\Http\Controllers\API\CityAPIController::class, 'filterByState']);
Route::get('billing_job_testing', [\App\Http\Controllers\API\TestingController::class, 'billingJobTesting']);

/*Route::get('storage/{foldername}/{filename}', function ($foldername, $filename)
{
//    return "hello";
    $path = storage_path('app\\' .$foldername.'\\'. $filename);
//    return $path;
    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
})->name('getImages');*/
/**
 * - get Residents by estate if Done
- get visitor pass by resident  Id or user id Done
- get complaints by residents Id or user id
- get invoices by residents id  or user id
- get payments by user id
 */

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('logout', [AuthenticationController::class, 'logout']);
    Route::post('user_toggle_status', [\App\Http\Controllers\API\UserAPIController::class, 'toggleStatus']);
    Route::get('estate-index-paginate', [\App\Http\Controllers\API\EstateAPIController::class, 'indexPaginate']);
    Route::post('estate_toggle_status', [\App\Http\Controllers\API\EstateAPIController::class, 'toggleStatus']);
    Route::post('street_toggle_status', [\App\Http\Controllers\API\StreetAPIController::class, 'toggleStatus']);
    Route::get('get_authenticated_user', [AuthenticationController::class, 'get_user']);
    Route::post('reset_password', [AuthenticationController::class, 'resetPassword']);
    Route::resource('users', UserAPIController::class);
    Route::resource('estates', EstateAPIController::class);
    Route::resource('states', StateAPIController::class);
    Route::resource('cities', CityAPIController::class);
    Route::resource('banks', BankAPIController::class);
    Route::resource('roles', RoleAPIController::class);
    Route::resource('residents', ResidentAPIController::class)->except('store');
    Route::resource('module_accesses', ModuleAccessAPIController::class);
    Route::resource('role_module_access', RoleModuleAccessAPIController::class)->only('store');
    Route::resource('visitor_passes', VisitorPassAPIController::class);
    Route::resource('visitor_pass_categories', VisitorPassCategoryAPIController::class);
    Route::resource('billings', \BillingAPIController::class);
    Route::resource('invoices', \InvoiceAPIController::class);
    Route::resource('transactions', \TransactionAPIController::class);
    Route::resource('wallet_histories', \WalletHistoryAPIController::class);
    Route::resource('streets', \StreetAPIController::class)->except('index');
    Route::post('/pay', [\App\Http\Controllers\API\FlutterwaveController::class, 'initialize'])->name('pay');
    Route::get('/flutterwave/callback', [\App\Http\Controllers\API\FlutterwaveController::class, 'callback'])->name('callback');
    Route::get('complain_categories/complain/{id}', [\App\Http\Controllers\API\ComplainCategoryAPIController::class, 'getComplainByCategoryId']);
    Route::resource('complain_categories', \ComplainCategoryAPIController::class);
    Route::get('complains/close-ticket/{id}', [\App\Http\Controllers\API\ComplainAPIController::class, 'closeComplain']);
    Route::resource('complains', \ComplainAPIController::class);
    Route::resource('complain_responses', \ComplainResponseAPIController::class);
    Route::resource('notifications', \NotificationAPIController::class);
    Route::resource('notification_groups', \NotificationGroupAPIController::class);
    Route::resource('wallets', \WalletAPIController::class)->only('index');
});

Route::resource('countries', \CountryAPIController::class);

