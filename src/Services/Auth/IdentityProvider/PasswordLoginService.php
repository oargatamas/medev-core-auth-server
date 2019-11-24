<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 11. 22.
 * Time: 14:55
 */

namespace MedevAuth\Services\Auth\IdentityProvider;


use MedevAuth\Services\Auth\IdentityProvider\Actions\Login\LoginTypes;
use MedevAuth\Services\Auth\IdentityProvider\Actions\Login\LoginTypeValidator;
use MedevAuth\Services\Auth\IdentityProvider\Actions\Login\Type\Password\LoginWithPassword;
use MedevAuth\Services\Auth\IdentityProvider\Actions\Login\Type\Password\RenderPasswordLogin;
use MedevSlim\Core\Service\APIService;
use MedevSlim\Core\Service\View\TwigAPIService;
use Slim\App;

class PasswordLoginService extends TwigAPIService
{
    const ROUTE_LOGIN_VIEW = "passwordLoginView";
    const ROUTE_LOGIN = "passwordLogin";

    /**
     * @param App $app
     * @throws \Exception
     */
    protected function registerRoutes(App $app)
    {
        $app->get("[/]", new RenderPasswordLogin($this))
            ->setArgument(APIService::SERVICE_ID,$this->getServiceName())
            ->setName(self::ROUTE_LOGIN_VIEW);

        $app->post("[/]", new LoginWithPassword($this))
            ->add(new LoginTypeValidator($this,LoginTypes::PASSWORD))
            ->setArgument(APIService::SERVICE_ID,$this->getServiceName())
            ->setName(self::ROUTE_LOGIN);
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