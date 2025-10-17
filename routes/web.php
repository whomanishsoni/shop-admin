<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    AuthController, DashboardController, CategoryController, SubcategoryController,
    ProductController as AdminProductController, ProductAttributeController,
    ProductReviewController as AdminProductReviewController, BrandController,
    OrderController as AdminOrderController, CustomerController, CouponController,
    TransactionController, ShippingMethodController, ShippingZoneController,
    TaxController, CurrencyController, PaymentGatewayController, TicketController,
    SettingController, SliderController, EmailTemplateController, LanguageController,
    FaqController, BlogCategoryController, BlogPostController, PageController,
    SubscriberController, BannerController, ActivityLogController, NotificationController,
    UserController, AnalyticsController, BackupController, ProductImportExportController
};
use App\Http\Controllers\Store\{
    HomeController, AccountController, AboutController, CartController,
    ContactController, LegalController, OrderController, ProductController,
    ShopController, WishlistController, CheckoutController, ProductReviewController,
    BlogController // Added for blog routes
};

Route::get('/', [HomeController::class, 'index'])->name('home');

// Store frontend routes
Route::get('/shop/{slug?}', [ShopController::class, 'index'])->name('shop');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.detail');
Route::get('/product/quickview/{slug}', [ProductController::class, 'quickview'])->name('product.quickview');

// Cart routes
Route::get('/cart', [CartController::class, '__invoke'])->name('cart');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/cart/data', [CartController::class, 'getCartData'])->name('cart.data');

// Checkout routes
Route::get('/checkout', [CheckoutController::class, '__invoke'])->name('checkout');
Route::post('/checkout/save-address', [CheckoutController::class, 'saveAddress'])->name('checkout.saveAddress');
Route::post('/checkout/create-order', [CheckoutController::class, 'createOrderAndPayment'])->name('checkout.createOrderAndPayment');
Route::post('/checkout/coupon', [CheckoutController::class, 'applyCoupon'])->name('checkout.applyCoupon');
Route::get('/checkout/coupon/remove', [CheckoutController::class, 'removeCoupon'])->name('checkout.removeCoupon');
Route::get('/checkout/success/{id}', [CheckoutController::class, 'success'])->name('checkout.success');
Route::get('/checkout/payment/{orderId?}', [CheckoutController::class, 'payment'])->name('checkout.payment');
Route::post('/checkout/initiate-payment/{orderId}', [CheckoutController::class, 'initiatePayment'])->name('checkout.initiatePayment');

Route::get('/wishlist', [WishlistController::class, '__invoke'])->name('wishlist');
Route::post('/wishlist/add', [WishlistController::class, 'add'])->name('wishlist.add');
Route::post('/wishlist/remove', [WishlistController::class, 'remove'])->name('wishlist.remove');
Route::post('/wishlist/move-to-cart', [WishlistController::class, 'moveToCart'])->name('wishlist.moveToCart');
Route::get('/wishlist/count', [WishlistController::class, 'getCount'])->name('wishlist.count');

// Product reviews route
Route::middleware(['auth:customer'])->group(function () {
    Route::post('/product-reviews', [ProductReviewController::class, 'store'])->name('product-reviews.store');
});

// Moved login and register routes outside the 'account' prefix
Route::middleware(['guest:customer'])->group(function () {
    Route::get('/login', [AccountController::class, 'login'])->name('login');
    Route::post('/login', [AccountController::class, 'loginAttempt'])->name('login.attempt');
    Route::get('/register', [AccountController::class, 'register'])->name('register');
    Route::post('/register', [AccountController::class, 'registerAttempt'])->name('register.attempt');
    Route::match(['get', 'post'], '/forgot-password', [AccountController::class, 'forgotPassword'])->name('forgot_password');
});

