<?php

namespace App\Providers;

use App\Models\Category;
use App\Services\ProductService;
use Illuminate\Support\Facades\View;
use App\Repositories\ProductRepository;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\ProductRepositoryInterface;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(ProductService::class, function ($app) {
            return new ProductService($app->make(ProductRepositoryInterface::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (Schema::hasTable('categories')) {
            $categories = Category::with('subcategory')->get();
            View::share('categories', $categories);
        }
    }
}
