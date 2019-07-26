<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 18.
 * Time: 15:00
 */

namespace MedevAuth\Services\Auth\IdentityProvider;


use MedevAuth\Services\Auth\IdentityProvider\Actions\Login\Login;
use MedevAuth\Services\Auth\IdentityProvider\Actions\Login\RenderLoginView;
use MedevAuth\Services\Auth\IdentityProvider\Actions\Login\Type\AuthCode\RequestLoginCode;
use MedevAuth\Services\Auth\IdentityProvider\Actions\Logout\Logout;
use MedevAuth\Services\Auth\IdentityProvider\Actions\Logout\RenderLogoutView;
use MedevAuth\Services\Auth\IdentityProvider\Actions\PasswordRecovery\ChangePasswordRequest;
use MedevAuth\Services\Auth\IdentityProvider\Actions\PasswordRecovery\ForgotPasswordRequest;
use MedevAuth\Services\Auth\IdentityProvider\Actions\PasswordRecovery\RenderChangePassword;
use MedevAuth\Services\Auth\IdentityProvider\Actions\PasswordRecovery\RenderForgotPassword;
use MedevSlim\Core\Action\Middleware\RequestValidator;
use MedevSlim\Core\Application\MedevApp;
use MedevSlim\Core\Service\APIService;
use MedevSlim\Core\Service\View\TwigAPIService;
use Slim\App;

class IdentityService extends TwigAPIService
{
    const ID_TOKEN_REQUEST_KEY = "X-MEDEV-ID-TOKEN";

    const ROUTE_LOGIN = "login";
    const ROUTE_LOGIN_CODE = "logincode";
    const ROUTE_LOGOUT = "logout";
    const ROUTE_REGISTER = "register";
    const ROUTE_FORGOT_PASSWORD = "forgot";
    const ROUTE_PASSWORD_RECOVERY = "recovery";

    const ERROR_INVALID_CREDENTIALS = 0;
    const ERROR_NO_REDIRECT_URI = 1;
    const ERROR_INVALID_STATE = 2;

    public function __construct(MedevApp $app)
    {
        parent::__construct($app);
    }


    /**
     * @return mixed
     */
    public function getServiceName()
    {
        return "IdentityService";
    }

    /**
     * @param App $app
     * @throws \Exception
     */
    protected function registerRoutes(App $app)
    {
        $app->get("/", new RenderLoginView($this))
            ->setArgument(APIService::SERVICE_ID,$this->getServiceName())
            ->setName("idp");

        $app->get("/login",new RenderLoginView($this))
            ->setArgument(APIService::SERVICE_ID,$this->getServiceName())
            ->setName(self::ROUTE_LOGIN);

        $app->post("/login",new Login($this))
            ->add(new RequestValidator(Login::getParams()))
            ->setArgument(APIService::SERVICE_ID,$this->getServiceName())
            ->setName(self::ROUTE_LOGIN.".post");

        $app->post("/login/code",new RequestLoginCode($this))
            ->add(new RequestValidator(RequestLoginCode::getParams()))
            ->setArgument(APIService::SERVICE_ID,$this->getServiceName())
            ->setName(self::ROUTE_LOGIN_CODE);

        $app->get("/logout", new RenderLogoutView($this))
            ->setArgument(APIService::SERVICE_ID,$this->getServiceName())
            ->setName(self::ROUTE_LOGOUT);

        $app->post("/logout", new Logout($this))
            ->add(new RequestValidator(Logout::getParams()))
            ->setArgument(APIService::SERVICE_ID,$this->getServiceName())
            ->setName(self::ROUTE_LOGOUT.".post");

        $app->get("/pw/forgot", new RenderForgotPassword($this))
            ->add(new RequestValidator(RenderForgotPassword::getParams()))
            ->setArgument(APIService::SERVICE_ID,$this->getServiceName())
            ->setName(self::ROUTE_FORGOT_PASSWORD);

        $app->post("/pw/forgot", new ForgotPasswordRequest($this))
            ->add(new RequestValidator(ForgotPasswordRequest::getParams()))
            ->setArgument(APIService::SERVICE_ID,$this->getServiceName())
            ->setName(self::ROUTE_FORGOT_PASSWORD.".post");

        $app->get("/pw/reset", new RenderChangePassword($this))
            ->add(new RequestValidator(RenderChangePassword::getParams()))
            ->setArgument(APIService::SERVICE_ID,$this->getServiceName())
            ->setName(self::ROUTE_PASSWORD_RECOVERY);

        $app->post("/pw/reset", new ChangePasswordRequest($this))
            ->add(new RequestValidator(ChangePasswordRequest::getParams()))
            ->setArgument(APIService::SERVICE_ID,$this->getServiceName())
            ->setName(self::ROUTE_PASSWORD_RECOVERY.".post");
    }



    protected function getTemplatePath()
    {
        return __DIR__."/View";
    }
}