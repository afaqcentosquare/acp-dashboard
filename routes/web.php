<?php
use App\Http\Controllers\SuperAdmin\AuthController;
use App\Http\Controllers\SuperAdmin\DashboardController;
use App\Http\Controllers\SuperAdmin\AssetProviderController;
use App\Http\Controllers\SuperAdmin\CategoryController;
use App\Http\Controllers\SuperAdmin\AssetController;
use App\Http\Controllers\SuperAdmin\ProductCatalogController;
use App\Http\Controllers\SuperAdmin\PaymentController;
use App\Http\Controllers\SuperAdmin\PerformanceController;
use App\Http\Controllers\SuperAdmin\LocationController;
use App\Http\Controllers\SuperAdmin\FaqsController;
use App\Http\Controllers\SuperAdmin\AnnouncementController;
use App\Http\Controllers\SuperAdmin\InvoiceController;
use App\Http\Controllers\SuperAdmin\RedirectController;
use App\Http\Controllers\AssetProvider\AuthController as AssetProviderAuthController;
use App\Http\Controllers\AssetProvider\DashboardController as AssetProviderDashboardController;
use App\Http\Controllers\AssetProvider\ProductCatalogController as AssetProviderProductCatalogController;
use App\Http\Controllers\AssetProvider\TransactionController as AssetProviderTransactionController;
use App\Http\Controllers\Merchant\DashboardController as MerchantDashboardController;
use App\Http\Controllers\Merchant\CatalogController as MerchantCatalogController;
use App\Http\Controllers\Merchant\InvoiceController as MerchantInvoiceController;
use App\Http\Controllers\Merchant\TransactionController as MerchantTransactionController;
use App\Http\Controllers\Mail\MailController;
use App\Http\Controllers\MPESA\MpesaController;
use App\Http\Controllers\USSD\ACPUSSDController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */
Route::get('/basic_email', [MailController::class, 'basic_email']);
Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});

//Route cache:
Route::get('/route-cache', function() {
    $exitCode = Artisan::call('route:cache');
    return '<h1>Routes cached</h1>';
});

/**
 * Super Admin Routes
 */

Route::prefix('admin')->group(function () {


    /**
     * Auth Routes
     */
    Route::get('/login', [AuthController::class, 'loginView'])->name("superadmin.login");
    Route::post('/checklogin', [AuthController::class, 'checkLogin'])->name("superadmin.checklogin");
    

    /**
     * Admin Routes With Middleware
     */
    Route::group(['middleware' => 'admin'], function () {
        
        /**
         * Dashboard Routes
         */
        Route::get('/', [DashboardController::class, 'index'])->name("superadmin.dashboard");
        

        /**
         * Asset Providers Routes
         */
        Route::get('assetprovider', [AssetProviderController::class, 'index'])->name("superadmin.assetprovider");
        Route::get('update/assetprovider/status/{id}/{status}', [AssetProviderController::class, 'updateStatus'])->name("superadmin.update.assetprovider.status");
        Route::get('get-subgroups', [AssetProviderController::class, 'getSubGroups']);
        Route::get('get-category-by-subgroups', [AssetProviderController::class, 'getCategoriesBySubGroups']);
        /**
         * Categories Routes
         */
        Route::get('categories', [CategoryController::class, 'index'])->name("superadmin.categories");
        Route::post('categories/store', [CategoryController::class, 'store'])->name("superadmin.categories.store");
        Route::get('categories/show/{id}/{type}', [CategoryController::class, 'show'])->name("superadmin.categories.show");
        Route::post('group/store', [CategoryController::class, 'storeGroup'])->name("superadmin.group.store");
        Route::get('subgroup/{id}', [CategoryController::class, 'subGroupView'])->name("superadmin.subgroup.view");
        Route::post('subgroup/store', [CategoryController::class, 'storeSubGroup'])->name("superadmin.subgroup.store");

        /**
         * Assets Routes
         */
        Route::get('assets', [AssetController::class, 'index'])->name("superadmin.assets");
        Route::post('asset/store', [AssetController::class, 'store'])->name("superadmin.asset.store");
        Route::post('asset/update/{id}', [AssetController::class, 'update'])->name("superadmin.asset.update");

        /**
         * Product Catalog Routes
         */
        Route::get('productcatalog', [ProductCatalogController::class, 'index'])->name("superadmin.productcatalog");

        /**
         * Payments Routes
         */
        Route::get('payments', [PaymentController::class, 'index'])->name("superadmin.payments");

        /**
         * Invoice Routes 
         */
        Route::get('invoices', [InvoiceController::class, 'index'])->name("superadmin.invoices");
        Route::get('pay/invoice/{id}', [InvoiceController::class, 'payNow'])->name("superadmin.pay.now");

        /**
         * Performance Routes
         */
        Route::get('performance', [PerformanceController::class, 'index'])->name("superadmin.performance");
        Route::get('redirect/merchant/{id}', [RedirectController::class, 'redirectMerchant'])->name("superadmin.redirect.merchant");
        Route::get('redirect/assetprovider/{id}', [RedirectController::class, 'assetProviderRedirect'])->name("superadmin.redirect.assetprovider");
        Route::get('defaulter/merchant/{id}', [PerformanceController::class, 'defaulterMerchant'])->name("superadmin.defaulter.merchant");
        /**
         * Location Routes
         */
        Route::get('locations', [LocationController::class, 'index'])->name("superadmin.locations");

        /**
         * Faqs Routes
         */
        Route::get('faqs', [FaqsController::class, 'index'])->name("superadmin.faqs");
        Route::post('faqs/store', [FaqsController::class, 'store'])->name("superadmin.faqs.store");
        Route::post('faqs/update/{id}', [FaqsController::class, 'update'])->name("superadmin.faqs.update");
        Route::post('faqs/topic/store', [FaqsController::class, 'storeTopic'])->name("superadmin.faqs.topic.store");
        Route::post('faqs/topic/update/{id}', [FaqsController::class, 'updateTopic'])->name("superadmin.faqs.topic.update");

        /**
         * Announcement Routes
         */
        Route::get('announcements', [AnnouncementController::class, 'index'])->name("superadmin.announcements");
        Route::post('announcement/store', [AnnouncementController::class, 'store'])->name("superadmin.announcement.store");

        /**
         * Logout Route
         */
        Route::get('/logout', [AuthController::class, 'logout'])->name("superadmin.logout");
    });
});



