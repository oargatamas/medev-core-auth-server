<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 20.
 * Time: 11:25
 */

namespace MedevAuth\Services\Auth\OAuth\APIProtection;


use MedevSlim\Core\Service\APIService;
use Slim\Interfaces\RouteGroupInterface;

abstract class OAuthProtectedAPIService extends APIService
{
    protected function registerMiddlewares(RouteGroupInterface $group)
    {
        parent::registerMiddlewares($group);
        $group->add(new OAuthAPIProtector($this));
    }

}