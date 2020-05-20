<?php

namespace Trunks\SmsLoginCaptcha;

use Illuminate\Support\ServiceProvider;

class TrunksServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        if (!config('admin.extensions.login-captcha.enable', 'true')) {
            return;
        }
        
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'login-captcha');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'login-captcha');

        $this->publishes([
            __DIR__.'/../resources/lang/zh-CN/validation.php' => resource_path('lang/zh-CN/validation.php'),
            __DIR__.'/../resources/lang/zh-CN/auth.php' => resource_path('lang/zh-CN/auth.php'),
        ], 'lang');

        Trunks::boot();
    }
}