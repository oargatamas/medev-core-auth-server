<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 13.
 * Time: 16:18
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\GrantType;


use MedevSlim\Core\Action\Servlet\APIServletAction;
use Slim\Http\Request;
use Slim\Http\Response;


//Todo improve it to extend from the Authorization Grant without secret.
class ImplicitGrant extends GrantType
{

    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return Response
     */
    public function handleRequest(Request $request, Response $response, $args)
    {
        return $response;
    }
}