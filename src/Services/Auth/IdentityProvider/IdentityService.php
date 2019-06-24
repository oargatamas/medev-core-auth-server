<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 18.
 * Time: 15:00
 */

namespace MedevAuth\Services\Auth\IdentityProvider;


use MedevAuth\Services\Auth\IdentityProvider\Actions\Login\LoginServlet;
use MedevAuth\Services\Auth\IdentityProvider\Actions\Login\RenderLoginView;
use MedevAuth\Services\Auth\IdentityProvider\Actions\Logout\LogoutServlet;
use MedevAuth\Services\Auth\IdentityProvider\Actions\Logout\RenderLogoutView;
use MedevAuth\Services\Auth\IdentityProvider\Actions\PasswordForgot\ForgotPasswordServlet;
use MedevAuth\Services\Auth\IdentityProvider\Actions\PasswordForgot\RenderForgotPasswordView;
use MedevAuth\Services\Auth\IdentityProvider\Actions\Register\RegisterServlet;
use MedevAuth\Services\Auth\IdentityProvider\Actions\Register\RenderRegisterView;
use MedevSlim\Core\Action\Middleware\RequestValidator;
use MedevSlim\Core\Application\MedevApp;
use MedevSlim\Core\Service\APIService;
use MedevSlim\Core\Service\View\TwigAPIService;
use Slim\App;

class IdentityService extends TwigAPIService
{
    const ID_TOKEN_REQUEST_KEY = "X-MEDEV-ID-TOKEN";

    const ROUTE_LOGIN = "login";
    const ROUTE_LOGOUT = "logout";
    const ROUTE_REGISTER = "register";
    const ROUTE_FORGOT_PASSWORD = "forgot";

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

        $app->post("/login",new LoginServlet($this))
            ->add(new RequestValidator(LoginServlet::getParams()))
            ->setArgument(APIService::SERVICE_ID,$this->getServiceName())
            ->setName(self::ROUTE_LOGIN.".post");

        $app->get("/logout", new RenderLogoutView($this))
            ->setArgument(APIService::SERVICE_ID,$this->getServiceName())
            ->setName(self::ROUTE_LOGOUT);

        $app->post("/logout", new LogoutServlet($this))
            ->add(new RequestValidator(LogoutServlet::getParams()))
            ->setArgument(APIService::SERVICE_ID,$this->getServiceName())
            ->setName(self::ROUTE_LOGOUT.".post");

        $app->get("/register", new RenderRegisterView($this))
            ->setArgument(APIService::SERVICE_ID,$this->getServiceName())
            ->setName(self::ROUTE_REGISTER);

        $app->post("/register", new RegisterServlet($this))
            ->add(new RequestValidator(RegisterServlet::getParams()))
            ->setArgument(APIService::SERVICE_ID,$this->getServiceName())
            ->setName(self::ROUTE_REGISTER.".post");

        $app->get("/forgot", new RenderForgotPasswordView($this))
            ->setArgument(APIService::SERVICE_ID,$this->getServiceName())
            ->setName(self::ROUTE_FORGOT_PASSWORD);

        $app->post("/forgot", new ForgotPasswordServlet($this))
            ->add(new RequestValidator(ForgotPasswordServlet::getParams()))
            ->setArgument(APIService::SERVICE_ID,$this->getServiceName())
            ->setName(self::ROUTE_FORGOT_PASSWORD.".post");
    }



    protected function getTemplatePath()
    {
        return __DIR__."/View";
    }
}