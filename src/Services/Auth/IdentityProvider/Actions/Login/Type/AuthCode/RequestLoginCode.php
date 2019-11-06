<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 07. 04.
 * Time: 10:58
 */

namespace MedevAuth\Services\Auth\IdentityProvider\Actions\Login\Type\AuthCode;


use MedevAuth\Services\Auth\OAuth\Actions\AuthCode\GenerateAuthCode;
use MedevAuth\Services\Auth\OAuth\Actions\AuthCode\PersistAuthCode;
use MedevAuth\Services\Auth\OAuth\Actions\Client\GetClientData;
use MedevAuth\Services\Auth\OAuth\Actions\User\GetUserData;
use MedevAuth\Services\Auth\OAuth\Entity\AuthCode;
use MedevSlim\Core\Action\Servlet\APIServlet;
use Slim\Http\Request;
use Slim\Http\Response;

class RequestLoginCode extends APIServlet
{

    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return Response
     * @throws \MedevSlim\Core\Service\Exceptions\UnauthorizedException
     * @throws \Exception
     */
    public function handleRequest(Request $request, Response $response, $args)
    {
        $getUser = new GetUserData($this->service);
        $getClient = new GetClientData($this->service);

        $codeParams = [
            AuthCode::USER => $getUser->handleRequest(["user_id" => $request->getParam("usermail")]),  // Todo move to constant
            AuthCode::CLIENT => $getClient->handleRequest(["client_id" => "hu.medev.auth"]),                // Todo move to constant
            AuthCode::REDIRECT_URI => $_SESSION["AuthParams"]["redirect_uri"] ?? null,
            AuthCode::EXPIRATION => 600
        ];
        $authCode  = (new GenerateAuthCode($this->service))->handleRequest($codeParams);

        (new PersistAuthCode($this->service))->handleRequest([AuthCode::IDENTIFIER => $authCode]);
        (new SendLoginCodeInMail($this->service))->handleRequest([AuthCode::IDENTIFIER => $authCode]);



        return $response
            ->withStatus(201)
            ->withJson("Verification code sent to the mail"); // Todo move to localization string
    }

}