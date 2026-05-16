<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IataController;
use App\Http\Controllers\B2bAgentController;
use App\Http\Controllers\CorporateController;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Controllers\AffiliateController;
use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\Dev\SmtpTestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Localization-Aware Routes Group (Frontend Only)
Route::group([
    'prefix' => '{locale}/{currency}',
    'where' => [
        'locale' => '[a-z]{2}', 
        'currency' => '[a-z]{3}'
    ]
], function() {
    // Home & Deals
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/deals', [HomeController::class, 'deals'])->name('deals.index');

    // Flight + Hotel Bundle
    Route::get('/flight-hotel', [App\Http\Controllers\FlightHotelController::class, 'index'])->name('flight-hotel.index');
    Route::get('/flight-hotel/search', [App\Http\Controllers\FlightHotelController::class, 'search'])->name('flight-hotel.search');

    // Flights
    Route::get('/flights', [FlightController::class, 'index'])->name('flights.index');
    Route::get('/flights/fare-classes', [FlightController::class, 'getFareClasses'])->name('flights.fare-classes');
    Route::post('/flights/select-fare', [FlightController::class, 'selectFare'])->name('flights.select-fare');
    Route::post('/flights/search', [FlightController::class, 'search'])->name('flights.search');
    Route::get('/flights/details', [FlightController::class, 'details'])->name('flights.details');
    Route::post('/flights/book', [FlightController::class, 'book'])->name('flights.book');
    Route::get('/flights/map-search', [FlightController::class, 'mapSearch'])->name('flights.map-search');
    Route::get('/flights/airport-search', [FlightController::class, 'airportSearch'])->name('flights.airport-search');

    // Hotels
    Route::get('/hotels', [HotelController::class, 'index'])->name('hotels.index');
    Route::post('/hotels/search', [HotelController::class, 'search'])->name('hotels.search');
    Route::get('/hotels/details', [HotelController::class, 'details'])->name('hotel.details');
    Route::get('/hotels/checkout', [HotelController::class, 'checkout'])->middleware('auth')->name('hotel.checkout');
    Route::post('/hotels/book', [HotelController::class, 'book'])->middleware('auth')->name('hotel.book');

    // Marketplace
    Route::prefix('marketplace')->name('marketplace.')->group(function () {
        Route::get('/', [MarketplaceController::class, 'index'])->name('index');
        Route::get('/provider/{id}', [MarketplaceController::class, 'providerProfile'])->name('provider');
    });

    // Explorer
    Route::prefix('explorer')->name('travel.')->group(function () {
        Route::get('/trends', function () { return view('explorer.trends'); })->name('trends');
        Route::get('/festivals', function () { return view('explorer.festivals'); })->name('festivals');
    });

    Route::get('/explore-map', [App\Http\Controllers\ExploreController::class, 'index'])->name('explore.map');
    Route::get('/homestays', [App\Http\Controllers\HomestayController::class, 'index'])->name('homestays.index');
    Route::get('/homestays/details/{id}', [App\Http\Controllers\HomestayController::class, 'show'])->name('homestays.show');
    Route::get('/cabs', [App\Http\Controllers\CabController::class, 'index'])->name('cabs.index');
    Route::get('/trains', [App\Http\Controllers\TrainController::class, 'index'])->name('trains.index');
    
    Route::prefix('esim')->name('esim.')->group(function () {
        Route::get('/', [App\Http\Controllers\EsimController::class, 'index'])->name('index');
        Route::get('/listings', [App\Http\Controllers\EsimController::class, 'index'])->name('listings');
    });

    Route::prefix('tours')->name('tours.')->group(function () {
        Route::get('/', [App\Http\Controllers\ActivityController::class, 'index'])->name('index');
        Route::get('/listings', function () { return view('tours.listings'); })->name('listings');
        Route::get('/details/{id?}', [App\Http\Controllers\ActivityController::class, 'show'])->name('details');
    });

    Route::prefix('visa')->name('visa.')->group(function () {
        Route::get('/', function () { return view('visa.index'); })->name('index');
        Route::get('/listing', function () { return view('visa.listing'); })->name('listing');
        Route::get('/detail/{country}', function ($country) { return view('visa.detail', ['country' => $country]); })->name('detail');
    });

    Route::get('/event', [App\Http\Controllers\EventLandingController::class, 'showMelbourneEvent'])->name('event');
    Route::get('/coming-soon', function () { return view('coming-soon'); })->name('coming-soon');
    Route::post('/event/submit', [App\Http\Controllers\EventLandingController::class, 'storeLead'])->name('event.submit');

    // Flights & Hotels Checkout / Actions
    Route::post('/flights/group-booking', [App\Http\Controllers\GroupBookingController::class, 'store'])->name('flights.group-booking');
    Route::post('/hotels/coupon/apply', [App\Http\Controllers\HotelController::class, 'applyCoupon'])->middleware('auth')->name('hotel.coupon.apply');
    Route::get('/hotels/payment', [App\Http\Controllers\HotelController::class, 'showPaymentGateway'])->middleware('auth')->name('hotel.payment');
    Route::get('/hotels/payment/mpgs', [App\Http\Controllers\HotelController::class, 'showMpgsCheckout'])->middleware('auth')->name('hotel.payment.mpgs');
    Route::get('/hotels/payment/process', [App\Http\Controllers\HotelController::class, 'processPayment'])->middleware('auth')->name('hotel.payment.process');
    Route::get('/hotels/confirmation', [App\Http\Controllers\HotelController::class, 'showConfirmation'])->middleware('auth')->name('hotel.confirmation');
    Route::get('/hotel-map', function () { return view('hotel-map'); })->name('hotels.map');

    Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout/init-split', [App\Http\Controllers\CheckoutController::class, 'initSplit'])->name('checkout.init-split');
    Route::post('/checkout/save-travelers', [App\Http\Controllers\CheckoutController::class, 'saveTravelers'])->name('checkout.save-travelers');
    Route::post('/checkout/process', [App\Http\Controllers\CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success', [App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/mpgs', [App\Http\Controllers\CheckoutController::class, 'showMpgsCheckout'])->name('checkout.mpgs');
    Route::post('/booking/initiate-payment', [App\Http\Controllers\CheckoutController::class, 'initiatePayment'])->name('booking.initiate-payment');

    Route::get('/seat-selection', [App\Http\Controllers\SeatSelectionController::class, 'index'])->name('seat.selection');
    Route::get('/add-ons', [App\Http\Controllers\SeatSelectionController::class, 'customize'])->name('add.ons');
    Route::get('/booking-confirmation', [App\Http\Controllers\BookingFinalizeController::class, 'show'])->name('booking.confirmation');
    Route::get('/booking-confirmation/pdf', [App\Http\Controllers\BookingFinalizeController::class, 'downloadPdf'])->name('booking.pdf');
    Route::get('/booking-confirmation/whatsapp', [App\Http\Controllers\BookingFinalizeController::class, 'sendWhatsappTicket'])->name('booking.whatsapp');

    Route::get('/payment', function () { return view('payment'); })->name('payment');
});


// ====== NON-LOCALIZED ROUTES (Admin, Auth, Dashboards) ======

// Root Redirect to Default Locale/Currency for Frontend
Route::get('/', function() {
    return redirect('/en/aud');
});

// Auth Routes (Login, Register, etc.)
Route::get('/login', [AuthController::class, 'showUserLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/login-unified', [AuthController::class, 'loginUnified'])->name('login.unified');
Route::post('/login/send-otp', [AuthController::class, 'loginSendOtp']);
Route::post('/login/verify-otp', [AuthController::class, 'loginVerifyOtp']);
Route::post('/password/forgot-otp', [AuthController::class, 'forgotPasswordOtp']);
Route::post('/password/reset-otp', [AuthController::class, 'resetPasswordOtp']);
Route::get('/register', [AuthController::class, 'showUserRegister'])->name('register');
Route::post('/register', [AuthController::class, 'registerUser'])->name('register.submit');

// Separate Login Pages per Role
Route::get('/admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
Route::get('/partner/login', [AuthController::class, 'showPartnerLogin'])->name('partner.login'); // Amadeus GDS
Route::get('/iata/login', [AuthController::class, 'showIataLogin'])->name('iata.login');
Route::get('/corporate/login', [AuthController::class, 'showCorporateLogin'])->name('corporate.login');
Route::get('/agent/login', [AuthController::class, 'showAgentLogin'])->name('agent.login');
Route::get('/supplier/login', [AuthController::class, 'showSupplierLogin'])->name('supplier.login');
Route::get('/cargo/login', [AuthController::class, 'showCargoLogin'])->name('cargo.login');

// Unified Submission Handlers
Route::post('/admin/login', [AuthController::class, 'loginAdmin'])->name('admin.login.submit');
Route::post('/partner/login', [AuthController::class, 'handlePartnerLogin'])->name('partner.login.submit');
Route::post('/iata/login', [AuthController::class, 'handlePartnerLogin'])->name('iata.login.submit');
Route::post('/corporate/login', [AuthController::class, 'handlePartnerLogin'])->name('corporate.login.submit');
Route::post('/agent/login', [AuthController::class, 'handlePartnerLogin'])->name('agent.login.submit');
Route::post('/supplier/login', [AuthController::class, 'handlePartnerLogin'])->name('supplier.login.submit');
Route::post('/cargo/login', [AuthController::class, 'handlePartnerLogin'])->name('cargo.login.submit');

// Unified Partner Signup (Corporate, B2B, Supplier)
Route::get('/partner/signup', [AuthController::class, 'showPartnerSignup'])->name('partner.signup');
Route::post('/partner/register', [AuthController::class, 'handlePartnerRegistration'])->name('partner.register');

// Common Auth Actions
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout', [AuthController::class, 'logout']);
Route::get('/verify-otp', function() { return view('auth.verify-otp'); })->name('verify.otp');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('verify.otp.post');

// Admin Dashboard & Management
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/localization', function() { return view('admin.localization'); })->name('localization');
    
    // Admin Cargo Management
    Route::prefix('cargo')->name('cargo.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\CargoController::class, 'index'])->name('index');
        Route::get('/providers', [App\Http\Controllers\Admin\CargoController::class, 'providers'])->name('providers');
        Route::get('/bookings', [App\Http\Controllers\Admin\CargoController::class, 'bookings'])->name('bookings');
        Route::get('/promo-codes', [App\Http\Controllers\Admin\CargoController::class, 'promo-codes'])->name('promo-codes');
        Route::get('/rates', [App\Http\Controllers\Admin\CargoController::class, 'rates'])->name('rates');
        Route::post('/rates', [App\Http\Controllers\Admin\CargoController::class, 'storeRate'])->name('rates.store');
        Route::post('/update-status', [App\Http\Controllers\Admin\CargoController::class, 'updateStatus'])->name('update.status');
    });

    Route::get('/event-leads', [App\Http\Controllers\Admin\EventLeadController::class, 'index'])->name('event-leads.index');
    Route::delete('/event-leads/{id}', [App\Http\Controllers\Admin\EventLeadController::class, 'destroy'])->name('event-leads.destroy');
});

