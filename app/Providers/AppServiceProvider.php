<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;
use App\Model\User;
use Hash;
use Auth;

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
        Validator::extend('alpha_spaces', function ($attribute, $value) {
            // This will only accept alpha and spaces. 
            // If you want to accept hyphens use: /^[\pL\s-]+$/u.
            return ($value != '') ? preg_match('/^[a-zA-Z\s]+$/u', $value) : true;
        });

        Validator::extend('old_password', function ($attribute, $value,$parameters) {
            return (!Hash::check($value, User::getPassword($parameters[0]))) ? false : true;
        });

        Validator::extend('validate_html_value', function ($attribute, $value) {
            return (!strip_tags(str_replace(' ', '', $value))) ? false : true;
        });
    }
}
