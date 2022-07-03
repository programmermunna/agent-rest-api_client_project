<?php

namespace App\Providers;

use Auth;

use Illuminate\Support\Facades\Schema;

use Illuminate\Support\ServiceProvider;
use Spatie\Activitylog\Models\Activity;
use View;

/**
 * Class AppServiceProvider.
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        # rey, 17 nov 2020 04:19 am
        view()->composer('*', function ($view) {
            if (Auth::check()) {
            }
        });

        Activity::saving(function (Activity $activity) {
            $activity->properties = $activity->properties->put('ip', request()->ip());
        });

        \Str::macro('snakeToTitle', function ($value) {
            return \Str::title(str_replace('_', ' ', $value));
        });
    }
}
