<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BankOfferController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\SystemSettingsController;
use App\Http\Controllers\Admin\HomestayController;
use App\Http\Controllers\Admin\TrainController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\Admin\MoneyTransferController;
use App\Http\Controllers\Admin\PartnershipSystemController;
use App\Http\Controllers\Admin\AdminWalletController;
use App\Http\Controllers\Admin\AccountingController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {
    
    // 1. Main Dashboard
    Route::get('/admin-dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // 2. Sub-Routes (Admin Prefix)
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () { return redirect('/admin-dashboard'); });

        // Bank Offers
        Route::prefix('bank-offers')->name('bank-offers.')->group(function () {
            Route::get('/', [BankOfferController::class, 'index'])->name('index');
            Route::post('/', [BankOfferController::class, 'store'])->name('store');
            Route::put('/{bankOffer}', [BankOfferController::class, 'update'])->name('update');
            Route::patch('/{bankOffer}/toggle', [BankOfferController::class, 'toggleStatus'])->name('toggle');
            Route::delete('/{bankOffer}', [BankOfferController::class, 'destroy'])->name('destroy');
        });

        Route::get('/partners', function () { return view('admin.partners'); })->name('partners');
        Route::get('/flights', function () { return view('admin.flights'); })->name('flights');
        Route::get('/hotels', function () { return view('admin.hotels'); })->name('hotels');
        Route::get('/tours', function () { return view('admin.tours'); })->name('tours');
        Route::get('/visa', function () { return view('admin.visa'); })->name('visa'); // Added as requested earlier
        
        Route::get('/bookings', [BookingController::class, 'index'])->name('bookings');
        Route::get('/marketing', function () { return view('admin.marketing'); })->name('marketing');

        // System Master Settings
        Route::get('/settings', [SystemSettingsController::class, 'index'])->name('settings.index');
        Route::post('/settings/global', [SystemSettingsController::class, 'updateGlobal'])->name('settings.global.update');
        Route::post('/settings/services', [SystemSettingsController::class, 'updateServices'])->name('settings.services.update');
        Route::post('/settings/markup', [SystemSettingsController::class, 'updateMarkup'])->name('settings.markup.update');
        Route::post('/settings/markup/advanced', [SystemSettingsController::class, 'storeAdvancedMarkup'])->name('settings.markup.advanced.store');
        Route::delete('/settings/markup/advanced/{id}', [SystemSettingsController::class, 'deleteAdvancedMarkup'])->name('settings.markup.advanced.delete');
        Route::post('/settings/api-configs', [SystemSettingsController::class, 'updateApiConfig'])->name('settings.api-configs.update');
        Route::post('/settings/payments', [SystemSettingsController::class, 'updatePayments'])->name('settings.payments.update');
        Route::post('/settings/smtp', [SystemSettingsController::class, 'updateSmtp'])->name('settings.smtp.update');
        Route::post('/settings/markups', [SystemSettingsController::class, 'updateMarkups'])->name('settings.markups.update');
        Route::post('/settings/api-credentials', [SystemSettingsController::class, 'updateApiCredentials'])->name('settings.api-credentials.update');
        Route::post('/settings/swagger/regenerate', [SystemSettingsController::class, 'regenerateSwagger'])->name('settings.swagger.regenerate');

        Route::get('/notifications', function () { return view('admin.notifications'); })->name('notifications');
        Route::get('/broadcasts', function () { return view('admin.broadcasts'); })->name('broadcasts');

        // Inventory Control
        Route::get('/homestays', [HomestayController::class, 'index'])->name('homestays.index');
        Route::get('/trains', [TrainController::class, 'index'])->name('trains.index');
        Route::get('/enquiries', [EnquiryController::class, 'adminIndex'])->name('enquiries.index');

        Route::get('/cms', function () { return view('admin.cms'); })->name('cms');
        Route::get('/profile', function () { return view('admin.profile'); })->name('profile');

        Route::get('/api-dashboard', function () { return view('admin.api-dashboard'); })->name('api.dashboard');
        Route::get('/fare-monitor', function () { return view('admin.fare-monitor'); })->name('api.fare-monitor');

        // User & Partnership Management
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::post('/store', [UserController::class, 'store'])->name('store');
            Route::get('/requests', [UserController::class, 'requests'])->name('requests');
            Route::get('/{id}', [UserController::class, 'show'])->name('show');
            Route::post('/{id}/approve', [UserController::class, 'approve'])->name('approve');
            Route::post('/{id}/reject', [UserController::class, 'reject'])->name('reject');
            Route::get('/{id}/login-as', [UserController::class, 'loginAs'])->name('login-as');
            Route::get('/stop-impersonation', [UserController::class, 'stopImpersonation'])->name('stop-impersonation');
            Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
            Route::put('/{id}', [UserController::class, 'update'])->name('update');
            Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
        });

        // Roles Management
        Route::prefix('roles')->name('roles.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\RoleController::class, 'index'])->name('index');
        });

        // Google API Dashboard
        Route::prefix('google-api')->name('google-api.')->group(function () {
            Route::get('/', function () { return view('admin.google-api.dashboard'); })->name('dashboard');
            Route::get('/flights', function () { return view('admin.google-api.flights'); })->name('flights');
            Route::get('/hotels', function () { return view('admin.google-api.hotels'); })->name('hotels');
        });

        // Audit Logs
        Route::prefix('audit-logs')->name('audit-logs.')->group(function () {
            Route::get('/', [AuditLogController::class, 'index'])->name('index');
            Route::get('/analytics', [AuditLogController::class, 'dashboard'])->name('analytics');
            Route::get('/{id}', [AuditLogController::class, 'show'])->name('show');
        });

        // Money Transfer Management
        Route::prefix('money-transfer')->name('money-transfer.')->group(function () {
            Route::get('/', [MoneyTransferController::class, 'index'])->name('index');
            Route::get('/providers', [MoneyTransferController::class, 'providers'])->name('providers');
            Route::post('/providers/{id}', [MoneyTransferController::class, 'updateProvider'])->name('providers.update');
            Route::post('/{id}/status', [MoneyTransferController::class, 'updateStatus'])->name('status.update');
        });

        // Website Traffic & Partnership System
        Route::prefix('partnership')->name('partnership.')->group(function () {
            Route::get('/dashboard', [PartnershipSystemController::class, 'dashboard'])->name('dashboard');
            Route::get('/websites', [PartnershipSystemController::class, 'index'])->name('index');
            Route::get('/checker', [PartnershipSystemController::class, 'create'])->name('checker');
            Route::post('/fetch', [PartnershipSystemController::class, 'fetchTraffic'])->name('fetch');
            Route::get('/website/{id}', [PartnershipSystemController::class, 'show'])->name('show');
            Route::post('/website/{id}/status', [PartnershipSystemController::class, 'updateStatus'])->name('status.update');
            Route::get('/widget', [PartnershipSystemController::class, 'widget'])->name('widget');
            Route::get('/revenue', [PartnershipSystemController::class, 'revenue'])->name('revenue');
        });

        // Wallet & Finance Master
        Route::prefix('wallet')->name('wallet.')->group(function () {
            Route::get('/', [AdminWalletController::class, 'index'])->name('index');
            Route::post('/update', [AdminWalletController::class, 'updateBalance'])->name('update');
            Route::get('/{id}/transactions', [AdminWalletController::class, 'transactions'])->name('transactions');
        });
        
        // Event Management
        Route::prefix('event-leads')->name('event-leads.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\EventLeadController::class, 'index'])->name('index');
        });
    });
});

// 3. Dedicated Accounting Panel (Admin + Accounting Specialist)
Route::middleware(['auth', 'role:admin,accounting'])->prefix('accounting')->name('accounting.')->group(function () {
    Route::get('/dashboard', [AccountingController::class, 'dashboard'])->name('dashboard');
    Route::get('/', [AccountingController::class, 'dashboard']); // Alias
    Route::get('/ledger', [AccountingController::class, 'ledger'])->name('ledger');
    Route::get('/invoices', [AccountingController::class, 'invoices'])->name('invoices');
    Route::get('/payments', [AccountingController::class, 'payments'])->name('payments');
    Route::get('/expenses', [AccountingController::class, 'expenses'])->name('expenses');
    Route::get('/reports', [AccountingController::class, 'reports'])->name('reports');
    Route::get('/transactions', [AccountingController::class, 'ledger'])->name('transactions');
    Route::get('/gst', [AccountingController::class, 'gst'])->name('gst');
    Route::get('/sync', [AccountingController::class, 'syncView'])->name('sync');
    Route::post('/sync/{platform}', [AccountingController::class, 'syncNow'])->name('sync.now');
});