// Utility Routes
Route::post('/localization/set', [\App\Http\Controllers\LocalizationController::class, 'setLocalization'])->name('localization.set');
Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Cache cleared!";
});

// DEV TOOLS
Route::prefix('dev')->name('dev.')->group(function () {
    Route::get('/smtp-test',       [SmtpTestController::class, 'show'])->name('smtp.test');
    Route::post('/smtp-test/send', [SmtpTestController::class, 'send'])->name('smtp.send');
});

// Other Non-Localized routes


// Cargo System
Route::prefix('user-cargo')->name('cargo.dashboard.')->middleware(['auth', 'role:cargo,admin'])->group(function () {
    Route::get('/', [App\Http\Controllers\User\CargoDashboardController::class, 'index'])->name('index');
    Route::get('/book', [App\Http\Controllers\User\CargoDashboardController::class, 'create'])->name('book');
    Route::post('/search-providers', [App\Http\Controllers\User\CargoDashboardController::class, 'searchProviders'])->name('search.providers');
    Route::post('/book', [App\Http\Controllers\User\CargoDashboardController::class, 'store'])->name('store');
    Route::get('/tracking/{ref}', [App\Http\Controllers\User\CargoDashboardController::class, 'tracking'])->name('tracking');
    Route::get('/letter/{ref}', [App\Http\Controllers\User\CargoDashboardController::class, 'downloadLetter'])->name('letter.download');
    Route::get('/label/{ref}', [App\Http\Controllers\User\CargoDashboardController::class, 'shippingLabel'])->name('label.shipping');
    Route::get('/ticket/{ref}', [App\Http\Controllers\User\CargoDashboardController::class, 'tracking'])->name('ticket'); // Alias
});

