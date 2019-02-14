<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 13.
 * Time: 16:15
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\GrantType;



use Slim\Http\Request;
use Slim\Http\Response;

class RefreshTokenGrant extends GrantType
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