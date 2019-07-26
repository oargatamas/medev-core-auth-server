<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 25.
 * Time: 8:58
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\GrantType\Authorization;


use MedevAuth\Services\Auth\OAuth\Actions\GrantType\Flows;
use MedevSlim\Core\Action\Servlet\APIServlet;
use Slim\Http\Request;
use Slim\Http\Response;

class AuthorizationHandler extends APIServlet
{
    /**
     * @inheritDoc
     */
    public function handleRequest(Request $request, Response $response, $args)
    {
        /** @var Authorization $authHandler */
        $authHandler = $request->getAttribute("AuthFlowHandler"); //Todo move to constant

        return $authHandler($request,$response,$args);
    }

}