Route::prefix('cargo-agent')->name('cargo.agent.')->middleware(['auth', 'role:cargo,admin'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\User\CargoAgentController::class, 'dashboard'])->name('dashboard');
    Route::get('/earnings', [App\Http\Controllers\User\CargoAgentController::class, 'earnings'])->name('earnings');
    Route::get('/history', [App\Http\Controllers\User\CargoAgentController::class, 'history'])->name('history');
    Route::post('/accept', [App\Http\Controllers\User\CargoAgentController::class, 'acceptPickup'])->name('accept');
    Route::post('/update-location', [App\Http\Controllers\User\CargoAgentController::class, 'updateLocation'])->name('location');
    Route::prefix('developer-portal')->name('api.')->group(function() {
        Route::get('/', [App\Http\Controllers\User\CargoApiController::class, 'index'])->name('index');
        Route::post('/request', [App\Http\Controllers\User\CargoApiController::class, 'requestAccess'])->name('request');
        Route::post('/generate', [App\Http\Controllers\User\CargoApiController::class, 'generateKeys'])->name('generate');
    });
});

Route::prefix('cargo-hub')->name('cargo.support.')->middleware(['auth', 'role:cargo,admin'])->group(function () {
    Route::get('/warehouse', [App\Http\Controllers\User\CargoSupportController::class, 'warehouseDashboard'])->name('warehouse');
    Route::get('/customs', [App\Http\Controllers\User\CargoSupportController::class, 'customsDashboard'])->name('customs');
    Route::post('/process', [App\Http\Controllers\User\CargoSupportController::class, 'processStatus'])->name('status');
});

Route::get('/cargo', [App\Http\Controllers\CargoController::class, 'landing'])->name('cargo.landing');
Route::get('/cargo/track', [App\Http\Controllers\CargoController::class, 'trackView'])->name('cargo.track');
Route::get('/cargo/verify/{tracking_id}', [App\Http\Controllers\User\CargoDashboardController::class, 'verifyShipment'])->name('cargo.verify.public');
Route::post('/cargo/estimate', [App\Http\Controllers\CargoController::class, 'calculate']);



Route::post('/webhooks/stripe', [StripeWebhookController::class, 'handle'])->name('webhook.stripe');
Route::prefix('test-payments')->group(function() {
    Route::get('/mpgs', [\App\Http\Controllers\PaymentController::class, 'testMpgs'])->name('test.mpgs');
    Route::get('/stripe', [\App\Http\Controllers\PaymentController::class, 'testStripe'])->name('test.stripe');
    Route::get('/mpgs/callback', [\App\Http\Controllers\PaymentController::class, 'mpgsCallback'])->name('mpgs.callback');
    Route::get('/mpgs/cancel', [\App\Http\Controllers\PaymentController::class, 'mpgsCancel'])->name('mpgs.cancel');
    Route::get('/success', [\App\Http\Controllers\PaymentController::class, 'success'])->name('payment.success');
    Route::get('/cancel', [\App\Http\Controllers\PaymentController::class, 'cancel'])->name('payment.cancel');
});