// Account routes (remaining routes under 'account' prefix)
Route::prefix('account')->middleware('auth:customer')->group(function () {
    Route::get('/profile', [AccountController::class, 'profile'])->name('profile');
    Route::get('/edit-profile', [AccountController::class, 'editProfile'])->name('editProfile');
    Route::post('/edit-profile', [AccountController::class, 'updateProfile'])->name('update_profile');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::get('/orders/{id}/invoice', [OrderController::class, 'invoice'])->name('order.invoice');
    Route::get('/addresses', [AccountController::class, 'addresses'])->name('addresses');
    Route::get('/addresses/create', [AccountController::class, 'createAddress'])->name('address.create');
    Route::post('/addresses/store', [AccountController::class, 'storeAddress'])->name('address.store');
    Route::get('/addresses/{id}/edit', [AccountController::class, 'editAddress'])->name('address.edit');
    Route::put('/addresses/{id}', [AccountController::class, 'updateAddress'])->name('address.update');
    Route::delete('/addresses/{id}', [AccountController::class, 'deleteAddress'])->name('address.delete');
    Route::post('/logout', [AccountController::class, 'logout'])->name('logout');
});

// Other frontend routes
Route::get('/about', [AboutController::class, '__invoke'])->name('about');
Route::get('/contact', [ContactController::class, '__invoke'])->name('contact');
Route::get('/privacy-policy', [LegalController::class, 'privacyPolicy'])->name('privacy-policy');
Route::get('/terms-conditions', [LegalController::class, 'termsConditions'])->name('terms-conditions');
Route::get('/refund-policy', [LegalController::class, 'refundPolicy'])->name('refund-policy');
Route::get('/shipping-policy', [LegalController::class, 'shippingPolicy'])->name('shipping-policy');

