<?php

use App\Models\Customer;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\OthersController;
use App\Http\Controllers\OwnershipController;
use App\Http\Controllers\Backend\PDFController;
use App\Http\Controllers\Backend\SmsController;
use App\Http\Controllers\Backend\SizeController;
use App\Http\Controllers\Backend\UnitController;
use App\Http\Controllers\Backend\UsedController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\ColorController;
use App\Http\Controllers\Backend\DamageController;
use App\Http\Controllers\Backend\ReportController;
use App\Http\Controllers\Backend\ExpenseController;
use App\Http\Controllers\Backend\InvoiceController;
use App\Http\Controllers\Backend\PaymentController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ServiceController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\CustomerController;
use App\Http\Controllers\Backend\PurchaseController;
use App\Http\Controllers\Backend\SupplierController;
use App\Http\Controllers\BusinessSettingsController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\VariationController;
use App\Http\Controllers\Backend\ReturnSaleController;
use App\Http\Controllers\Backend\BankAccountController;
use App\Http\Controllers\Backend\UsedProductController;
use App\Http\Controllers\Backend\UserProfileController;
use App\Http\Controllers\Backend\ReturnPurchaseController;
use App\Http\Controllers\Backend\BankTransactionController;
use App\Http\Controllers\Backend\RolesPermissionController;
use App\Http\Controllers\Backend\UsedProductPurchaseController;

use App\Http\Controllers\Frontend\FrontendController;


Route::get('/', function () {
    return view('auth.login');
});