Route::get('/enhance-trip', function () { return view('enhance-trip'); })->name('enhance.trip');
Route::get('/booking-details', function () { return view('booking-details'); })->name('booking.details');
Route::get('/booking-insurance', [App\Http\Controllers\InsuranceController::class, 'index'])->name('booking.insurance');
Route::post('/booking-insurance', [App\Http\Controllers\InsuranceController::class, 'book'])->name('booking.insurance.post');
Route::get('/hotel-quote/{id?}', function () { return view('hotel-quote-form'); })->name('hotel.quote.form');
Route::post('/enquiry/store', [App\Http\Controllers\EnquiryController::class, 'store'])->name('enquiry.store');
Route::get('/agent/hotel-requests', function () { return view('agent-hotel-requests'); })->name('agent.hotel.requests');
Route::get('/hotel/dashboard-requests', function () { return view('hotel-dashboard-requests'); })->name('hotel.dashboard.requests');
Route::get('/hotel/quote-response/{id?}', function () { return view('hotel-quote-response'); })->name('hotel.quote.response');
Route::get('/agent/hotel-bookings', function () { return view('agent-hotel-bookings'); })->name('agent.hotel.bookings');

Route::prefix('dashboard')->name('dashboard.')->middleware(['auth', 'role:user,admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [DashboardController::class, 'updateProfile'])->name('profile.update');
    Route::get('/track/{ref}', [\App\Http\Controllers\User\CargoDashboardController::class, 'tracking'])->name('dashboard.tracking');
    Route::get('/verify/{tracking_id}', [\App\Http\Controllers\User\CargoDashboardController::class, 'verifyShipment'])->name('dashboard.verify');
    Route::get('/bookings', [DashboardController::class, 'bookings'])->name('bookings');
    Route::get('/wishlist', [DashboardController::class, 'wishlist'])->name('wishlist');
    Route::get('/searches', [DashboardController::class, 'searches'])->name('searches');
    Route::get('/notifications', [DashboardController::class, 'notifications'])->name('notifications');
    Route::get('/price-alerts', [DashboardController::class, 'priceAlerts'])->name('price-alerts');
    Route::post('/price-alerts', [DashboardController::class, 'storePriceAlert'])->name('price-alerts.store');
    Route::get('/settings', [DashboardController::class, 'settings'])->name('settings');
    Route::post('/settings/password', [DashboardController::class, 'updatePassword'])->name('settings.password');
    Route::post('/settings/preferences', [DashboardController::class, 'updateSettings'])->name('settings.preferences');
    Route::delete('/settings/deactivate', [DashboardController::class, 'deactivateAccount'])->name('settings.deactivate');
    Route::get('/wallet', [DashboardController::class, 'wallet'])->name('wallet');
});

Route::get('/agent-dashboard', [B2bAgentController::class, 'dashboard'])->middleware(['auth', 'role:agent,b2b,admin'])->name('agent.dashboard');
Route::prefix('iata-dashboard')->name('iata.')->middleware(['auth', 'role:iata,admin'])->group(function () {
    Route::get('/', function () { return view('agent.dashboard'); })->name('dashboard');
    Route::prefix('flight')->name('flight.')->group(function () {
        Route::get('/search', [FlightController::class, 'index'])->name('search');
        Route::get('/availability', [FlightController::class, 'index'])->name('availability');
        Route::get('/create-pnr', function () { return view('iata.create-pnr'); })->name('create-pnr');
        Route::get('/issue-ticket', function () { return view('iata.issue-ticket'); })->name('issue-ticket');
        Route::get('/pnr-list', function () { return view('iata.pnr-list'); })->name('pnr-list');
    });
    Route::prefix('tickets')->name('tickets.')->group(function () {
        Route::get('/all', function () { return view('iata.all-tickets'); })->name('all');
        Route::get('/details', function () { return view('iata.ticket-details'); })->name('details');
        Route::get('/void', function () { return view('iata.void-ticket'); })->name('void');
    });
    Route::prefix('bsp')->name('bsp.')->group(function () {
        Route::get('/sales', function () { return view('iata.bsp-sales'); })->name('sales');
        Route::get('/ledger', function () { return view('iata.bsp-ledger'); })->name('ledger');
    });
    Route::get('/accounting', function () { return view('iata.accounting'); })->name('accounting');
    Route::get('/reports', function () { return view('iata.reports'); })->name('reports');
    Route::prefix('network')->name('network.')->group(function () {
        Route::get('/search', function () { return view('iata.network.search'); })->name('search');
        Route::get('/requests', function () { return view('iata.network.requests'); })->name('requests');
        Route::get('/partners', function () { return view('iata.network.partners'); })->name('partners');
        Route::get('/profits', function () { return view('iata.network.profits'); })->name('profits');
        Route::get('/issue-partner/{pnr}', function ($pnr) { return view('iata.network.issue-partner', ['pnr' => $pnr]); })->name('issue-partner');
    });
    Route::get('/network-old', function () { return view('iata.network'); })->name('network-old');
    Route::get('/connections', function () { return view('iata.connections'); })->name('connections');
    Route::get('/settings', function () { return view('iata.settings'); })->name('settings');
});

