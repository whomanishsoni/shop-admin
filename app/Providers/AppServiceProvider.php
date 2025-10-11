<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View; // Corrected namespace
use App\Models\Category;
use App\Models\Setting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        // View composer for header and footer partials
        View::composer(['store.partials.header', 'store.partials.footer'], function ($view) {
            $categories = Category::where('status', true)
                ->with(['subcategories' => function ($query) {
                    $query->where('status', true);
                }])
                ->get();

            // Fetch social media links and other footer settings
            $settings = Setting::whereIn('key', [
                'site_name', 'site_email', 'site_phone', 'site_address','site_logo', 'site_favicon', 'footer_logo', 'footer_text', 'site_description',
                'facebook_url', 'twitter_url', 'instagram_url', 'youtube_url', 'linkedin_url', 'pinterest_url'
            ])->pluck('value', 'key')->toArray();

            $view->with([
                'categories' => $categories,
                'settings' => $settings
            ]);
        });
    }
}
