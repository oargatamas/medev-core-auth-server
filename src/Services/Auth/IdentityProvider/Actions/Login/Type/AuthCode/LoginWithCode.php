<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 07. 03.
 * Time: 15:23
 */

namespace MedevAuth\Services\Auth\IdentityProvider\Actions\Login\Type\AuthCode;


use MedevAuth\Services\Auth\IdentityProvider\IdentityService;
use MedevAuth\Services\Auth\OAuth\Actions\AuthCode\GetAuthCodeData;
use MedevAuth\Services\Auth\OAuth\Actions\AuthCode\RevokeAuthCode;
use MedevAuth\Services\Auth\OAuth\Actions\AuthCode\ValidateAuthCode;
use MedevAuth\Services\Auth\OAuth\Actions\User\GetUserData;
use MedevAuth\Services\Auth\OAuth\Entity\AuthCode;
use MedevAuth\Services\Auth\OAuth\OAuthService;
use MedevSlim\Core\Action\Servlet\APIServlet;
use MedevSlim\Core\Service\Exceptions\UnauthorizedException;
use Slim\Http\Request;
use Slim\Http\Response;

class LoginWithCode extends APIServlet
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
        $userMail = $request->getParam("username");
        $authCodeId = $request->getParam("code");
        try{
            $authCode = (new GetAuthCodeData($this->service))->handleRequest([AuthCode::IDENTIFIER => $authCodeId]);

            (new ValidateAuthCode($this->service))->handleRequest([AuthCode::IDENTIFIER => $authCode]);

            $user = (new GetUserData($this->service))->handleRequest(["user_id" => $userMail]);

            $_SESSION["user"] = $user;

            (new RevokeAuthCode($this->service))->handleRequest([AuthCode::IDENTIFIER => $authCode]);

        }catch (UnauthorizedException $e){
            $this->error($e->__toString());
            $loginUrl = $this->router->pathFor(IdentityService::ROUTE_LOGIN,[],["error" => IdentityService::ERROR_INVALID_CREDENTIALS]);
            return $response->withRedirect($loginUrl);
        }

        $authUrl = $this->router->pathFor(OAuthService::ROUTE_AUTHORIZE,[],$_SESSION["AuthParams"]);
        return $response->withRedirect($authUrl);
    }
}