Route::middleware(['auth', 'role:corporate,admin'])->group(function() {
    Route::get('/corporate-dashboard', function () { return view('corporate.dashboard'); })->name('corporate.dashboard');
    Route::get('/corporate-dashboard/groups', function () { return view('corporate.groups'); })->name('corporate.groups');
    Route::get('/corporate-dashboard/employees', function () { return view('corporate.employees'); })->name('corporate.employees');
    Route::get('/corporate-dashboard/audit', function () { return view('corporate.audit'); })->name('corporate.audit');
    Route::get('/corporate-dashboard/policies', function () { return view('corporate.policies'); })->name('corporate.policies');
    Route::get('/corporate-dashboard/approvals', function () { return view('corporate.approvals'); })->name('corporate.approvals');
    Route::get('/corporate-dashboard/settings', function () { return view('corporate.settings'); })->name('corporate.settings');
});

Route::prefix('tourbuilder-dashboard')->middleware(['auth', 'role:tour-builder,supplier,admin'])->group(function () {
    Route::get('/', function () { return view('partner.manage-tours'); })->name('tourbuilder.dashboard');
    Route::get('/packages', function () { return view('partner.tourbuilder-packages'); })->name('tourbuilder.packages');
    Route::get('/bookings', function () { return view('partner.tourbuilder-bookings'); })->name('tourbuilder.bookings');
    Route::get('/reviews', function () { return view('partner.tourbuilder-reviews'); })->name('tourbuilder.reviews');
    Route::get('/earnings', function () { return view('partner.tourbuilder-earnings'); })->name('tourbuilder.earnings');
});

Route::prefix('amadeus-dashboard')->name('amadeus.')->middleware(['auth', 'role:amadeus-partner,admin'])->group(function () {
    Route::get('/', function () { return view('amadeus.dashboard'); })->name('dashboard');
    Route::get('/booking', function () { return view('amadeus.booking'); })->name('booking');
    Route::get('/issue-ticket', function () { return view('amadeus.issue_ticket'); })->name('issue-ticket');
    Route::get('/requests', function () { return view('amadeus.requests'); })->name('requests');
    Route::get('/group-request', function () { return view('amadeus.group_request'); })->name('group-request');
    Route::get('/manage-requests', function () { return view('amadeus.manage_requests'); })->name('manage-requests');
    Route::get('/gds', function () { return view('amadeus.gds_command'); })->name('gds');
    Route::get('/gds/monitoring', function () { return view('amadeus.gds_monitoring'); })->name('gds-monitoring');
    Route::get('/queues/pending', function () { return view('amadeus.queues_pending'); })->name('queues-pending');
    Route::get('/queues/cancellations', function () { return view('amadeus.queues_cancellations'); })->name('queues-cancellations');
    Route::get('/queues/reissue', function () { return view('amadeus.queues_reissue'); })->name('queues-reissue');
    Route::get('/wallet', function () { return view('amadeus.wallet'); })->name('wallet');
    Route::get('/wallet/add-balance', function () { return view('amadeus.wallet_add'); })->name('wallet-add');
    Route::get('/wallet/credit', function () { return view('amadeus.credit_limit'); })->name('wallet-credit');
    Route::get('/markup', function () { return view('amadeus.markup'); })->name('markup');
    Route::get('/commissions-fees', function () { return view('amadeus.commissions'); })->name('commissions');
    Route::get('/news-promos', function () { return view('amadeus.news_promos'); })->name('news');
    Route::get('/settings/spm', function () { return view('amadeus.settings_spm'); })->name('settings-spm');
    Route::get('/settings/email-sms', function () { return view('amadeus.settings_email'); })->name('settings-email');
    Route::get('/settings/staff', function () { return view('amadeus.settings_staff'); })->name('settings-staff');
    Route::get('/agents', function () { return view('amadeus.agents'); })->name('agents');
    Route::get('/reports', function () { return view('amadeus.reports'); })->name('reports');
    Route::get('/reports/profit', function () { return view('amadeus.reports_profit'); })->name('reports-profit');
    Route::get('/reports/performance', function () { return view('amadeus.reports_performance'); })->name('reports-performance');
    Route::get('/settings', function () { return view('amadeus.settings'); })->name('settings');
});

