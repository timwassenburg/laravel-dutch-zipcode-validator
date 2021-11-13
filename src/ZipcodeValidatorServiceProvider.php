<?php

namespace TimWassenburg\DutchZipcodeValidator;

use Illuminate\Support\ServiceProvider;
use Validator;

class ZipcodeValidatorServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'zipcode-validator');
        $this->registerDutchZipcodeRule();

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/zipcode-validator'),
            ], 'translations');
        }
    }

    public function registerDutchZipcodeRule()
    {
        Validator::extend('DutchZipcode', function ($attribute, $zipcode) {
            return preg_match('/^[1-9][0-9]{3} ?(?!sa|sd|ss)[a-z]{2}$/i', $zipcode);
        }, trans('zipcode-validator::validation.zipcode'));
    }
}
