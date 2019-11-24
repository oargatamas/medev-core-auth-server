<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 11. 22.
 * Time: 14:52
 */

namespace MedevAuth\Services\Auth\IdentityProvider;


use MedevAuth\Services\Auth\IdentityProvider\Actions\PasswordRecovery\ChangePasswordRequest;
use MedevAuth\Services\Auth\IdentityProvider\Actions\PasswordRecovery\ForgotPasswordRequest;
use MedevAuth\Services\Auth\IdentityProvider\Actions\PasswordRecovery\RenderChangePassword;
use MedevAuth\Services\Auth\IdentityProvider\Actions\PasswordRecovery\RenderForgotPassword;
use MedevSlim\Core\Action\Middleware\RequestValidator;
use MedevSlim\Core\Service\APIService;
use MedevSlim\Core\Service\View\TwigAPIService;
use Slim\App;

class PasswordRecoveryService extends  TwigAPIService
{
    const ROUTE_FORGOT_PASSWORD_VIEW = "forgotPasswordView";
    const ROUTE_FORGOT_PASSWORD = "forgotPassword";
    const ROUTE_PASSWORD_RECOVERY_VIEW = "passwordRecoveryView";
    const ROUTE_PASSWORD_RECOVERY = "passwordRecovery";
    /**
     * @param App $app
     * @throws \Exception
     */
    protected function registerRoutes(App $app)
    {
        $app->get("/forgot", new RenderForgotPassword($this))
            ->add(new RequestValidator(RenderForgotPassword::getParams()))
            ->setArgument(APIService::SERVICE_ID,$this->getServiceName())
            ->setName(self::ROUTE_FORGOT_PASSWORD_VIEW);

        $app->post("/forgot", new ForgotPasswordRequest($this))
            ->add(new RequestValidator(ForgotPasswordRequest::getParams()))
            ->setArgument(APIService::SERVICE_ID,$this->getServiceName())
            ->setName(self::ROUTE_FORGOT_PASSWORD);

        $app->get("/reset", new RenderChangePassword($this))
            ->add(new RequestValidator(RenderChangePassword::getParams()))
            ->setArgument(APIService::SERVICE_ID,$this->getServiceName())
            ->setName(self::ROUTE_PASSWORD_RECOVERY_VIEW);

        $app->post("/reset", new ChangePasswordRequest($this))
            ->add(new RequestValidator(ChangePasswordRequest::getParams()))
            ->setArgument(APIService::SERVICE_ID,$this->getServiceName())
            ->setName(self::ROUTE_PASSWORD_RECOVERY);
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