Route::prefix('hotel-dashboard')->name('hotel_dashboard.')->middleware(['auth', 'role:hotel-partner,admin'])->group(function () {
    Route::get('/', function () { return view('hotel.dashboard'); })->name('dashboard');
    Route::get('/search', function () { return view('hotel.search'); })->name('search');
    Route::get('/results', [HotelController::class, 'index'])->name('results');
    Route::get('/details', [HotelController::class, 'details'])->name('details');
    Route::get('/booking', function () { return view('hotel.booking'); })->name('booking');
    Route::get('/confirm', function () { return view('hotel.confirm'); })->name('confirm');
    Route::prefix('management')->name('management.')->group(function () {
        Route::get('/all', function () { return view('hotel.bookings_all'); })->name('all');
        Route::get('/pending', function () { return view('hotel.bookings_pending'); })->name('pending');
        Route::get('/confirmed', function () { return view('hotel.bookings_confirmed'); })->name('confirmed');
        Route::get('/cancelled', function () { return view('hotel.bookings_cancelled'); })->name('cancelled');
    });
    Route::get('/cancellation', function () { return view('hotel.cancellation'); })->name('cancellation');
    Route::get('/refund-status', function () { return view('hotel.refund_status'); })->name('refund-status');
    Route::get('/refund-history', function () { return view('hotel.refund_history'); })->name('refund-history');
    Route::get('/wallet', function () { return view('hotel.wallet'); })->name('wallet');
    Route::get('/earnings', function () { return view('hotel.earnings'); })->name('earnings');
    Route::get('/reports', function () { return view('hotel.reports'); })->name('reports');
    Route::get('/settings', function () { return view('hotel.settings'); })->name('settings');
    Route::get('/assets', function () { return view('hotel.property_assets'); })->name('assets');
    Route::get('/inventory', function () { return view('hotel.inventory'); })->name('inventory');
    Route::get('/guests', function () { return view('hotel.guest_relations'); })->name('guests');
    Route::get('/promotions', function () { return view('hotel.promotions'); })->name('promotions');
    Route::get('/guides', function () { return view('hotel.guides'); })->name('guides');
    Route::get('/customer-preview', function () { return view('hotel.customer_preview'); })->name('customer-preview');
    Route::get('/portal-settings', function () { return view('hotel.portal_settings'); })->name('portal-settings');
    Route::get('/webhook-logs', function () { return view('hotel.webhook_logs'); })->name('webhook-logs');
    Route::get('/flights', function () { return view('hotel.flight_engine'); })->name('flight-engine');
    Route::get('/external-hotels', function () { return view('hotel.external_hotels'); })->name('external-hotels');
    Route::get('/activities', function () { return view('hotel.activities'); })->name('activities');
    Route::get('/transfers', function () { return view('hotel.transfers'); })->name('transfers');
    Route::get('/cars', function () { return view('hotel.cars'); })->name('cars');
    Route::get('/my-properties', function () { return view('hotel.my_properties'); })->name('my-properties');
    Route::get('/add-property', function () { return view('hotel.add_property'); })->name('add-property');
    Route::get('/channel-manager', function () { return view('hotel.channel_manager'); })->name('channel-manager');
    Route::get('/ota-mapping', function () { return view('hotel.ota_mapping'); })->name('ota-mapping');
    Route::get('/sync-status', function () { return view('hotel.sync_status'); })->name('sync-status');
    Route::get('/automation-rules', function () { return view('hotel.automation_rules'); })->name('automation-rules');
    Route::get('/notification-templates', function () { return view('hotel.notification_templates'); })->name('notification-templates');
    Route::get('/quotations', function () { return view('hotel.quotations_sent'); })->name('quotations');
    Route::get('/deals', function () { return view('hotel.deals_finalized'); })->name('deals');
    Route::get('/pipeline', function () { return view('hotel.pipeline'); })->name('pipeline');
    Route::get('/voucher', function () { return view('hotel.voucher_view'); })->name('voucher');
    Route::get('/tours', function () { return view('hotel.tours'); })->name('tours');
});

Route::prefix('partner')->name('partner.')->middleware(['auth', 'role:partner,admin'])->group(function () {
    Route::get('/dashboard', function () { return view('partner.dashboard'); })->name('dashboard');
    Route::get('/flights', function () { return view('partner.manage-flights'); })->name('flights');
    Route::get('/hotels', function () { return view('partner.manage-hotels'); })->name('hotels');
    Route::get('/homestays', [App\Http\Controllers\Supplier\HomestayController::class, 'index'])->name('homestays');
    Route::post('/homestays', [App\Http\Controllers\Supplier\HomestayController::class, 'store'])->name('homestays.store');
    Route::get('/tours', [App\Http\Controllers\Supplier\TourController::class, 'index'])->name('tours');
    Route::post('/tours', [App\Http\Controllers\Supplier\TourController::class, 'store'])->name('tours.store');
    Route::get('/cabs', function () { return view('partner.manage-cabs'); })->name('cabs');
    Route::get('/trains', function () { return view('partner.manage-trains'); })->name('trains');
    Route::get('/events', function () { return view('partner.manage-events'); })->name('events');
    Route::get('/event-seating', function () { return view('partner.event-seating'); })->name('event-seating');
    Route::get('/bookings', function () { return view('partner.bookings'); })->name('bookings');
    Route::get('/profile', function () { return view('partner.profile'); })->name('profile');
});



Route::prefix('corporate')->name('corporate.')->group(function () {
    Route::get('/login', function () { return view('corporate.login'); })->name('login');
    Route::get('/dashboard', function () { return view('corporate.dashboard'); })->name('dashboard');
    Route::get('/group-booking', function () { return view('corporate.group-booking'); })->name('group-booking');
    Route::get('/group-detail/{id}', function ($id) { return view('corporate.group-detail', ['id' => $id]); })->name('group-detail');
});

