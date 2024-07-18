<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', [\App\Http\Controllers\FrontController::class, 'index'])->name('/');
Route::get('/contact-us', [\App\Http\Controllers\FrontController::class, 'contact_us'])->name('frontend.contact_us');
Route::post('/contact-us', [\App\Http\Controllers\FrontController::class, 'contactUs'])->name('contactUs');

Route::get('/privacy-policy', [\App\Http\Controllers\FrontController::class, 'privacyPolicy'])->name('privacy-policy');
Route::get('/terms-and-condition', [\App\Http\Controllers\FrontController::class, 'termsAndCondition'])->name('terms-and-condition');


Route::middleware(['preventBackHistory'])->group(function () {

    Auth::routes(['verify' => true]);
    Route::post('slug-available-check', [\App\Http\Controllers\Auth\RegisterController::class, 'slugCheck'])->name('slug.check');

    Route::controller(App\Http\Controllers\Restaurant\MenuController::class)->group(function () {
        //  restaurant profile
        Route::get('{restaurant}/menu', 'show')->name('restaurant.menu');
        Route::get('{restaurant}/{food_category}/menu', 'categoryItems')->name('restaurant.menu.item');
        Route::post('foods/{food}', 'getFoodDetails')->name('restaurant.food');
    });

    Route::put('default/{language}/languages', [App\Http\Controllers\Restaurant\LanguageController::class, 'defaultLanguage'])->name('restaurant.default.language');

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware(['auth', 'default_restaurant_exists']);
    Route::post('theme_mode', [App\Http\Controllers\Controller::class, 'themeMode'])->name('theme.mode');

    Route::get('staff/plan', [App\Http\Controllers\Restaurant\VendorController::class, 'staffPlan']);


    // POS
    Route::get('/pos', [\App\Http\Controllers\POSController::class, 'index'])->name('pos.index');

    // DELIVERY
    Route::get('/delivery', [\App\Http\Controllers\DeliveryController::class, 'index'])->name('delivery.index');

    //store feedback
    Route::post('/feedback', [App\Http\Controllers\Restaurant\FeedbackController::class, 'store'])->name('feedbacks.store');

    Route::group(['middleware' => ["auth", "default_restaurant_exists"], 'as' => "restaurant."], function () {


        Route::post('global-search', [App\Http\Controllers\HomeController::class, 'globalSearch'])->name('global.search');
        Route::get('get-rightbar-content', [App\Http\Controllers\HomeController::class, 'getRightBarContent'])->name('getRightBarContent');

        //  Profile
        Route::controller(App\Http\Controllers\Restaurant\ProfileController::class)->group(function () {
            //  restaurant profile
            Route::get('webhook-data', 'webhookData')->name('webhookData')->withoutMiddleware(['default_restaurant_exists']);
            Route::get('webhook-data/{webhook}', 'webhookDetails')->name('webhookDetails')->withoutMiddleware(['default_restaurant_exists']);
            Route::get('profile', 'show')->name('profile')->withoutMiddleware(['default_restaurant_exists']);
            Route::get('profile/edit', 'edit')->name('profile.edit')->withoutMiddleware(['default_restaurant_exists']);
            Route::post('profile/delete', 'delete')->name('profile.account.delete')->withoutMiddleware(['default_restaurant_exists'])->middleware('role:vendor|staff');
            Route::put('profile/update', 'update')->name('profile.update')->withoutMiddleware(['default_restaurant_exists']);

            //  restaurant password
            Route::get('profile/change-password', 'passwordEdit')->name('password.edit')->withoutMiddleware(['default_restaurant_exists']);
            Route::put('profile/password/update', 'passwordUpdate')->name('password.update')->withoutMiddleware(['default_restaurant_exists']);
        });

        Route::get('report', [App\Http\Controllers\Restaurant\ReportController::class, 'index'])->name('report')->middleware('role:Super-Admin');

        //  restaurant users
        Route::resource('plans', App\Http\Controllers\Restaurant\PlanController::class)->middleware('role:Super-Admin');

        Route::resource('vendors', App\Http\Controllers\Restaurant\VendorController::class)->middleware('role:Super-Admin');
        Route::group(['prefix' => 'vendors', 'controller' => App\Http\Controllers\Restaurant\VendorController::class, 'middleware' => 'role:Super-Admin'], function () {
            Route::get('{vendor}/payment-history', 'paymentTransactions')->name('vendors.paymentTransactions');
            Route::get('{vendor}/subscription-history', 'subscriptionHistory')->name('vendors.subscriptionHistory');
        });

        Route::post('vendors/update-password/{vendor}', [App\Http\Controllers\Restaurant\VendorController::class, 'updatePassword'])->middleware('role:Super-Admin')->name('vendors.password.update');

        Route::post('staff/update-password/{staff}', [App\Http\Controllers\Restaurant\StaffController::class, 'updatePassword'])->middleware('role:vendor|staff')->name('staff.password.update');

        Route::resource('tables', App\Http\Controllers\Restaurant\TableController::class)->middleware('role:vendor|staff');
        Route::resource('call-waiter', App\Http\Controllers\Restaurant\CallWaiterController::class)->middleware(['role:vendor|staff', 'permission:show callwaiter']);

        //testimonials
        Route::resource('testimonials', App\Http\Controllers\Restaurant\TestimonialController::class)->middleware('role:Super-Admin');
        Route::resource('faqs', App\Http\Controllers\Restaurant\FaqQuestionController::class)->middleware('role:Super-Admin');
        Route::resource('cms-page', App\Http\Controllers\Restaurant\CmsPageController::class)->middleware('role:Super-Admin');
        Route::resource('contact-request', App\Http\Controllers\Restaurant\ContactUsController::class)->middleware('role:Super-Admin');

        // list of all feedback
        Route::get('/feedbacks', [App\Http\Controllers\Restaurant\FeedbackController::class, 'index'])->name('feedbacks.index')->middleware('permission:show feedbacks');
        Route::delete('/feedbacks/{feedback}', [App\Http\Controllers\Restaurant\FeedbackController::class, 'destroy'])->name('feedbacks.destroy')->middleware('permission:show feedbacks');

        Route::post('trail/store', [App\Http\Controllers\Restaurant\PlanController::class, 'trailDetails'])->middleware('role:Super-Admin')->name('trailDetails.store');

        //Manage Vendor Staff
        Route::resource('staff', App\Http\Controllers\Restaurant\StaffController::class)->middleware('role:vendor|staff');

        // restaurant manage
        Route::resource('restaurants', App\Http\Controllers\Restaurant\RestaurantController::class)->middleware('permission:show restaurants');
        Route::resource('environment/setting/restaurant-type', App\Http\Controllers\Restaurant\RestaurantTypeController::class)->middleware('role:Super-Admin');


        Route::get('qr', [App\Http\Controllers\Restaurant\RestaurantController::class, 'createQR'])->name('create.QR')->middleware('permission:show qrcode');
        Route::get('{restaurant}/genarteQR', [App\Http\Controllers\Restaurant\RestaurantController::class, 'genarteQR'])->name('genarteQR')->middleware('permission:show qrcode');

        // set current(default) restaurant
        Route::put('default/{restaurant}/restaurant', [App\Http\Controllers\Restaurant\RestaurantController::class, 'defaultRestaurant'])->name('default.restaurant');


        //Super Admin Role Permission
        Route::group(['middleware' => ['role:Super-Admin']], function () {

            Route::group(['prefix' => 'subscriptions', 'controller' => App\Http\Controllers\Restaurant\SubscriptionController::class, 'middleware' => 'role:Super-Admin', 'as' => 'subscriptions'], function () {
                Route::get('/', 'subscriptions');
                Route::put('/approve/{subscription}', 'approve')->name('.approve');
                Route::put('/reject/{subscription}', 'reject')->name('.reject');
                Route::put('/pending/{subscription}', 'pending')->name('.pending');
                Route::put('/delete/{subscription}', 'delete')->name('.delete');
            });

            Route::get('frontend', [App\Http\Controllers\Restaurant\EnvSettingController::class, 'frontend'])->name('frontend.admin')->middleware('role:Super-Admin');
            Route::put('frontend-images', [App\Http\Controllers\Restaurant\EnvSettingController::class, 'frontendImages'])->name('frontendImages')->middleware('role:Super-Admin');

            Route::controller(App\Http\Controllers\Restaurant\EnvSettingController::class)->group(function () {
                Route::get('environment/setting', 'show')->name('environment.setting');
                Route::put('environment/setting', 'update')->name('environment.setting.update');

                //Display Setting
                Route::get('environment/setting/display', 'displaySetting')->name('environment.setting.display');
                Route::put('environment/setting/display/save', 'displaySave')->name('environment.setting.display.update');

                //Email Setting
                Route::get('environment/setting/email', 'emailSetting')->name('environment.setting.email');
                Route::put('environment/setting/email/save', 'emailSave')->name('environment.setting.email.update');

                //SEO Setting
                Route::get('environment/setting/seo', 'seoSetting')->name('environment.setting.seo');
                Route::put('environment/setting/seo/save', 'seoSave')->name('environment.setting.seo.update');

                //Analytics code
                Route::get('environment/setting/analytics', 'analyticsSetting')->name('environment.setting.analytics');
                Route::put('environment/setting/analytics/save', 'analyticsSave')->name('environment.setting.analytics.update');

                Route::get('environment/setting/payment', 'paymentShow')->name('environment.payment');
                Route::put('environment/setting/payment', 'paymentUpdate')->name('environment.payment.update');
            });
        });

        //Manage Language
        Route::resource('languages', App\Http\Controllers\Restaurant\LanguageController::class, [
            'except' => ['show'],
            'middleware' => 'role:Super-Admin'
        ]);

        // food category management
        Route::resource('food-categories', App\Http\Controllers\Restaurant\FoodCategoryController::class, [
            'except' => ['show'],
            'names' => [
                'index' => 'food_categories.index',
                'store' => 'food_categories.store',
                'create' => 'food_categories.create',
                'update' => 'food_categories.update',
                'edit' => 'food_categories.edit',
                'destroy' => 'food_categories.destroy',
            ],
        ])->middleware(['role:vendor|staff', 'vendor_settings']);

        Route::controller(App\Http\Controllers\Restaurant\FoodCategoryController::class)->group(function () {
            Route::post('change/position', 'positionChange')->name('food_categories.change.position');
            Route::get('add_static_data', 'add_static_data');
        });

        // food management
        Route::resource('foods', App\Http\Controllers\Restaurant\FoodController::class)->middleware(['role:vendor|staff', 'vendor_settings']);

        Route::controller(App\Http\Controllers\Restaurant\FoodController::class)->group(function () {
            Route::post('food/change/position', 'positionChange')->name('foods.change.position');
            Route::post('food/update_image', 'uploadImage')->name('foods.update-image');
        });

        Route::controller(App\Http\Controllers\Restaurant\ThemeController::class)->group(function () {
            Route::get('themes', 'index')->name('themes.index');
            Route::put('theme-update', 'update')->name('themes.update');
        });

        //Vendor Setting
        Route::controller(App\Http\Controllers\Restaurant\VendorController::class)->group(function () {

            Route::get('vendor/payment/history', 'paymentHistory')->name('vendor.payment.history')->withoutMiddleware(['default_restaurant_exists']);
            Route::get('vendor/support', 'support')->name('vendor.support')->withoutMiddleware(['default_restaurant_exists']);

            Route::group(['middleware' => 'vendor_settings'], function () {
                Route::get('vendor/setting', 'setting')->name('vendor.setting');
                Route::put('vendor/setting', 'settingUpdate')->name('vendor.setting.update');

                Route::get('vendor/pusher-setting', 'pusherSetting')->name('vendor.pusher');
                Route::put('vendor/pusher-setting-update', 'pusherUpdate')->name('vendor.pusher.update');
            });
        })->middleware('role:vendor')->withoutMiddleware(['default_restaurant_exists']);

        Route::controller(App\Http\Controllers\Restaurant\PaymentController::class)->group(function () {
            Route::get('vendor/subscription', 'subscription')->name('vendor.subscription')->withoutMiddleware(['default_restaurant_exists']);
            Route::post('vendor/subscription/cancel/{subscription}', 'subscriptionCancel')->name('vendor.subscription.cancel')->withoutMiddleware(['default_restaurant_exists']);
            Route::get('vendor/subscription/manage/{subscription}', 'subscriptionManage')->name('vendor.subscription.manage')->withoutMiddleware(['default_restaurant_exists']);
            Route::get('vendor/plan', 'plan')->name('vendor.plan')->withoutMiddleware(['default_restaurant_exists']);
            Route::get('vendor/plan/{plan}', 'planDetails')->name('vendor.plan.details')->withoutMiddleware(['default_restaurant_exists']);
            Route::post('vendor/plan/{plan}', 'process')->name('vendor.plan.payment')->withoutMiddleware(['default_restaurant_exists']);
        })->middleware('role:vendor');

        //Paypal success & cancel
        Route::get('/paypal/success', [\App\Http\Controllers\Restaurant\PaypalController::class, 'processSuccess'])->name('paypal.success')->withoutMiddleware(['default_restaurant_exists']);
        Route::get('/paypal/cancelled', [\App\Http\Controllers\Restaurant\PaypalController::class, 'processCancelled'])->name('paypal.cancel')->withoutMiddleware(['default_restaurant_exists']);


        //Stripe subscription success & cancel
        Route::get('/stripe/success', [\App\Http\Controllers\Restaurant\StripeController::class, 'processSuccess'])->withoutMiddleware(['default_restaurant_exists']);
        Route::get('/stripe/cancelled', [\App\Http\Controllers\Restaurant\StripeController::class, 'processCancelled'])->withoutMiddleware(['default_restaurant_exists']);

        //Stripe onetime success & cancel
        Route::get('/stripe/onetime-success', [\App\Http\Controllers\Restaurant\StripeController::class, 'onetimeSuccess'])->withoutMiddleware(['default_restaurant_exists']);
        Route::get('/stripe/onetime-cancelled', [\App\Http\Controllers\Restaurant\StripeController::class, 'onetimeCancelled'])->withoutMiddleware(['default_restaurant_exists']);
    });

    Route::get('dev_logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
});

Route::group(['middleware' => ["auth", "default_restaurant_exists"], 'as' => "restaurant."], function () {
    Route::controller(App\Http\Controllers\Restaurant\LanguageController::class)->group(function () {
        Route::get('export-sample', 'sampleDownload')->name('languages.export.sample');
        Route::post('import-sample', 'sampleImport')->name('languages.import.sample');
    });
});

// web hooks
Route::group(['prefix' => '/webhook', 'controller' => \App\Http\Controllers\WebHookController::class], function () {
    Route::post('/stripe', 'stripe');
    Route::post('/paypal', 'paypal');
});

Route::get('/{restaurant}', [\App\Http\Controllers\FrontController::class, 'restaurant'])->name('frontend.restaurant');
Route::post('/table-assign', [\App\Http\Controllers\FrontController::class, 'tableAssign'])->name('frontend.tableAssign');
