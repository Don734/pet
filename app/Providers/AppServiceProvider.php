<?php

namespace App\Providers;

use App\View\Components\CategoryMenuComponent;
use App\View\Components\FooterComponent;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Blade::component('category-menu', CategoryMenuComponent::class);
        Blade::component('footer', FooterComponent::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
