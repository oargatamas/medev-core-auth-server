<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 18.
 * Time: 15:00
 */

namespace MedevAuth\Services\Auth\IdentityProvider;

use MedevAuth\Services\Auth\IdentityProvider\Actions\Logout\Logout;
use MedevAuth\Services\Auth\IdentityProvider\Actions\Logout\RenderLogoutView;
use MedevSlim\Core\Action\Middleware\RequestValidator;
use MedevSlim\Core\Application\MedevApp;
use MedevSlim\Core\Service\APIService;
use MedevSlim\Core\Service\View\TwigAPIService;
use Slim\App;

class IdentityService extends TwigAPIService
{
    const ID_TOKEN_REQUEST_KEY = "X-MEDEV-ID-TOKEN";

    const ROUTE_LOGOUT_VIEW = "logoutView";
    const ROUTE_LOGOUT = "logout";

    const ERROR_INVALID_CREDENTIALS = 0;
    const ERROR_NO_REDIRECT_URI = 1;
    const ERROR_INVALID_STATE = 2;

    public function __construct(MedevApp $app)
    {
        parent::__construct($app);
    }


    /**
     * @param App $app
     * @throws \Exception
     */
    protected function registerRoutes(App $app)
    {
        $passwordLoginService = new PasswordLoginService($this->application);
        $passwordLoginService->registerService("/login");

        $authCodeLoginService = new AuthCodeLoginService($this->application);
        $authCodeLoginService->registerService("/login/code");

        $passwordRecoveryService = new PasswordRecoveryService($this->application);
        $passwordRecoveryService->registerService("/pw");

        $app->get("/logout", new RenderLogoutView($this))
            ->setArgument(APIService::SERVICE_ID,$this->getServiceName())
            ->setName(self::ROUTE_LOGOUT_VIEW);

        $app->post("/logout", new Logout($this))
            ->add(new RequestValidator(Logout::getParams()))
            ->setArgument(APIService::SERVICE_ID,$this->getServiceName())
            ->setName(self::ROUTE_LOGOUT);
    }



    protected function getTemplatePath()
    {
        return __DIR__."/View";
    }
}