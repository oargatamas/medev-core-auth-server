<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 03. 06.
 * Time: 14:19
 */

namespace MedevAuthExample\Sample\Actions;


use MedevAuth\Services\Auth\OAuth\Entity\Token\OAuthToken;
use MedevAuth\Services\Auth\OAuth\OAuthService;
use MedevSlim\Core\Action\Servlet\APIServlet;
use Slim\Http\Request;
use Slim\Http\Response;

class GetResource extends APIServlet
{

    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return Response
     */
    public function handleRequest(Request $request, Response $response, $args)
    {
        /** @var OAuthToken $authToken */
        $authToken = $request->getAttribute(OAuthService::AUTH_TOKEN);

        $data = [
            "status" => "success",
            "message" => "megy ez!",
            "user" => $authToken->getUser(),
            "client" => $authToken->getClient(),
            "scopes" => $authToken->getScopes()
        ];

        return $response->withJson($data,200);
    }
}