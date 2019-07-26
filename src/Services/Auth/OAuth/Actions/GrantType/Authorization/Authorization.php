<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 25.
 * Time: 9:05
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\GrantType\Authorization;


use MedevAuth\Services\Auth\IdentityProvider\IdentityService;
use MedevAuth\Services\Auth\OAuth\Actions\Client\GetClientData;
use MedevAuth\Services\Auth\OAuth\Actions\GrantType\OAuthRequest;
use MedevSlim\Core\Application\MedevApp;
use MedevSlim\Core\Service\APIService;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Interfaces\RouterInterface;

/**
 * Class Authorization
 * @package MedevAuth\Services\Auth\OAuth\Actions\GrantType\Authorization
 */
abstract class Authorization extends OAuthRequest
{
    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @inheritDoc
     */
    public function __construct(APIService $service)
    {
        $this->router = $service->getContainer()->get(MedevApp::ROUTER);
        parent::__construct($service);
    }


    /**
     * @inheritDoc
     * @throws \Exception
     */
    public function handleRequest(Request $request, Response $response, $args)
    {

        $clientDataAction = new GetClientData($this->service);

        $this->client = $clientDataAction->handleRequest(["client_id" => $request->getParam("client_id")]);
        $this->csrfToken = $request->getParam("state");


        $this->info("Checking user login state.");
        if($this->isLoginRequired($request,$args)){
            $this->info("End-User not logged in. Redirecting to identity provider.");
            $_SESSION["AuthParams"] = $request->getParams();
            return $response->withRedirect($this->router->pathFor(IdentityService::ROUTE_LOGIN,[],[]));
        }

        $this->info("End-User logged in as ".$this->user->getUsername());

        $this->verifyClient($request,$args);

        if($this->isPermissionRequired($request,$args)){
            $this->info("Permmissions required for client ".$this->client->getIdentifier());
            return $response->withRedirect("/authorization/permission");
        }


        return $this->buildSuccessResponse($response,$args);
    }


    public abstract function isLoginRequired(Request $request, $args);

    public abstract function isPermissionRequired(Request $request, $args);

    public abstract function verifyClient(Request $request, $args);

    public abstract function buildSuccessResponse(Response $response, $args);

    /**
     * @inheritDoc
     */
    static function getParams()
    {
        return [
            "response_type",
            "client_id",
            "redirect_uri",
            "state"
        ];
    }


}