Route::prefix('investor')->name('investor.')->middleware(['auth', 'role:investor,admin'])->group(function () {
    Route::get('/login', function () { return view('investor.login'); })->name('login');
    Route::get('/dashboard', function () { return view('investor.dashboard'); })->name('dashboard');
    Route::get('/wallet', function () { return view('investor.wallet'); })->name('wallet');
    Route::get('/earnings', function () { return view('investor.earnings'); })->name('earnings');
    Route::get('/segments', function () { return view('investor.segments'); })->name('segments');
    Route::get('/transactions', function () { return view('investor.transactions'); })->name('transactions');
});

Route::prefix('agent')->name('agent.')->middleware(['auth', 'role:iata-network,admin'])->group(function () {
    Route::get('/login', function () { return view('agent.login'); })->name('login')->withoutMiddleware('auth');
    Route::get('/dashboard', [App\Http\Controllers\IataController::class, 'index'])->name('dashboard');
    Route::get('/network', function () { return view('agent.network'); })->name('network');
    Route::get('/connections', function () { return view('agent.connections'); })->name('connections');
    Route::get('/ticketing', function () { return view('agent.ticketing'); })->name('ticketing');
    Route::get('/profit-sharing', function () { return view('agent.profit-sharing'); })->name('profit-sharing');
    Route::get('/profile/{id}', function ($id) { return view('agent.profile', ['id' => $id]); })->name('profile');
    Route::get('/chat/{id}', function ($id) { return view('agent.chat', ['id' => $id]); })->name('chat');
    Route::get('/deals', function () { return view('agent.deals'); })->name('deals');
    Route::get('/transactions', function () { return view('agent.transactions'); })->name('transactions');
});

Route::prefix('agent-dashboard')->name('agent.b2b.')->middleware('auth')->group(function () {
    Route::get('/', [B2bAgentController::class, 'dashboard'])->name('index');
    Route::prefix('flight')->group(function () {
        Route::get('/search', [B2bAgentController::class, 'searchPage'])->name('search');
        Route::get('/listing', [B2bAgentController::class, 'flightListing'])->name('listing');
        Route::get('/passenger-details', [B2bAgentController::class, 'paxDetails'])->name('pax-details');
        Route::get('/review', [B2bAgentController::class, 'reviewPage'])->name('review');
        Route::post('/issue-ticket', [B2bAgentController::class, 'issueTicket'])->name('issue-ticket');
        Route::get('/success/{id}', [B2bAgentController::class, 'bookingSuccess'])->name('success');
        Route::get('/my-bookings', [B2bAgentController::class, 'myBookings'])->name('bookings');
    });
    Route::prefix('wallet')->group(function () {
        Route::get('/add-money', [B2bAgentController::class, 'addMoney'])->name('wallet.add');
        Route::post('/topup', [B2bAgentController::class, 'topUp'])->name('wallet.topup');
        Route::get('/history', [B2bAgentController::class, 'walletHistory'])->name('wallet.history');
        Route::get('/credit-request', [B2bAgentController::class, 'creditRequest'])->name('wallet.credit-request');
    });
    Route::prefix('reports')->group(function () {
        Route::get('/bookings', [B2bAgentController::class, 'reportBookings'])->name('reports.bookings');
        Route::get('/transactions', [B2bAgentController::class, 'reportTransactions'])->name('reports.transactions');
        Route::get('/profit-margin', [B2bAgentController::class, 'reportProfit'])->name('reports.profit');
    });
    Route::get('/passengers', [B2bAgentController::class, 'paxList'])->name('manage.passengers');
    Route::get('/markup-settings', [B2bAgentController::class, 'markupSettings'])->name('manage.markups');
    Route::get('/support/tickets', [B2bAgentController::class, 'supportTickets'])->name('support.tickets');
    Route::get('/support/help-center', [B2bAgentController::class, 'helpCenter'])->name('support.help');
    Route::get('/account/profile', [B2bAgentController::class, 'profile'])->name('account.profile');
    Route::get('/account/password', [B2bAgentController::class, 'changePassword'])->name('account.password');
    Route::get('/fare-alerts', [B2bAgentController::class, 'fareAlerts'])->name('fare-alerts');
    Route::get('/fare-alerts/create', [B2bAgentController::class, 'createFareAlert'])->name('fare-alerts.create');
    Route::post('/fare-alerts/store', [B2bAgentController::class, 'storeFareAlert'])->name('fare-alerts.store');
    Route::delete('/fare-alerts/{id}', [B2bAgentController::class, 'deleteFareAlert'])->name('fare-alerts.delete');
});

