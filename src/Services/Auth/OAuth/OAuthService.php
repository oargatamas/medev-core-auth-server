<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 02.
 * Time: 19:21
 */

namespace MedevAuth\Services\Auth\OAuth;



use MedevAuth\Services\Auth\IdentityProvider\IdentityService;
use MedevAuth\Services\Auth\OAuth\Actions\GrantType\AuthorizationHandler;
use MedevAuth\Services\Auth\OAuth\Actions\GrantType\GrantAccessHandler;
use MedevSlim\Core\Service\APIService;
use Slim\App;


class OAuthService extends APIService
{


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

        $app->post("/authorize", new AuthorizationHandler($this));
        $app->post("/token",new GrantAccessHandler($this));
    }
}