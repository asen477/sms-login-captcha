<?php

namespace Trunks\SmsLoginCaptcha;

use Encore\Admin\Admin;
use Encore\Admin\Extension;
use Illuminate\Support\Facades\Route;

class Trunks extends Extension
{
    public static function boot(){
        static::registerRoutes();
        Admin::extend('sms-login-captcha', __CLASS__);
    }

    protected static function registerRoutes(){
        parent::routes(function ($router) {
            $router->get('auth/login', 'Trunks\SmsLoginCaptcha\TrunksController@getLogin');
            $router->post('auth/login', 'Trunks\SmsLoginCaptcha\TrunksController@postLogin');
        });
    }

}