// CLear
Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('route:clear');

    return view('auth.login');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'permission'])->group(function () {
    // Route::controller(DashboardController::class)->group(function (){

    //     Route::get('/dashboard', 'index')->name('dashboard');
    //     Route::get('/dashboard/today', 'today')->name('dashboard.dashboard');
    // });
    Route::controller(DashboardController::class)->group(function () {

        Route::get('/dashboard', 'index')->name('dashboard');
        Route::get('/dashboard/today', 'today')->name('dashboard.dashboard');

        Route::get('/dashboard/filter', 'filterData')->name('your.filter.route');

        // Route::get('/dashboard/filter', 'filter')->name('dashboard.filter');

    });

    // --------------------- POS ---------------------
    Route::controller(InvoiceController::class)->group(function () {
        Route::post('/invoice/log/store',  'storeInvoiceLog')->name('storeInvoiceLog');
        Route::get('/invoice/pay/{id}', 'invoicePay')->name('invoice.pay');
        Route::get('/invoice/eedit/{id}', 'invoiceEdit')->name('inv.edit');
        Route::post('/invoice/update/{id}', 'invoiceUpdate')->name('invoice.up');
        Route::get('/invoice/exchange/{id}', 'invoiceExchange')->name('invoice.exchange');
        Route::get('/print/invoice/{id}', 'printInvoice')->name('invoice.print');
        Route::get('/print/invoice/due/{id}', 'dueInvoicePrint')->name('due.invoice.print');
        Route::post('/invoice/return/{id}', 'returnInvoice')->name('invoice.return');
        Route::post('/invoice/return/amount/{id}', 'returnAmount')->name('invoice.return.amount');
        Route::post('/invoice/exchange/update', 'updateExchangeInvoice')->name('invoice.ex.update');
        // Route::get('/invoice/due/print/{id}', 'dueInvoicePrint')->name('due.invoice.print');

    });
    Route::resource('invoice', InvoiceController::class);

    // --------------------> Purchase <--------------------
    Route::controller(PurchaseController::class)->group(function () {
        Route::post('/purchase/log/store',  'storePurchaseLog')->name('storePurchaseLog');
        Route::get('/purchase/pay/{id}', 'purchasePay')->name('purchase.pay');
        Route::get('/purchase/edit/{id}', 'purchaseEdit')->name('purchase.edit');
        Route::post('/purchase/update/{id}', 'purchaseUpdate')->name('purchase.updat');
        Route::get('/print/purchase/{id}', 'printPurchase')->name('purchase.print');
        Route::get('/imei-print/purchase/{id}', 'imeiPrintPurchase')->name('purchase.imei-print');

        Route::get('/purchase/search', 'search')->name('purchase.search');
    });
    Route::resource('purchase', PurchaseController::class);

    // ----------------->  used product section <----------------
    Route::resource('usedProduct', UsedProductController::class);
    Route::resource('usedPurchase', UsedProductPurchaseController::class);
    Route::resource('used', UsedController::class);

    // --------------------> customers <--------------------
    Route::resource('customer', CustomerController::class)->except(['show', 'edit', 'create']);

    // --------------------> ownership <--------------------
    Route::resource('ownership', OwnershipController::class);

    // --------------------> suppliers <--------------------
    Route::resource('supplier', SupplierController::class)->except(['show', 'edit', 'create']);

    // --------------------> units <--------------------
    Route::resource('unit', UnitController::class)->except(['show', 'edit', 'create']);

    // --------------------> category <--------------------
    Route::resource('category', CategoryController::class)->except(['show', 'edit', 'create']);

    // --------------------> color <--------------------
    Route::resource('color', ColorController::class);

    // --------------------> color <--------------------
    Route::resource('size', SizeController::class);

    // --------------------> variation <--------------------
    Route::resource('variation', VariationController::class);

    Route::get('/customer/points/{id}', function ($id) {
        $customer = Customer::find($id);
        return response()->json(['total_point' => $customer ? $customer->total_point : 0]);
    });

    // --------------------> brands <--------------------
    Route::resource('brand', BrandController::class)->except(['show', 'edit', 'create']);

    // --------------------> sms <--------------------
    Route::resource('sms', SmsController::class)->except(['show', 'edit', 'create']);

    Route::get('/generate-variations', [VariationController::class, 'generateVariations']);
    Route::get('/variations', [VariationController::class, 'getVariations']);

    // --------------------> products <--------------------
    // Route::resource('product', ProductController::class);
    Route::controller(ProductController::class)->group(function () {
        Route::get('/product', 'index')->name('product.index');
        Route::get('/product/create', 'create')->name('product.create');
        Route::post('/product/store', 'store')->name('product.store');
        // Route::get('/product/edit/{}','edit/')->name('product.edit/');
        Route::get('/product/edit/{id}', 'edit')->name('product.edit');
        Route::post('/product/update/{id}', 'update')->name('product.update');
        Route::post('/product/destroy/{id}', 'destroy')->name('product.destroy');
        Route::get('/product/search', 'search')->name('product.search');
    });

    // --------------------> Service controller <--------------------
    Route::resource('service', ServiceController::class);

    // --------------------> Bank Account <--------------------
    Route::resource('bank-account', BankAccountController::class);

    // --------------------> Bank Transaction <--------------------
    Route::controller(BankTransactionController::class)->group(function () {
        // --------------------> Deposit <--------------------
        Route::get('/deposit', 'deposit')->name('deposit-create');
        Route::post('/deposit', 'depositStore')->name('deposit-store');

        // --------------------> Withdraw <--------------------
        Route::get('/withdraw', 'withdraw')->name('withdraw-create');
        Route::post('/withdraw', 'withdrawStore')->name('withdraw-store');

        // --------------------> Bank Transfer <--------------------
        Route::get('/bank-transfer-index', 'bankTransferIndex')->name('bank-transfer-index');
        Route::post('/bank-transfer', 'bankTransferStore')->name('bank-transfer-store');

        // --------------------> Transaction <--------------------
        Route::get('/transaction-history', 'transactionHistory')->name('transaction-history');
    });

    // --------------------> Payment <--------------------
    Route::controller(PaymentController::class)->prefix('payment')->name('payment.')->group(function () {
        // --------------------> Deposit <--------------------
        Route::get('/customer', 'payCustomer')->name('pay-customer');
        Route::post('/customer/store', 'payCustomerStore')->name('pay-customer-store');

        // --------------------> Deposit <--------------------
        Route::get('/supplier', 'paySupplier')->name('pay-supplier');
        Route::post('/supplier/store', 'paySupplierStore')->name('pay-supplier-store');

        // --------------------> destroy <--------------------
        Route::delete('/customer/destroy/{id}', 'customerDestroy')->name('customer-destroy');
        Route::delete('/supplier/destroy/{id}', 'supplierDestroy')->name('supplier-destroy');
    });

    // --------------------> expense <--------------------
    Route::resource('expense', ExpenseController::class);
    Route::controller(ExpenseController::class)->prefix('expense')->name('expense.')->group(function () {
        // --------------------> category <--------------------
        Route::get('/category/index', 'categoryIndex')->name('category-index');
        Route::post('/category/store', 'categoryStore')->name('category-store');
        Route::post('/category/update/{id}', 'categoryUpdate')->name('category-update');
        Route::delete('/category/destroy/{id}', 'categoryDestroy')->name('category-destroy');
    });

    // --------------------> Reports <--------------------
    Route::controller(ReportController::class)->prefix('report')->name('report.')->group(function () {
        Route::get('/stock', 'stock')->name('stock');
        Route::get('used/stock', 'usedStock')->name('used-stock');
        Route::get('/daily', 'daily')->name('daily');
        Route::get('/sale', 'sale')->name('sale');
        Route::get('/purchase', 'purchase')->name('purchase');
        Route::get('/supplier/ledger', 'supplierLedger')->name('supplier-ledger');
        Route::get('/customer/ledger', 'customerLedger')->name('customer-ledger');
        Route::get('/ownership/ledger', 'ownerShipLedger')->name('ownership-ledger');
        Route::get('/profit-loss', 'profitLoss')->name('profit-loss');
        Route::get('/supplier/due', 'supplierDue')->name('supplier-due');
        Route::get('/customer/due', 'customerDue')->name('customer-due');
        Route::get('/low-stock', 'low_stock')->name('low.stock');
        Route::get('/user/sell', 'user_sell')->name('user.sell');

        Route::get('/reports/top-selling-products', 'topSellingProducts')->name('reports.top-selling');
        Route::get('/reports/top-customers', 'topCustomers')->name('reports.customers');
        Route::get('/daily/stock', 'dailyStock')->name('daily.stock');
    });
    //------------------------- pdf ------------------
    Route::controller(PDFController::class)->prefix('report')->name('report.')->group(function () {
        Route::get('/stock/pdf', 'stock_pdf')->name('stock.pdf');
        Route::get('/daily/pdf', 'daily_pdf')->name('daily.pdf');
        Route::get('/user/sell/pdf', 'pdf')->name('user.sell.pdf');
    });

    // --------------------> users <--------------------
    Route::resource('user', UserController::class);

    // Managers Route ARE HERE...
    Route::controller(BusinessSettingsController::class)->prefix('setting')->name('setting.')->group(function () {
        Route::get('/index', 'index')->name('index');
        Route::post('/update', 'update')->name('update');
    });

    // --------------------> roles & permission <--------------------
    Route::controller(RolesPermissionController::class)->group(function () {
        Route::get('roles-permission', 'index')->name('roles-permission.index');
        Route::get('roles-permission/create', 'create')->name('roles-permission.create');
        Route::post('roles-permission', 'store')->name('roles-permission.store');
        Route::get('roles-permission/{id}/edit', 'edit')->name('roles-permission.edit');
        Route::post('roles-permission/{id}', 'update')->name('roles-permission.update');
    });

    // --------------------> others <--------------------
    Route::controller(OthersController::class)->group(function () {
        Route::get('/status-update', 'statusUpdate')->name('status.update');
        Route::get('/get/product-by-supplier/{supplier_id}', 'getProductBySupplier')->name('get.productBySupplier');
        Route::get('/get/product-search', 'productSearch')->name('product-search');
        Route::get('/get/sc-product-search', 'scProductSearch')->name('sc-product-search');
        Route::get('/get/used/product-search', 'usedProductSearch')->name('used-product-search');
        Route::get('/get/search-product-id/{my_id}', 'productSearchDetails')->name('search-product-id');
        Route::get('/get/sc-search-product-id/{my_id}', 'scproductSearchDetails')->name('sc-search-product-id');
        Route::get('/get/used/search-product-id/{my_id}', 'usedProductSearchDetails')->name('used-search-product-id');
        Route::get('/get/product-barcode/{code}', 'productBarcode')->name('product-barcode');
        Route::get('/get/product/unit/{my_id}', 'productUnit')->name('product-unit');
        Route::get('/get/pos-products', 'posProducts')->name('posProducts');
        Route::get('/get/pos/product-id/{my_id}', 'productPosDetails')->name('pos-product-id');
        Route::get('/get/pos/sc-product-id/{my_id}', 'productScPosDetails')->name('sc-pos-product-id');
        Route::get('/get/serial-search', 'serialSearch')->name('serial-search');
        Route::get('/get/search-serial-id/{my_id}', 'serialSearchDetails')->name('search-serial-id');
        //transfer
        Route::get('/get/to/account', 'getToAccount')->name('get-to-account');
        Route::get('get/account/balance', 'getAccountBalance')->name('get-account-balance');

        Route::get('/customer/previous/due', 'findCustomerDue')->name('customer.previous.due');
        // payment
        Route::get('customer/account/balance/{my_id}', 'getCustomerAccountBalance')->name('customer-account-balance');
        Route::get('supplier/account/balance/{my_id}', 'getSupplierAccountBalance')->name('supplier-account-balance');
        // download.backup
        Route::get('/download/backup', 'downloadBackup')->name('status.download.backup');
    });
    Route::controller(UserProfileController::class)->group(function () {
        Route::get('/user/profile', 'index')->name('profile');
        Route::post('/user/profile/update', 'update')->name('profile.update');
        Route::post('/user/profile/change/password', 'changePassword')->name('profile.password');
    });


    // ----------------------- return ---------------------
    Route::controller(ReturnSaleController::class)->group(function () {
        Route::get('return/sale', 'index')->name('return.sale');
        Route::get('return/sale/{id}', 'create')->name('return.create');
        Route::post('return/sale/submit', 'insert')->name('return.insert');
        Route::get('return/sale/delete/{id}', 'delete')->name('return.delete');
    });

    Route::controller(ReturnPurchaseController::class)->group(function () {
        Route::get('return/purchase/delete/{id}', 'destroy')->name('return.purchase.delete');
    });

    Route::resource('rtnPurchase', ReturnPurchaseController::class);
    // ----------------------- damage ---------------------
    Route::controller(DamageController::class)->group(function () {
        Route::get('damage', 'index')->name('damage.index');
        Route::get('damage/create', 'create')->name('damage.create');
        Route::post('damage/create/submit', 'insert')->name('damage.insert');
        Route::post('damage/delete/{id}', 'softDelete')->name('damage.delete');
    });
});
