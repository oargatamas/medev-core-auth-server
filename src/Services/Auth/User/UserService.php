<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 08. 19.
 * Time: 15:42
 */

namespace MedevAuth\Services\Auth\User;

use MedevAuth\Services\Auth\OAuth\APIProtection\Middleware\OAuthAPIProtector;
use MedevAuth\Services\Auth\User\Actions\Api\UserInfo;
use MedevAuth\Services\Auth\User\Actions\Api\UserRegistration;
use MedevAuth\Services\Auth\User\Actions\Api\VerifyRegistration;
use MedevSlim\Core\Action\Middleware\ReCaptchaValidator;
use MedevSlim\Core\Action\Middleware\RequestValidator;
use MedevSlim\Core\Action\Middleware\ScopeValidator;
use MedevSlim\Core\Application\MedevApp;
use MedevSlim\Core\Service\APIService;
use MedevSlim\Core\Service\View\TwigAPIService;
use Slim\App;

class UserService extends TwigAPIService
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
        $service = $this;

        /** @var MedevApp $app */
        $app->group("/",function () use ($app,$service){
            $app->get("/info", new UserInfo($service))
                ->setArgument(APIService::SERVICE_ID,$service->getServiceName())
                ->setName(self::ROUTE_USER_INFO);

            $app->post("/register", new UserRegistration($service))
                ->setArgument(APIService::SERVICE_ID,$service->getServiceName())
                ->add(new ReCaptchaValidator($app))
                ->add(new RequestValidator(UserRegistration::getParams()))
                ->add(new ScopeValidator(UserRegistration::getScopes()))
                ->setName(self::ROUTE_REGISTER);
        })->add(new OAuthAPIProtector($this));


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