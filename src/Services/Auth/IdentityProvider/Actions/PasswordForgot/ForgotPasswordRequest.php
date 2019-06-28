<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 06. 28.
 * Time: 10:20
 */

namespace MedevAuth\Services\Auth\IdentityProvider\Actions\PasswordForgot;


use MedevAuth\Services\Auth\OAuth\Actions\Client\GetClientData;
use MedevAuth\Services\Auth\OAuth\Actions\Token\AccessToken\GenerateAccessToken;
use MedevAuth\Services\Auth\OAuth\Actions\User\GetUserData;
use MedevAuth\Services\Auth\OAuth\Entity\Token\OAuthToken;
use MedevSlim\Core\Action\Servlet\APIServlet;
use Slim\Http\Request;
use Slim\Http\Response;

class ForgotPasswordRequest extends APIServlet
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
        $getUser = new GetUserData($this->service);
        $getClient = new GetClientData($this->service);

        $tokenParams = [
            OAuthToken::USER => $getUser->handleRequest(["user_id" => $request->getParam("user")]),
            OAuthToken::CLIENT => $getClient->handleRequest(["client_id" => "hu.medev.auth"]),
            OAuthToken::EXPIRATION => 600,
            OAuthToken::SCOPES => ChangePasswordRequest::getScopes()
        ];

        $accessToken = (new GenerateAccessToken($this->service))->handleRequest($tokenParams);



        return $response;
    }

    static function getParams()
    {
        return [
            "user"
        ];
    }


}