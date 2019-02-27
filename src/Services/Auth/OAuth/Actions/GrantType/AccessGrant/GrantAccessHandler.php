<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 24.
 * Time: 19:31
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\GrantType\AccessGrant;


use MedevAuth\Services\Auth\OAuth\Actions\GrantType\Flows;
use MedevSlim\Core\Action\Servlet\APIServlet;
use Slim\Http\Request;
use Slim\Http\Response;

class GrantAccessHandler extends APIServlet
{

    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return Response
     * @throws \Exception
     */
    public function handleRequest(Request $request, Response $response, $args)
    {
        /** @var GrantAccess $grantTypeHandler */
        $grantTypeHandler = $request->getAttribute("GrantFlowHandler"); //Todo move to constant

        return $grantTypeHandler($request,$response,$args);
    }
}