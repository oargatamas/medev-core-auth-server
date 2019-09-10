<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 07. 03.
 * Time: 15:23
 */

namespace MedevAuth\Services\Auth\IdentityProvider\Actions\Login\Type\AuthCode;


use MedevAuth\Services\Auth\IdentityProvider\Actions\Login\Login;
use MedevAuth\Services\Auth\IdentityProvider\IdentityService;
use MedevAuth\Services\Auth\OAuth\Actions\AuthCode\GetAuthCodeData;
use MedevAuth\Services\Auth\OAuth\Actions\AuthCode\RevokeAuthCode;
use MedevAuth\Services\Auth\OAuth\Actions\AuthCode\ValidateAuthCode;
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
        $authCodeId = $request->getParam("code");
        try{
            $authCode = (new GetAuthCodeData($this->service))->handleRequest([AuthCode::IDENTIFIER => $authCodeId]);

            (new ValidateAuthCode($this->service))->handleRequest([AuthCode::IDENTIFIER => $authCode]);

            $_SESSION["user"] = $authCode->getUser();

            (new RevokeAuthCode($this->service))->handleRequest([AuthCode::IDENTIFIER => $authCode]);

        }catch (UnauthorizedException $e){
            $this->error($e->__toString());
            $errorParams = [
                "opened_at" => Login::AUTHCODE,
                "error" => "Invalid or expired code." //Todo integrate it with the localisation framework
            ];
            $loginUrl = $this->router->pathFor(IdentityService::ROUTE_LOGIN,[],$errorParams);
            return $response->withRedirect($loginUrl);
        }

        $authUrl = $this->router->pathFor(OAuthService::ROUTE_AUTHORIZE,[],$_SESSION["AuthParams"]);
        return $response->withRedirect($authUrl);
    }
}