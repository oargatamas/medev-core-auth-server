<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 06. 28.
 * Time: 9:03
 */

namespace MedevAuth\Services\Auth\IdentityProvider\Actions\PasswordRecovery;


use MedevAuth\Services\Auth\OAuth\Entity\Token\JWT\Signed\OAuthJWS;
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
        /** @var OAuthJWS $accessToken */
        $accessToken = $args["token"];
        /** @var User $user */
        $user = $accessToken->getUser();

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
            "newPasswordAgain"
        ];
    }


    static function getScopes()
    {
        return [
            "update:userpw"
        ];
    }


}