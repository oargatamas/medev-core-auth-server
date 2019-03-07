<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 03. 06.
 * Time: 14:18
 */

namespace MedevAuthExample\Sample;


use MedevAuth\Services\Auth\OAuth\APIProtection\Service\OAuthProtectedAPIService;
use MedevAuthExample\Sample\Actions\GetResource;
use MedevSlim\Core\Service\APIService;
use Slim\App;

class ProtectedResourceService extends OAuthProtectedAPIService
{

    /**
     * @return mixed
     */
    public function getServiceName()
    {
        return "ResourceService";
    }

    /**
     * @param App $app
     * @throws \Exception
     */
    protected function registerRoutes(App $app)
    {
        $app->get("/json", new GetResource($this))
            ->setArgument(APIService::SERVICE_ID,$this->getServiceName())
            ->setName("api.get.sample");
    }
}