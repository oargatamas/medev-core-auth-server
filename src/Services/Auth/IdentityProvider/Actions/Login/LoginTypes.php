<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 11. 23.
 * Time: 17:20
 */

namespace MedevAuth\Services\Auth\IdentityProvider\Actions\Login;


use MedevAuth\Services\Auth\IdentityProvider\AuthCodeLoginService;
use MedevAuth\Services\Auth\IdentityProvider\PasswordLoginService;

class LoginTypes
{
    const PASSWORD = "password";
    const AUTHCODE = "authcode";

    const REDIRECT = [
        self::PASSWORD => PasswordLoginService::ROUTE_LOGIN_VIEW,
        self::AUTHCODE => AuthCodeLoginService::ROUTE_LOGIN_VIEW
    ];
}