// Blog routes
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/blog/{category?}', [BlogController::class, 'index'])->name('blog.index');

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware(['auth'])->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('subcategory-options/{category_id}', [AdminProductController::class, 'getSubcategories'])->name('subcategories.get');

        // Catalog Routes
        Route::resource('categories', CategoryController::class);
        Route::post('categories/bulk-delete', [CategoryController::class, 'bulkDelete'])->name('categories.bulk-delete');

        Route::resource('subcategories', SubcategoryController::class);
        Route::post('subcategories/bulk-delete', [SubcategoryController::class, 'bulkDelete'])->name('subcategories.bulk-delete');

        Route::resource('brands', BrandController::class);
        Route::post('brands/bulk-delete', [BrandController::class, 'bulkDelete'])->name('brands.bulk-delete');

        Route::resource('products', AdminProductController::class);
        Route::post('products/bulk-delete', [AdminProductController::class, 'bulkDelete'])->name('products.bulk-delete');

        Route::resource('product-attributes', ProductAttributeController::class);
        Route::post('product-attributes/bulk-delete', [ProductAttributeController::class, 'bulkDelete'])->name('product-attributes.bulk-delete');

        Route::resource('product-reviews', AdminProductReviewController::class)->only(['index', 'edit', 'update', 'destroy', 'show']);
        Route::post('product-reviews/{id}/approve', [AdminProductReviewController::class, 'approve'])->name('product-reviews.approve');
        Route::post('product-reviews/bulk-delete', [AdminProductReviewController::class, 'bulkDelete'])->name('product-reviews.bulk-delete');

        // Orders & Customers
        Route::resource('orders', AdminOrderController::class)->except(['create', 'store']);
        Route::get('orders/{id}/invoice', [AdminOrderController::class, 'invoice'])->name('orders.invoice');
        Route::post('orders/{id}/update-status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
        Route::post('orders/bulk-delete', [AdminOrderController::class, 'bulkDelete'])->name('orders.bulk-delete');

        Route::resource('customers', CustomerController::class);
        Route::post('customers/bulk-delete', [CustomerController::class, 'bulkDelete'])->name('customers.bulk-delete');
        Route::get('customers/{id}/orders', [CustomerController::class, 'orders'])->name('customers.orders');

        // Marketing
        Route::resource('coupons', CouponController::class);
        Route::post('coupons/bulk-delete', [CouponController::class, 'bulkDelete'])->name('coupons.bulk-delete');

        // Shipping & Payments
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

        // Transactions
        Route::resource('transactions', TransactionController::class)->only(['index', 'show']);
        Route::post('transactions/bulk-delete', [TransactionController::class, 'bulkDelete'])->name('transactions.bulk-delete');

        // Support
        Route::resource('tickets', TicketController::class);
        Route::post('tickets/{id}/reply', [TicketController::class, 'reply'])->name('tickets.reply');
        Route::post('tickets/bulk-delete', [TicketController::class, 'bulkDelete'])->name('tickets.bulk-delete');

        // Content Management
        Route::resource('sliders', SliderController::class);
        Route::post('sliders/bulk-delete', [SliderController::class, 'bulkDelete'])->name('sliders.bulk-delete');

        Route::resource('banners', BannerController::class);
        Route::post('banners/bulk-delete', [BannerController::class, 'bulkDelete'])->name('banners.bulk-delete');

        Route::resource('pages', PageController::class);
        Route::post('pages/bulk-delete', [PageController::class, 'bulkDelete'])->name('pages.bulk-delete');

        // Blog
        Route::resource('blog-categories', BlogCategoryController::class);
        Route::post('blog-categories/bulk-delete', [BlogCategoryController::class, 'bulkDelete'])->name('blog-categories.bulk-delete');

        Route::resource('blog-posts', BlogPostController::class);
        Route::post('blog-posts/bulk-delete', [BlogPostController::class, 'bulkDelete'])->name('blog-posts.bulk-delete');
        Route::get('blog-posts/{id}/comments', [BlogPostController::class, 'comments'])->name('blog-posts.comments');

        // Email & Communications
        Route::resource('email-templates', EmailTemplateController::class);
        Route::post('email-templates/bulk-delete', [EmailTemplateController::class, 'bulkDelete'])->name('email-templates.bulk-delete');

        Route::resource('subscribers', SubscriberController::class)->only(['index', 'destroy']);
        Route::get('subscribers/export', [SubscriberController::class, 'export'])->name('subscribers.export');
        Route::post('subscribers/bulk-delete', [SubscriberController::class, 'bulkDelete'])->name('subscribers.bulk-delete');

        // Settings & System
        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('settings/bulk-update', [SettingController::class, 'bulkUpdate'])->name('settings.bulk-update');
        Route::post('settings/bulk-delete', [SettingController::class, 'bulkDelete'])->name('settings.bulk-delete');

        Route::resource('languages', LanguageController::class);
        Route::post('languages/bulk-delete', [LanguageController::class, 'bulkDelete'])->name('languages.bulk-delete');

        Route::resource('faqs', FaqController::class);
        Route::post('faqs/bulk-delete', [FaqController::class, 'bulkDelete'])->name('faqs.bulk-delete');

        // System
        Route::get('activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');

        Route::resource('notifications', NotificationController::class)->only(['index', 'show', 'destroy']);
        Route::post('notifications/{id}/mark-read', [NotificationController::class, 'markRead'])->name('notifications.mark-read');

        Route::get('backups', [BackupController::class, 'index'])->name('backups.index');
        Route::post('backups/create', [BackupController::class, 'create'])->name('backups.create');
        Route::get('backups/{file}/download', [BackupController::class, 'download'])->name('backups.download');

        // Profile
        Route::get('profile', [UserController::class, 'profile'])->name('profile');
        Route::post('profile', [UserController::class, 'updateProfile'])->name('profile.update');
        Route::post('profile/password', [UserController::class, 'updatePassword'])->name('profile.password');

        // Analytics & Reports
        Route::get('analytics', [AnalyticsController::class, 'index'])->name('analytics');
        Route::get('inventory-reports', [AdminProductController::class, 'inventoryReport'])->name('inventory-reports');

        // Import/Export
        Route::get('products/import', [ProductImportExportController::class, 'import'])->name('products.import');
        Route::post('products/import', [ProductImportExportController::class, 'processImport'])->name('products.import.process');
        Route::get('products/export', [ProductImportExportController::class, 'export'])->name('products.export');

        // Settings Pages
        Route::get('seo-settings', [SettingController::class, 'seo'])->name('seo-settings');
        Route::post('seo-settings', [SettingController::class, 'updateSeo'])->name('seo-settings.update');

        Route::get('social-login', [SettingController::class, 'socialLogin'])->name('social-login');
        Route::post('social-login', [SettingController::class, 'updateSocialLogin'])->name('social-login.update');

        Route::get('cookie-alert', [SettingController::class, 'cookieAlert'])->name('cookie-alert');
        Route::post('cookie-alert', [SettingController::class, 'updateCookieAlert'])->name('cookie-alert.update');
    });
});
