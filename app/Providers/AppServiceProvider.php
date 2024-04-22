<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register a view composer to provide active categories to the header layout
        view()->composer("home.layouts.header", function ($view) {
            $categories = Category::where("status", "active")->get();
            $view->with('categories', $categories);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
