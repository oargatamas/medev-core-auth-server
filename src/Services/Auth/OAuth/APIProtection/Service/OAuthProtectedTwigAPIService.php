<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 09. 10.
 * Time: 12:41
 */

namespace MedevAuth\Services\Auth\OAuth\APIProtection\Service;


use MedevAuth\Services\Auth\OAuth\APIProtection\Middleware\OAuthAPIProtector;
use MedevSlim\Core\Service\View\TwigAPIService;
use Slim\Interfaces\RouteGroupInterface;

abstract class OAuthProtectedTwigAPIService extends TwigAPIService
{
    protected function registerMiddlewares(RouteGroupInterface $group)
    {
        parent::registerMiddlewares($group);
        $group->add(new OAuthAPIProtector($this));
    }
}