<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 11. 22.
 * Time: 14:55
 */

namespace MedevAuth\Services\Auth\IdentityProvider;


use MedevAuth\Services\Auth\IdentityProvider\Actions\Login\Type\AuthCode\LoginWithCode;
use MedevAuth\Services\Auth\IdentityProvider\Actions\Login\Type\AuthCode\RenderAuthCodeLogin;
use MedevAuth\Services\Auth\IdentityProvider\Actions\Login\Type\AuthCode\RequestLoginCode;
use MedevSlim\Core\Service\APIService;
use MedevSlim\Core\Service\View\TwigAPIService;
use Slim\App;

class AuthCodeLoginService extends TwigAPIService
{
    const ROUTE_LOGIN_VIEW = "authCodeLoginView";
    const ROUTE_LOGIN = "authCodeLogin";
    const ROUTE_CODE_REQUEST  = "authCodeRequest";


    /**
     * @param App $app
     * @throws \Exception
     */
    protected function registerRoutes(App $app)
    {
        $app->get("[/]",new RenderAuthCodeLogin($this))
            ->setArgument(APIService::SERVICE_ID,$this->getServiceName())
            ->setName(self::ROUTE_LOGIN_VIEW);

        $app->post("[/]", new LoginWithCode($this))
            ->setArgument(APIService::SERVICE_ID,$this->getServiceName())
            ->setName(self::ROUTE_LOGIN);

        $app->post("/request", new RequestLoginCode($this))
            ->setArgument(APIService::SERVICE_ID,$this->getServiceName())
            ->setName(self::ROUTE_CODE_REQUEST);
    }

    protected function getTemplatePath()
    {
        return __DIR__."/View";
    }

    public function getServiceName()
    {
        $array = explode('\\', IdentityService::class);
        return end($array);
    }
}