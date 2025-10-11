<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View; // Corrected namespace
use App\Models\Category;

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
            $view->with('categories', $categories);
        });
    }
}
