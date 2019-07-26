<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 14.
 * Time: 11:03
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\Token;


use MedevAuth\Services\Auth\OAuth\Actions\Token\AccessToken\RevokeAccessToken;
use MedevAuth\Services\Auth\OAuth\Actions\Token\RefreshToken\RevokeRefreshToken;
use MedevSlim\Core\Action\Servlet\APIServlet;
use Slim\Http\Request;
use Slim\Http\Response;

class RevokeTokenServlet extends APIServlet
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
        //Todo token type determination ugly. Fix it!!!
        //Todo add log entries
        $tokenId = $args["token_id"]; //Todo move to constant

        $revoke = new RevokeRefreshToken($this->service);

        if($revoke->handleRequest($args) <= 0){
            $revoke = new RevokeAccessToken($this->service);
            $revoke->handleRequest($args);
        }

        return $response->withJson("Token ".$tokenId." revoked successfully",200);
    }
}