<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\AuthenticationController;
use App\Http\Controllers\API\EstateAccountAPIController;
use App\Http\Controllers\API\UserAPIController;
use App\Http\Controllers\API\EstateAPIController;
use App\Http\Controllers\API\VerificationController;
use App\Http\Controllers\API\ResidentAPIController;
use App\Http\Controllers\API\StreetAPIController;
use App\Http\Controllers\API\VisitorPassAPIController;
use App\Http\Controllers\API\CityAPIController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\ComplainAPIController;
use App\Http\Controllers\API\NotificationAPIController;
use App\Http\Controllers\API\BillingAPIController;
use App\Http\Controllers\API\VisitorPassCategoryAPIController;
use App\Http\Controllers\API\InvoiceAPIController;
use App\Http\Controllers\API\TransactionAPIController;
use App\Http\Controllers\API\WalletHistoryAPIController;
use App\Http\Controllers\API\FlutterwaveController;
use App\Http\Controllers\API\ComplainCategoryAPIController;
use App\Http\Controllers\API\ComplainResponseAPIController;
use App\Http\Controllers\API\NotificationGroupAPIController;
use App\Http\Controllers\API\WalletAPIController;
use App\Http\Controllers\API\SettingAPIController;
use App\Http\Controllers\API\CountryAPIController;
use App\Http\Controllers\API\StateAPIController;
use App\Http\Controllers\API\BankAPIController;
use App\Http\Controllers\API\RoleAPIController;
use App\Http\Controllers\API\ModuleAccessAPIController;
use App\Http\Controllers\API\RoleModuleAccessAPIController;
use App\Http\Controllers\API\TestingController;

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
Route::get('/check', function () {
    Artisan::call('queue:work');
});
Route::post('estate_account/{estate_id}', [EstateAccountAPIController::class, 'store']);
Route::apiResource('estate_account', EstateAccountAPIController::class);
Route::post('resend-verification-email', [VerificationController::class, 'resend']);
Route::post('login', [AuthenticationController::class, 'authenticate']);
Route::post('register', [AuthenticationController::class, 'adminRegister']);
Route::post('register', [AuthenticationController::class, 'residentRegister']);
Route::post('forgot_password', [AuthenticationController::class, 'forgotPassword']);
Route::post('user_reset_password', [AuthenticationController::class, 'UserResetPassword']);
Route::post('residents', [ResidentAPIController::class, 'store']);
Route::get('streets', [StreetAPIController::class, 'index']);
Route::get('visitor_pass_authentication', [VisitorPassAPIController::class, 'passAuthentication']);
Route::post('estate_code_validation', [EstateAPIController::class, 'validateEstateCode']);
Route::get('generate_random', [EstateAccountAPIController::class, 'generateRandomNumbers']);
Route::get('city_filter_by_state/{state_id}', [CityAPIController::class, 'filterByState']);
Route::get('billing_job_testing', [TestingController::class, 'billingJobTesting']);
Route::get('roles-for-user-creations', [RoleAPIController::class, 'userCreationIndex']);

