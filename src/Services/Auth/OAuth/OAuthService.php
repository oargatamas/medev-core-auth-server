<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 02.
 * Time: 19:21
 */

namespace MedevAuth\Services\Auth\OAuth;


use MedevAuth\Services\Auth\IdentityProvider\IdentityService;
use MedevAuth\Services\Auth\OAuth\Actions\GrantType\AccessGrant\GrantAccessHandler;
use MedevAuth\Services\Auth\OAuth\Actions\GrantType\AccessGrant\GrantFlowIdentifier;
use MedevAuth\Services\Auth\OAuth\Actions\GrantType\Authorization\AuthorizationFlowIdentifier;
use MedevAuth\Services\Auth\OAuth\Actions\GrantType\Authorization\AuthorizationHandler;
use MedevSlim\Core\Application\MedevApp;
use MedevSlim\Core\Service\APIService;
use Slim\App;


class OAuthService extends APIService
{
    const ROUTE_AUTHORIZE = "authorize";
    const ROUTE_TOKEN = "token";

    const AUTH_TOKEN = "auth_token";
    const CSRF_TOKEN = "state";

    public function __construct(MedevApp $app)
    {
        parent::__construct($app);
    }


    /**
     * @return mixed
     */
    public function getServiceName()
    {
        return "AuthorizationService";
    }

    /**
     * @param App $app
     * @throws \Exception
     */
    protected function registerRoutes(App $app)
    {
        //Todo consider to move it to another application
        $idp = new IdentityService($this->application);
        $idp->registerService("/idp");

        $app->get("/authorize", new AuthorizationHandler($this))
            ->add(new AuthorizationFlowIdentifier($this))
            ->setArgument(APIService::SERVICE_ID,$this->getServiceName())
            ->setName(self::ROUTE_AUTHORIZE);

        $app->post("/token", new GrantAccessHandler($this))
            ->add(new GrantFlowIdentifier($this))
            ->setArgument(APIService::SERVICE_ID,$this->getServiceName())
            ->setName(self::ROUTE_TOKEN);
    }
}