/**
 * Asset Provider Routes
*/

/**
 * Auth Routes
*/

Route::get('/', [AssetProviderAuthController::class, 'loginView'])->name("assetprovider.loginview");
Route::get('/register', [AssetProviderAuthController::class, 'registerRequestView'])->name("assetprovider.registerview");
Route::get('/set-password/{id}', [AssetProviderAuthController::class, 'setPasswordView'])->name("assetprovider.set.passwordview");
Route::post('/set-password/{id}', [AssetProviderAuthController::class, 'setPassword'])->name("assetprovider.set.password");
Route::post('/register/request', [AssetProviderAuthController::class, 'registerRequest'])->name("assetprovider.register.request");
Route::post('/assetprovider/checklogin', [AssetProviderAuthController::class, 'checkLogin'])->name("assetprovider.checklogin");

/**
 * Asset Provider Middleware
*/
Route::group(['middleware' => 'asset.provider'], function () {
    /**
     * Asset Provider Group
    */
    Route::prefix('assetprovider')->group(function () {
        /**
         * Dashboard Routes 
         */
        Route::get('dashboard', [AssetProviderDashboardController::class, 'index'])->name("assetprovider.dashboard");

        /**
         * Product Catalog Routes
         */
        Route::get('productcatalog', [AssetProviderProductCatalogController::class, 'index'])->name("assetprovider.productcatalog");
        Route::get('productcatalog/update/status/{id}/{is_single}', [AssetProviderProductCatalogController::class, 'updateStatus'])->name("assetprovider.productcatalog.update.status");
        Route::post('productcatalog/update/stock/{id}', [AssetProviderProductCatalogController::class, 'updateStock'])->name("assetprovider.productcatalog.update.stock");
        /**
         * Transaction Routes
         */
        Route::get('transactions', [AssetProviderTransactionController::class, 'index'])->name("assetprovider.transactions");
        Route::post('withdraw/amount', [AssetProviderTransactionController::class, 'withDrawCash'])->name("assetprovider.withdraw.amount");
        Route::post('b2c/result', [MpesaController::class, 'B2CResultResponse'])->name("assetprovider.mpesa.result");
        Route::post('b2c/timeout', [MpesaController::class, 'B2CTimeoutResponse'])->name("assetprovider.mpesa.timeout");
         /**
         * Logout Route
         */
        Route::get('logout', [AssetProviderAuthController::class, 'logout'])->name("assetprovider.logout");
    });
});

/**
 * Merchant Routes
*/
    /**
     * Merchant Group
    */
    Route::prefix('merchant')->group(function () {
        /**
         * Dashboard Routes 
         */
        Route::get('dashboard', [MerchantDashboardController::class, 'index'])->name("merchant.dashboard");

        /**
         * Catalog Routes 
         */
        Route::get('catalog', [MerchantCatalogController::class, 'index'])->name("merchant.catalog");
        Route::post('asset/request', [MerchantCatalogController::class, 'store'])->name("merchant.asset.request");
        Route::get('update/order/status/{id}/{status}', [MerchantCatalogController::class, 'updateMerchantOrderAssetStatus'])->name("merchant.update.order.status");
        

        /**
         * Invoice Routes 
         */
        Route::get('invoices', [MerchantInvoiceController::class, 'index'])->name("merchant.invoices");
        Route::get('pay/invoice/{id}', [MerchantInvoiceController::class, 'payNow'])->name("merchant.pay.now");
        /**
         * Transaction Routes 
         */
        Route::get('transactions', [MerchantTransactionController::class, 'index'])->name("merchant.transactions");
        Route::post('deposit/amount', [MerchantTransactionController::class, 'depositAmount'])->name("merchant.deposit.amount");

        /**
         * USSD Routes
         */
        Route::post('ussdrequest', [ACPUSSDController::class, 'store']);
    });