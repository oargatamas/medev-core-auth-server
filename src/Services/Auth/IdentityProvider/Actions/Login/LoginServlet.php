<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 18.
 * Time: 15:02
 */

namespace MedevAuth\Services\Auth\IdentityProvider\Actions\Login;


use MedevAuth\Services\Auth\IdentityProvider\IdentityService;
use MedevAuth\Services\Auth\OAuth\Actions\User\ValidateUser;
use MedevAuth\Services\Auth\OAuth\Entity\User;
use MedevAuth\Services\Auth\OAuth\OAuthService;
use MedevSlim\Core\Action\Servlet\APIServlet;
use MedevSlim\Core\Service\Exceptions\UnauthorizedException;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class LoginServlet extends APIServlet
{

    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return ResponseInterface
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
            $userId = $validateAction->handleRequest($userInfo);

            $user = new User();
            $user->setUsername($request->getParam("username"));
            $user->setIdentifier($userId);

            $_SESSION["user"] = $user;

        }catch (UnauthorizedException $e){
            $this->error($e->__toString());
            $loginUrl = $this->router->pathFor(IdentityService::ROUTE_LOGIN,[],["error" => IdentityService::ERROR_INVALID_CREDENTIALS]);
            return $response->withRedirect($loginUrl);
        }

        $authUrl = $this->router->pathFor(OAuthService::ROUTE_AUTHORIZE,[],$_SESSION["AuthParams"]);
        return $response->withRedirect($authUrl);
    }

    /**
     * @inheritDoc
     */
    static function getParams()
    {
        return [
            //Todo add state for csrf protection
        ];
    }


}