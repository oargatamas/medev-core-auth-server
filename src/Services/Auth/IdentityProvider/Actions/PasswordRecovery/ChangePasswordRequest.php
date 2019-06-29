<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 06. 28.
 * Time: 9:03
 */

namespace MedevAuth\Services\Auth\IdentityProvider\Actions\PasswordRecovery;


use MedevAuth\Services\Auth\OAuth\Actions\AuthCode\GetAuthCodeData;
use MedevAuth\Services\Auth\OAuth\Actions\AuthCode\ValidateAuthCode;
use MedevAuth\Services\Auth\OAuth\Entity\AuthCode;
use MedevAuth\Services\Auth\OAuth\Entity\User;
use MedevSlim\Core\Action\Servlet\APIServlet;
use Slim\Http\Request;
use Slim\Http\Response;

class ChangePasswordRequest extends APIServlet
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
        (new ValidateAuthCode($this->service))->handleRequest($authParams);

        /** @var User $user */
        $user = $authCode->getUser();

        $validatePws = new ValidatePasswords($this->service);
        $validateParams = $request->getParams(ChangePasswordRequest::getParams());
        $validateParams["user"] = $user;
        $validatePws->handleRequest([$validateParams]);


        $changePw = new ChangePassword($this->service);
        $changeParams = $request->getParams(ChangePasswordRequest::getParams());
        $changePw->handleRequest([$changeParams]);


        $data = [
            "changed" => true
        ];

        return $response
            ->withStatus(201)
            ->withJson($data);
    }

    static function getParams()
    {
        return [
            "newPassword",
            "newPasswordAgain",
            "token"
        ];
    }

}