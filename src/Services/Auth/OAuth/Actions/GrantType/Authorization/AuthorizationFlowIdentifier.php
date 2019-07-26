<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 27.
 * Time: 14:17
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\GrantType\Authorization;


use MedevAuth\Services\Auth\OAuth\Actions\GrantType\Flows;
use MedevSlim\Core\Action\Middleware\RequestValidator;
use MedevSlim\Core\Service\APIService;
use MedevSlim\Core\Service\Exceptions\BadRequestException;
use Slim\Http\Request;
use Slim\Http\Response;

class AuthorizationFlowIdentifier extends RequestValidator
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
     * @throws \Exception
     */
    public function __invoke(Request $request, Response $response, callable $next)
    {
        if ($request->getParam("response_type") == null) {
            throw new BadRequestException("response_type missing in the request.");
        }

        /** @var Authorization $authFlowHandler */
        $authFlowHandler = null;
        $responseType = $request->getParam("response_type");

        switch ($responseType) {
            case "code" :
                $authFlowHandler = new Flows\AuthCode\AuthorizeRequest($this->service);
                break;
            case "token":
                $authFlowHandler = new Flows\Implicit\AuthorizeRequest($this->service);
                break;
            default :
                throw new BadRequestException("Invalid/not supported response_type: " . $responseType);
        }

        $this->requiredParams = $authFlowHandler::getParams();
        $enrichedRequest = $request->withAttribute("AuthFlowHandler", $authFlowHandler);

        return parent::__invoke($enrichedRequest, $response, $next);
    }
}