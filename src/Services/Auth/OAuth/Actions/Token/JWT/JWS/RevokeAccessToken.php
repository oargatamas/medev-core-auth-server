<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 13.
 * Time: 16:48
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\Token\JWT\JWS;


use MedevSlim\Core\Action\Servlet\APIServletAction;
use Slim\Http\Request;
use Slim\Http\Response;

class RevokeAccessToken extends APIServletAction
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