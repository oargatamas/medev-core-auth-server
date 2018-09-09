<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 06.
 * Time: 13:46
 */

namespace MedevAuth\Application\Auth;


use MedevAuth\Application\Auth\Tokens\Access\AccessTokenRepository;
use MedevAuth\Application\Auth\Tokens\Refresh\RefreshTokenConfig;
use MedevAuth\Application\Auth\Tokens\Refresh\RefreshTokenRepository;
use MedevAuth\Application\Auth\Users\UserRepository;
use MedevAuth\Application\Auth\Tokens\Access\AccessTokenConfig;
use MedevAuth\Services\Auth\OAuth\OAuthService;

use Psr\Container\ContainerInterface;

class MedevSuiteAuthService extends OAuthService
{
    protected function registerIOCComponents(ContainerInterface $container)
    {
        $container["OauthUserRepository"] = function ($container) {
            return new UserRepository($container);
        };

        $container["OauthAccessTokenConfig"] = function ($container) {
            $publicKey = "file://../config/publicKey.pem";
            $privateKey = "file://../config/privateKey.pem";
            $passPhrase = "test";
            return new AccessTokenConfig($publicKey, $privateKey, $passPhrase);
        };

        $container["OauthRefreshTokenConfig"] = function ($container) {
            $publicKey = "file://../config/publicKey.pem";
            $privateKey = "file://../config/privateKey.pem";
            $passPhrase = "test";
            return new RefreshTokenConfig($publicKey, $privateKey, $passPhrase);
        };

        $container["OauthAccessTokenRepository"] = function ($container) {
            return new AccessTokenRepository($container);
        };

        $container["OauthRefreshTokenRepository"] = function ($container) {
            return new RefreshTokenRepository($container);
        };


    }
}