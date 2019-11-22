<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 07. 03.
 * Time: 15:25
 */

namespace MedevAuth\Services\Auth\IdentityProvider\Actions\Login\Type\Password;


use MedevAuth\Services\Auth\IdentityProvider\Actions\Login\Login;
use MedevAuth\Services\Auth\IdentityProvider\PasswordLoginService;
use MedevAuth\Services\Auth\OAuth\Actions\User\ValidateUser;
use MedevAuth\Services\Auth\OAuth\OAuthService;
use MedevSlim\Core\Action\Servlet\APIServlet;
use MedevSlim\Core\Service\Exceptions\UnauthorizedException;
use Slim\Http\Request;
use Slim\Http\Response;

class LoginWithPassword extends APIServlet
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
        $userInfo = [
            "username" => $request->getParam("username"),
            "password" => $request->getParam("password")
        ];

        try{
            $validateAction = new ValidateUser($this->service);
            $user = $validateAction->handleRequest($userInfo);

            $_SESSION["user"] = $user;

        }catch (UnauthorizedException $e){
            $this->error($e->__toString());
            $errorParams = [
                "error" => "Invalid username or password." //Todo integrate it with the localisation framework
            ];
            $loginUrl = $this->router->pathFor(PasswordLoginService::ROUTE_LOGIN_VIEW,[],$errorParams);
            return $response->withRedirect($loginUrl);
        }

        $authUrl = $this->router->pathFor(OAuthService::ROUTE_AUTHORIZE,[],$_SESSION["AuthParams"]);
        return $response->withRedirect($authUrl);
    }
}