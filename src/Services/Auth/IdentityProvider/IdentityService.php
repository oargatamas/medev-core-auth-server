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
use MedevSlim\Core\Service\APIService;
use Slim\App;

class IdentityService extends APIService
{

    /**
     * @return mixed
     */
    public function getServiceName()
    {
        return "IdentityService";
    }

    /**
     * @param App $app
     */
    protected function registerRoutes(App $app)
    {
        $app->get("/login",new RenderLoginView($this));
        $app->post("/login",new LoginServlet($this));

        $app->get("/logout", new RenderLogoutView($this));
        $app->post("/logout", new LogoutServlet($this));

        $app->get("/register", new RenderRegisterView($this));
        $app->post("/register", new RegisterServlet($this));

        $app->get("/forgot", new RenderForgotPasswordView($this));
        $app->post("/forgot", new ForgotPasswordServlet($this));
    }
}