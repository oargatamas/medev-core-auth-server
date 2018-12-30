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

class MedevSuiteCustomAuthService extends OAuthService
{

    protected function registerContainerComponents(ContainerInterface $container)
    {

    }
}