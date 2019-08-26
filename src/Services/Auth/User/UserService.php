<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 08. 19.
 * Time: 15:42
 */

namespace MedevAuth\Services\Auth\User;


use MedevAuth\Services\Auth\OAuth\APIProtection\Service\OAuthProtectedAPIService;
use MedevAuth\Services\Auth\User\Actions\Api\UserInfo;
use MedevSlim\Core\Service\APIService;
use Slim\App;

class UserService extends OAuthProtectedAPIService
{
    const ROUTE_USER_INFO = "userInfo";

    /**
     * @param App $app
     * @throws \Exception
     */
    protected function registerRoutes(App $app)
    {
        $app->get("/info", new UserInfo($this))
            ->setArgument(APIService::SERVICE_ID,$this->getServiceName())
            ->setName(self::ROUTE_USER_INFO);
    }
}