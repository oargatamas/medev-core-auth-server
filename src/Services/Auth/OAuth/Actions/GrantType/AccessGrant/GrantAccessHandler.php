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
use MedevSlim\Core\Service\Exceptions\BadRequestException;
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
        $grantType = $request->getParam("grant_type");
        $grantTypeHandler = $this->getTokenHandler($grantType);

        return $grantTypeHandler($request,$response,$args);
    }

    /**
     * @param $grantType
     * @return GrantAccess
     * @throws \Exception
     */
    private function getTokenHandler($grantType){
        switch ($grantType){
            case "authorization_code" : return new Flows\AuthCode\RequestAccessToken($this->service);
            case "password" : return new Flows\Password\RequestAccessToken($this->service);
            case "client_credentials" : return new Flows\ClientCredentials\RequestAccessToken($this->service);
            case "refresh_token" : return new Flows\RefreshToken\RequestAccessToken($this->service);
            default : throw new BadRequestException("Invalid/not supported grant type: ".$grantType);
        }
    }

    static function getParams()
    {
        return [
            "grant_type"
        ];
    }


}