<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 06. 28.
 * Time: 10:20
 */

namespace MedevAuth\Services\Auth\IdentityProvider\Actions\PasswordRecovery;


use MedevAuth\Services\Auth\OAuth\Actions\AuthCode\GenerateAuthCode;
use MedevAuth\Services\Auth\OAuth\Actions\Client\GetClientData;
use MedevAuth\Services\Auth\OAuth\Actions\User\GetUserData;
use MedevAuth\Services\Auth\OAuth\Entity\AuthCode;
use MedevSlim\Core\Action\Servlet\Twig\APITwigServlet;
use Slim\Http\Request;
use Slim\Http\Response;

class ForgotPasswordRequest extends APITwigServlet
{

    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return \Psr\Http\Message\ResponseInterface|Response
     * @throws \Exception
     */
    public function handleRequest(Request $request, Response $response, $args)
    {
        $getUser = new GetUserData($this->service);
        $getClient = new GetClientData($this->service);

        $tokenParams = [
            AuthCode::USER => $getUser->handleRequest(["user_id" => $request->getParam("user")]),
            AuthCode::CLIENT => $getClient->handleRequest(["client_id" => "hu.medev.auth"]),
            AuthCode::EXPIRATION => 600
        ];

        $authCode = (new GenerateAuthCode($this->service))->handleRequest($tokenParams);

        (new SendForgotPasswordMail($this->service))->handleRequest([AuthCode::IDENTIFIER => $authCode]);


        return $this->render($response,"PasswordNotificationSent.twig",[]);
    }

    static function getParams()
    {
        return [
            "user"
        ];
    }


}