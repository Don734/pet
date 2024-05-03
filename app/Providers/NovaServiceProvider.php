<?php

namespace App\Providers;

use App\Nova\Category;
use App\Nova\City;
use App\Nova\SearchTag;
use App\Nova\Client;
use App\Nova\Handbook;
use App\Nova\PrivacyPolicy;
use App\Nova\Review;
use App\Nova\Service;
use App\Nova\Tag;
use App\Nova\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        Nova::translations('lang/vendor/nova/ru.json');

        Nova::mainMenu(function (Request $request) {
            return [
                MenuSection::make(__('Пользователи'), [
                    MenuItem::resource(User::class),
                    MenuItem::resource(Client::class),
                ])->icon('users')
                    ->collapsable(),
                MenuSection::make('База данных', [
                    MenuItem::resource(Category::class),
                    MenuItem::resource(Handbook::class),
                    MenuItem::resource(Review::class),
                    MenuItem::resource(Tag::class),
                    MenuItem::resource(PrivacyPolicy::class),
                    MenuItem::resource(Service::class),
                    MenuItem::resource(City::class),
                    MenuItem::resource(SearchTag::class),
                ])->icon('server')
                    ->collapsable(),
            ];
        });

        Nova::footer(function (Request $request) {
            return Blade::render(
                'Powered by WAPP © {!! $year !!} <a class="link-default ml-3" '
                .'href="mailto: support@wapp.dev">Написать в поддержку</a>',
                ['year' => date('Y')]
            );
        });
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return in_array($user->email, [
                //
            ]);
        });
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [
            new \App\Nova\Dashboards\Main,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Nova::translations('lang/vendor/nova/ru.json');
    }
}
