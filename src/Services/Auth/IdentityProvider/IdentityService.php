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
use MedevSlim\Core\Service\View\TwigAPIService;
use Psr\Container\ContainerInterface;
use Slim\App;

class IdentityService extends TwigAPIService
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
     * @throws \Exception
     */
    protected function registerRoutes(App $app)
    {
        $app->get("/login",new RenderLoginView($this))->setName($this->getServiceName());
        $app->post("/login",new LoginServlet($this))->setName($this->getServiceName());

        $app->get("/logout", new RenderLogoutView($this))->setName($this->getServiceName());
        $app->post("/logout", new LogoutServlet($this))->setName($this->getServiceName());

        $app->get("/register", new RenderRegisterView($this))->setName($this->getServiceName());
        $app->post("/register", new RegisterServlet($this))->setName($this->getServiceName());

        $app->get("/forgot", new RenderForgotPasswordView($this))->setName($this->getServiceName());
        $app->post("/forgot", new ForgotPasswordServlet($this))->setName($this->getServiceName());
    }

    protected function registerContainerComponents(ContainerInterface $container)
    {
        parent::registerContainerComponents($container);
    }


}