Route::get('/corporate-dashboard', function() { return redirect()->route('corporate.index'); });
Route::prefix('corporate')->name('corporate.')->middleware(['auth'])->group(function () {
    Route::get('/', [CorporateController::class, 'dashboard'])->name('index');
    Route::prefix('booking')->group(function () {
        Route::get('/search', [CorporateController::class, 'searchPage'])->name('search');
        Route::get('/listing', [CorporateController::class, 'flightListing'])->name('listing');
        Route::get('/passenger-details', [CorporateController::class, 'paxDetails'])->name('pax-details');
        Route::get('/review', [CorporateController::class, 'reviewPage'])->name('review');
        Route::post('/submit-request', [CorporateController::class, 'submitRequest'])->name('submit-request');
        Route::get('/request-status/{id}', [CorporateController::class, 'requestStatus'])->name('status');
        Route::get('/my-trips', [CorporateController::class, 'myTrips'])->name('my-trips');
    });
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/approvals', [CorporateController::class, 'pendingApprovals'])->name('approvals');
        Route::post('/approve/{id}', [CorporateController::class, 'processApproval'])->name('approve');
        Route::post('/reject/{id}', [CorporateController::class, 'processRejection'])->name('reject');
        Route::get('/all-bookings', [CorporateController::class, 'allBookings'])->name('all-bookings');
    });
    Route::prefix('employees')->group(function () {
        Route::get('/', [CorporateController::class, 'manageEmployees'])->name('employees.index');
        Route::get('/add', [CorporateController::class, 'addEmployeePage'])->name('employees.add');
        Route::post('/store', [CorporateController::class, 'storeEmployee'])->name('employees.store');
    });
    Route::prefix('policies')->group(function () {
        Route::get('/', [CorporateController::class, 'policySettings'])->name('policies');
        Route::get('/budget-limits', [CorporateController::class, 'budgetLimits'])->name('budget');
    });
    Route::prefix('billing')->group(function () {
        Route::get('/invoices', [CorporateController::class, 'invoices'])->name('billing.invoices');
        Route::get('/payments', [CorporateController::class, 'payments'])->name('billing.payments');
    });
    Route::prefix('reports')->group(function () {
        Route::get('/expense-reports', [CorporateController::class, 'expenseReports'])->name('reports.expense');
        Route::get('/booking-reports', [CorporateController::class, 'bookingReports'])->name('reports.bookings');
    });
    Route::get('/support', [CorporateController::class, 'supportHub'])->name('support');
    Route::get('/account', [CorporateController::class, 'accountSettings'])->name('account');
});

Route::get('/money-transfer', [App\Http\Controllers\MoneyTransferController::class, 'index'])->name('money-transfer.index');
Route::get('/money-transfer/comparison', [App\Http\Controllers\MoneyTransferController::class, 'comparison'])->name('money-transfer.comparison');
Route::get('/money-transfer/form/{provider}', [App\Http\Controllers\MoneyTransferController::class, 'showTransferForm'])->name('money-transfer.form');

Route::prefix('local-provider')->name('provider.')->middleware(['auth', 'role:local-provider,admin'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\LocalServiceProviderController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [App\Http\Controllers\LocalServiceProviderController::class, 'profile'])->name('profile');
    Route::get('/services', [App\Http\Controllers\LocalServiceProviderController::class, 'services'])->name('services');
    Route::get('/hotels', [App\Http\Controllers\LocalServiceProviderController::class, 'hotels'])->name('hotels');
    Route::get('/tour-builders', [App\Http\Controllers\LocalServiceProviderController::class, 'tourBuilders'])->name('tour-builders');
    Route::get('/requests', [App\Http\Controllers\LocalServiceProviderController::class, 'requests'])->name('requests');
    Route::get('/bookings', [App\Http\Controllers\LocalServiceProviderController::class, 'bookings'])->name('bookings');
    Route::get('/earnings', [App\Http\Controllers\LocalServiceProviderController::class, 'earnings'])->name('earnings');
    Route::get('/reviews', [App\Http\Controllers\LocalServiceProviderController::class, 'reviews'])->name('reviews');
    Route::get('/search-providers', [App\Http\Controllers\LocalServiceProviderController::class, 'searchProviders'])->name('search-providers');
});



// ==========================================
// AFFILIATE & MARKETPLACE SYSTEM (Final Flow)
// ==========================================

// Marketplace (Service Listings)
Route::prefix('marketplace')->name('marketplace.')->group(function () {
    Route::get('/', [MarketplaceController::class, 'index'])->name('index');
    Route::get('/provider/{id}', [MarketplaceController::class, 'providerProfile'])->name('provider');
    Route::post('/book/{id}', [MarketplaceController::class, 'bookService'])->name('book');
});

// Affiliate Registration
Route::get('/affiliate/register', [AffiliateController::class, 'showRegistration'])->name('affiliate.register');
Route::post('/affiliate/register', [AffiliateController::class, 'handleRegistration'])->name('affiliate.register.submit');

// Provider / Affiliate Panel
Route::prefix('affiliate-dashboard')->name('affiliate.dashboard.')->middleware(['auth', 'role:affiliate'])->group(function () {
    Route::get('/', [AffiliateController::class, 'dashboard'])->name('index');
});

// Admin Affiliate Management
Route::prefix('admin/affiliates')->name('admin.affiliates.')->middleware(['auth', 'role:admin,super-admin'])->group(function () {
    Route::get('/', [AffiliateController::class, 'adminIndex'])->name('index');
    Route::post('/{id}/approve', [AffiliateController::class, 'adminApprove'])->name('approve');
    Route::get('/withdrawals', [AffiliateController::class, 'adminWithdrawals'])->name('withdrawals');
    Route::post('/withdrawals/{id}/pay', [AffiliateController::class, 'adminMarkPaid'])->name('pay');
});

// ==========================================
// DEV TOOLS (local/development only)
// ==========================================

Route::prefix('dev')->name('dev.')->group(function () {
    Route::get('/smtp-test',       [SmtpTestController::class, 'show'])->name('smtp.test');
    Route::post('/smtp-test/send', [SmtpTestController::class, 'send'])->name('smtp.send');
});
