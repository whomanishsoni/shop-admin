<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    AuthController, DashboardController, CategoryController, SubcategoryController,
    ProductController, ProductAttributeController, ProductReviewController, OrderController,
    CustomerController, CouponController, TransactionController, ShippingMethodController,
    ShippingZoneController, TaxController, CurrencyController, PaymentGatewayController,
    TicketController, SettingController, SliderController, EmailTemplateController,
    LanguageController, FaqController, BlogCategoryController, BlogPostController,
    PageController, SubscriberController, BannerController, ActivityLogController,
    NotificationController, UserController, AnalyticsController, BackupController,
    ProductImportExportController
};

Route::get('/', function () {
    return redirect(route('admin.login'));
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware(['auth'])->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('categories', CategoryController::class);
        Route::post('categories/bulk-delete', [CategoryController::class, 'bulkDelete'])->name('categories.bulk-delete');

        Route::resource('subcategories', SubcategoryController::class);
        Route::post('subcategories/bulk-delete', [SubcategoryController::class, 'bulkDelete'])->name('subcategories.bulk-delete');

        Route::resource('products', ProductController::class);
        Route::post('products/bulk-delete', [ProductController::class, 'bulkDelete'])->name('products.bulk-delete');

        Route::resource('product-attributes', ProductAttributeController::class);
        Route::post('product-attributes/bulk-delete', [ProductAttributeController::class, 'bulkDelete'])->name('product-attributes.bulk-delete');

        Route::resource('product-reviews', ProductReviewController::class)->only(['index', 'edit', 'update', 'destroy']);
        Route::post('product-reviews/{id}/approve', [ProductReviewController::class, 'approve'])->name('product-reviews.approve');
        Route::post('product-reviews/bulk-delete', [ProductReviewController::class, 'bulkDelete'])->name('product-reviews.bulk-delete');

        Route::resource('orders', OrderController::class)->except(['create', 'store']);
        Route::get('orders/{id}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');
        Route::post('orders/{id}/update-status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
        Route::post('orders/bulk-delete', [OrderController::class, 'bulkDelete'])->name('orders.bulk-delete');

        Route::resource('customers', CustomerController::class);
        Route::post('customers/bulk-delete', [CustomerController::class, 'bulkDelete'])->name('customers.bulk-delete');
        Route::get('customers/{id}/orders', [CustomerController::class, 'orders'])->name('customers.orders');

        Route::resource('coupons', CouponController::class);
        Route::post('coupons/bulk-delete', [CouponController::class, 'bulkDelete'])->name('coupons.bulk-delete');

        Route::resource('transactions', TransactionController::class)->only(['index', 'show']);
        Route::post('transactions/bulk-delete', [TransactionController::class, 'bulkDelete'])->name('transactions.bulk-delete');


        Route::resource('shipping-methods', ShippingMethodController::class);
        Route::post('shipping-methods/bulk-delete', [ShippingMethodController::class, 'bulkDelete'])->name('shipping-methods.bulk-delete');

        Route::resource('shipping-zones', ShippingZoneController::class);
        Route::post('shipping-zones/bulk-delete', [ShippingZoneController::class, 'bulkDelete'])->name('shipping-zones.bulk-delete');

        Route::resource('taxes', TaxController::class);
        Route::post('taxes/bulk-delete', [TaxController::class, 'bulkDelete'])->name('taxes.bulk-delete');

        Route::resource('currencies', CurrencyController::class);
        Route::post('currencies/bulk-delete', [CurrencyController::class, 'bulkDelete'])->name('currencies.bulk-delete');

        Route::resource('payment-gateways', PaymentGatewayController::class);
        Route::post('payment-gateways/bulk-delete', [PaymentGatewayController::class, 'bulkDelete'])->name('payment-gateways.bulk-delete');

        Route::resource('tickets', TicketController::class);
        Route::post('tickets/{id}/reply', [TicketController::class, 'reply'])->name('tickets.reply');
        Route::post('tickets/bulk-delete', [TicketController::class, 'bulkDelete'])->name('tickets.bulk-delete');

        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('settings', [SettingController::class, 'store'])->name('settings.store');
        Route::post('settings/bulk-delete', [TicketController::class, 'bulkDelete'])->name('settings.bulk-delete');


        Route::resource('sliders', SliderController::class);
        Route::post('sliders/bulk-delete', [SliderController::class, 'bulkDelete'])->name('sliders.bulk-delete');

        Route::resource('email-templates', EmailTemplateController::class);
        Route::post('email-templates/bulk-delete', [EmailTemplateController::class, 'bulkDelete'])->name('email-templates.bulk-delete');

        Route::resource('languages', LanguageController::class);
        Route::post('languages/bulk-delete', [LanguageController::class, 'bulkDelete'])->name('languages.bulk-delete');

        Route::resource('faqs', FaqController::class);
        Route::post('faqs/bulk-delete', [FaqController::class, 'bulkDelete'])->name('faqs.bulk-delete');

        Route::resource('blog-categories', BlogCategoryController::class);
        Route::post('blog-categories/bulk-delete', [BlogCategoryController::class, 'bulkDelete'])->name('blog-categories.bulk-delete');

        Route::resource('blog-posts', BlogPostController::class);
        Route::post('blog-posts/bulk-delete', [BlogPostController::class, 'bulkDelete'])->name('blog-posts.bulk-delete');
        Route::get('blog-posts/{id}/comments', [BlogPostController::class, 'comments'])->name('blog-posts.comments');

        Route::resource('pages', PageController::class);
        Route::post('pages/bulk-delete', [PageController::class, 'bulkDelete'])->name('pages.bulk-delete');

        Route::resource('subscribers', SubscriberController::class)->only(['index', 'destroy']);
        Route::get('subscribers/export', [SubscriberController::class, 'export'])->name('subscribers.export');
        Route::post('subscribers/bulk-delete', [SubscriberController::class, 'bulkDelete'])->name('subscribers.bulk-delete');

        Route::resource('banners', BannerController::class);
        Route::post('banners/bulk-delete', [BannerController::class, 'bulkDelete'])->name('banners.bulk-delete');

        Route::get('activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');

        Route::resource('notifications', NotificationController::class)->only(['index', 'show', 'destroy']);
        Route::post('notifications/{id}/mark-read', [NotificationController::class, 'markRead'])->name('notifications.mark-read');

        Route::get('profile', [UserController::class, 'profile'])->name('profile');
        Route::post('profile', [UserController::class, 'updateProfile'])->name('profile.update');
        Route::post('profile/password', [UserController::class, 'updatePassword'])->name('profile.password');

        Route::get('analytics', [AnalyticsController::class, 'index'])->name('analytics');

        Route::get('inventory-reports', [ProductController::class, 'inventoryReport'])->name('inventory-reports');

        Route::get('seo-settings', [SettingController::class, 'seo'])->name('seo-settings');
        Route::post('seo-settings', [SettingController::class, 'updateSeo'])->name('seo-settings.update');

        Route::get('social-login', [SettingController::class, 'socialLogin'])->name('social-login');
        Route::post('social-login', [SettingController::class, 'updateSocialLogin'])->name('social-login.update');

        Route::get('cookie-alert', [SettingController::class, 'cookieAlert'])->name('cookie-alert');
        Route::post('cookie-alert', [SettingController::class, 'updateCookieAlert'])->name('cookie-alert.update');

        Route::get('backups', [BackupController::class, 'index'])->name('backups.index');
        Route::post('backups/create', [BackupController::class, 'create'])->name('backups.create');
        Route::get('backups/{file}/download', [BackupController::class, 'download'])->name('backups.download');

        Route::get('products/import', [ProductImportExportController::class, 'import'])->name('products.import');
        Route::post('products/import', [ProductImportExportController::class, 'processImport'])->name('products.import.process');
        Route::get('products/export', [ProductImportExportController::class, 'export'])->name('products.export');
    });
});
