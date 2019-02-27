<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 26.
 * Time: 17:27
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\GrantType\AccessGrant;


use MedevAuth\Services\Auth\OAuth\Actions\GrantType\Flows;
use MedevSlim\Core\Action\Middleware\RequestValidator;
use MedevSlim\Core\Service\APIService;
use MedevSlim\Core\Service\Exceptions\BadRequestException;
use Slim\Http\Request;
use Slim\Http\Response;

class GrantFlowIdentifier extends RequestValidator
{

    /**
     * @var APIService
     */
    private $service;

    /**
     * @inheritDoc
     */
    public function __construct(APIService $service)
    {
        $this->service = $service;
        parent::__construct([]);
    }


    /**
     * @inheritDoc
     */
    public function __invoke(Request $request, Response $response, callable $next)
    {
        if ($request->getParam("grant_type") == null) {
            throw new BadRequestException("grant_type missing in the request.");
        }

        /** @var GrantAccess $grantFlowHandler */
        $grantFlowHandler = null;
        $grantType = $request->getParam("grant_type");

        switch ($grantType) {
            case "authorization_code" :
                $grantFlowHandler = new Flows\AuthCode\RequestAccessToken($this->service);
                break;
            case "password"           :
                $grantFlowHandler = new Flows\Password\RequestAccessToken($this->service);
                break;
            case "client_credentials" :
                $grantFlowHandler = new Flows\ClientCredentials\RequestAccessToken($this->service);
                break;
            case "refresh_token"      :
                $grantFlowHandler = new Flows\RefreshToken\RequestAccessToken($this->service);
                break;
            default :
                throw new BadRequestException("Invalid/not supported grant type: " . $grantType);
        }

        $this->requiredParams = $grantFlowHandler::getParams();
        $enrichedRequest = $request->withAttribute("GrantFlowHandler",$grantFlowHandler);

        return parent::__invoke($enrichedRequest, $response, $next);
    }


}