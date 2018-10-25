<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Route;

class ValidationExtensionServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the Validation Extension.
     *
     * @return void
     */
    public function boot()
    {
	    Validator::extend('mobile', function ($attribute, $value, $parameters, $validator) {
		    return is_mobile_number($value);
	    });

	    Validator::extend('route_exists', function ($attribute, $value, $parameters, $validator) {
		    return Route::getRoutes()->hasNamedRoute($value);
	    });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
