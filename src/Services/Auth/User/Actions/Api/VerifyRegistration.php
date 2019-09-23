<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 09. 23.
 * Time: 13:56
 */

namespace MedevAuth\Services\Auth\User\Actions\Api;


use MedevAuth\Services\Auth\IdentityProvider\IdentityService;
use MedevAuth\Services\Auth\OAuth\Actions\AuthCode\GetAuthCodeData;
use MedevAuth\Services\Auth\OAuth\Actions\AuthCode\ValidateAuthCode;
use MedevAuth\Services\Auth\OAuth\Entity\AuthCode;
use MedevAuth\Services\Auth\User\Actions\Repository\Registration\VerifyUser;
use MedevSlim\Core\Action\Servlet\Twig\APITwigServlet;
use Slim\Http\Request;
use Slim\Http\Response;

class VerifyRegistration extends APITwigServlet
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
        /** @var AuthCode $accessToken */
        $authParams = [AuthCode::IDENTIFIER => $request->getParam("token")];
        $authCode = (new GetAuthCodeData($this->service))->handleRequest($authParams);
        (new ValidateAuthCode($this->service))->handleRequest([AuthCode::IDENTIFIER => $authCode]);


        (new VerifyUser($this->service))->handleRequest([
            VerifyUser::USER_INFO => $authCode->getUser()
        ]);

        $params=[
            "message" => "User verified. You can sign in now."
        ];

        $loginUrl = $this->router->pathFor(IdentityService::ROUTE_LOGIN,[],$params);

        return $response->withRedirect($loginUrl,301);
    }

    static function getParams()
    {
        return ["token"];
    }

}