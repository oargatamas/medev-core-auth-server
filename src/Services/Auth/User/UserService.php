<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 08. 19.
 * Time: 15:42
 */

namespace MedevAuth\Services\Auth\User;

use MedevAuth\Services\Auth\OAuth\APIProtection\Service\OAuthProtectedTwigAPIService;
use MedevAuth\Services\Auth\User\Actions\Api\UserInfo;
use MedevAuth\Services\Auth\User\Actions\Api\UserRegistration;
use MedevAuth\Services\Auth\User\Actions\Api\VerifyRegistration;
use MedevSlim\Core\Action\Middleware\ReCaptchaValidator;
use MedevSlim\Core\Action\Middleware\RequestValidator;
use MedevSlim\Core\Action\Middleware\ScopeValidator;
use MedevSlim\Core\Service\APIService;
use Slim\App;

class UserService extends OAuthProtectedTwigAPIService
{
    const ROUTE_USER_INFO = "userInfo";
    const ROUTE_REGISTER = "userRegistration";
    const ROUTE_VERIFY = "userVerification";

    /**
     * @param App $app
     * @throws \Exception
     */
    protected function registerRoutes(App $app)
    {
        $app->get("/info", new UserInfo($this))
            ->setArgument(APIService::SERVICE_ID,$this->getServiceName())
            ->setName(self::ROUTE_USER_INFO);

        $app->post("/register", new UserRegistration($this))
            ->setArgument(APIService::SERVICE_ID,$this->getServiceName())
            ->add(new ReCaptchaValidator($this->application))
            ->add(new RequestValidator(UserRegistration::getParams()))
            ->add(new ScopeValidator(UserRegistration::getScopes()))
            ->setName(self::ROUTE_REGISTER);

        $app->get("/verify", new VerifyRegistration($this))
            ->setArgument(APIService::SERVICE_ID,$this->getServiceName())
            ->add(new RequestValidator(VerifyRegistration::getParams()))
            ->setName(self::ROUTE_VERIFY);
    }

    protected function getTemplatePath()
    {
        return __DIR__."/View";
    }
}