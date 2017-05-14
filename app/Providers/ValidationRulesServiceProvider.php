<?php

namespace App\Providers;

use Validator;
use Illuminate\Support\ServiceProvider;

class ValidationRulesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('money', function ($attribute, $value, $parameters, $validator) {
            return !empty($value) ? (preg_match('/^(\d*([.,](?=\d{3}))?\d+)+((?!\2)[.,]\d\d)?$/', $value)) : true;
        });

        Validator::extend('recaptcha', function ($attribute, $value, $parameters, $validator) {
            $post = curlPost('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => settings('recaptcha.private_key'),
                'response' => $value
            ]);

            $response = json_decode($post);

            return $response->success;
        });

        Validator::extend('username', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/[^A-Za-z0-9_]/', $value) === 0;
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
