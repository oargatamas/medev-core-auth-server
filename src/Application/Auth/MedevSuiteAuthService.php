<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 06.
 * Time: 13:46
 */

namespace MedevAuth\Application\Auth;


use MedevAuth\Application\Tokens\Access\AccessTokenConfig;
use MedevAuth\Application\Tokens\Refresh\RefreshTokenConfig;
use MedevAuth\Services\Auth\OAuth\OAuthService;
use MedevAuth\TokenRepositories\Application\AccessTokenRepository;
use MedevAuth\TokenRepositories\Application\RefreshTokenRepository;
use Psr\Container\ContainerInterface;

class MedevSuiteAuthService extends OAuthService
{
    protected function registerIOCComponents(ContainerInterface $container)
    {
        $container["OauthAccessTokenConfig"] = function ($container) {
            return new AccessTokenConfig();
        };

        $container["OauthRefreshTokenConfig"] = function ($container) {
            return new RefreshTokenConfig();
        };

        $container["OauthAccessTokenRepository"] = function ($container) {
            return new AccessTokenRepository($container);
        };

        $container["OauthRefreshTokenRepository"] = function ($container) {
            return new RefreshTokenRepository($container);
        };

    }
}