Route::group(['middleware' => ['jwt.verify', 'api_user_verified']], function() {
    Route::get('logout', [AuthenticationController::class, 'logout']);
    Route::post('user_toggle_status', [UserAPIController::class, 'toggleStatus']);
    Route::post('resident-activate-deactivate', [ResidentAPIController::class, 'changeUserStatus']);
    Route::post('activate-deactivate-pass/{id}', [VisitorPassAPIController::class, 'activateDeactivatePass']);
    Route::get('estate-index-paginate', [EstateAPIController::class, 'indexPaginate']);
    Route::post('estate_toggle_status', [EstateAPIController::class, 'toggleStatus']);
    Route::post('street_toggle_status', [StreetAPIController::class, 'toggleStatus']);
    Route::get('get_authenticated_user', [AuthenticationController::class, 'get_user']);
    Route::get('dashboard_analytics', [DashboardController::class, 'dashboardAnalytics']);
    Route::post('reset_password', [AuthenticationController::class, 'resetPassword']);
    Route::post('resident_datatable', [ResidentAPIController::class, 'indexDataTable']);
    Route::post('visitor_pass_datatable', [VisitorPassAPIController::class, 'indexDataTable']);
    Route::post('user_datatable', [UserAPIController::class, 'indexDataTable']);
    Route::post('complain_datatable', [ComplainAPIController::class, 'indexDataTable']);
    Route::post('notification_datatable', [NotificationAPIController::class, 'indexDataTable']);
    Route::resource('users', UserAPIController::class)->except('destroy');
    Route::resource('estates', EstateAPIController::class);
    Route::resource('states', StateAPIController::class);
    Route::resource('cities', CityAPIController::class);
    Route::resource('banks', BankAPIController::class);
    Route::resource('roles', RoleAPIController::class);
    Route::resource('residents', ResidentAPIController::class)->only(['index', 'show', 'update']);
    Route::resource('module_accesses', ModuleAccessAPIController::class);
    Route::resource('role_module_access', RoleModuleAccessAPIController::class)->only('store');
    Route::get('visitor_passes_per_user/{user_id}', [VisitorPassAPIController::class, 'userIndex']);
    Route::resource('visitor_passes', VisitorPassAPIController::class);
    Route::resource('visitor_pass_categories', VisitorPassCategoryAPIController::class);
    Route::resource('billings', BillingAPIController::class);
    Route::post('pay-invoice', [InvoiceAPIController::class, 'payInvoice']);
    Route::get('user-outstanding', [InvoiceAPIController::class, 'userOutstanding']);
    Route::get('all-user-outstanding', [InvoiceAPIController::class, 'allUsersOutstanding']);
    Route::get('sum-user-outstanding', [InvoiceAPIController::class, 'sumUserOutstanding']);
    Route::get('all-sum-users-outstanding', [InvoiceAPIController::class, 'allSumUsersOutstanding']);
    Route::get('invoices_per_user/{user_id}', [InvoiceAPIController::class, 'userIndex']);
    Route::resource('invoices', InvoiceAPIController::class);
    Route::resource('transactions', TransactionAPIController::class);
    Route::get('wallet_histories_per_user/{user_id}', [WalletHistoryAPIController::class, 'userIndex']);
    Route::resource('wallet_histories', WalletHistoryAPIController::class);
    Route::resource('streets', StreetAPIController::class)->except('index');
    Route::post('/pay', [FlutterwaveController::class, 'initialize'])->name('pay');
    Route::get('flutterwave/callback', [FlutterwaveController::class, 'callback'])->name('callback');
    Route::get('flutterwave/name_check', [FlutterwaveController::class, 'nameVerification'])->name('name_verification');
    Route::get('complain_categories/complain/{id}', [ComplainCategoryAPIController::class, 'getComplainByCategoryId']);
    Route::resource('complain_categories', ComplainCategoryAPIController::class);
    Route::get('complains/close-ticket/{id}', [ComplainAPIController::class, 'closeComplain']);
    Route::get('complains_per_user/{user_id}', [ComplainAPIController::class, 'userIndex']);
    Route::resource('complains', ComplainAPIController::class);
    Route::resource('complain_responses', ComplainResponseAPIController::class);
    Route::post('send_notifications', [NotificationAPIController::class, 'sendNotificationMessages']);
    Route::resource('notifications', NotificationAPIController::class);
    Route::resource('notification_groups', NotificationGroupAPIController::class);
    Route::resource('wallets', WalletAPIController::class)->only('index');
    Route::resource('settings', SettingAPIController::class);
    Route::get('/user/notifications', [UserAPIController::class, 'notifications'])->middleware('MarkAsRead');
});

Route::resource('countries', CountryAPIController::class);


