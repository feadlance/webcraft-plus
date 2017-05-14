<?php

namespace App\Providers;

use App;
use View;
use Artisan;
use Carbon\Carbon;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Carbon Set Locale.
         */
        Carbon::setLocale(App::getLocale());

        /**
         * Fix Schema Problem.
         */
        Schema::defaultStringLength(191);

        /**
         * Share Meta Tags on View
         */
        View::composer('layouts.master', 'App\ViewComposers\MetaTagsComposer');

        /**
         * Share Online Users on View
         */
        View::composer('layouts.master', 'App\ViewComposers\OnlineUsersComposer');

        /**
         * Share Sidebar Variables on View
         */
        View::composer('layouts.sidebar', 'App\ViewComposers\SidebarComposer');

        /**
         * Generate Key If Empty
         */
        if ( empty(config('app.key')) === true ) {
            Artisan::call('app:setup');
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
