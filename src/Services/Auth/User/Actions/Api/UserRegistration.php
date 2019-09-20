<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 09. 20.
 * Time: 15:46
 */

namespace MedevAuth\Services\Auth\User\Actions\Api;


use MedevAuth\Services\Auth\OAuth\Entity\Token\OAuthToken;
use MedevAuth\Services\Auth\OAuth\Entity\User;
use MedevAuth\Services\Auth\OAuth\OAuthService;
use MedevAuth\Services\Auth\User\Actions\Repository\AddUser;
use MedevAuth\Services\Auth\User\UserServiceScopes;
use MedevSlim\Core\Action\Servlet\APIServlet;
use Slim\Http\Request;
use Slim\Http\Response;

class UserRegistration extends APIServlet
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
        /** @var OAuthToken $authToken */
        $authToken = $request->getAttribute(OAuthService::AUTH_TOKEN);

        $user = new User();

        $user->setUsername($request->getParam("username"));
        $user->setEmail($request->getParam("email"));
        $user->setFirstName($request->getParam("firstname"));
        $user->setLastName($request->getParam("lastname"));
        $user->setVerified(false);
        $user->setDisabled(true);

        (new AddUser($this->service))->handleRequest([
            AddUser::USER_INFO => $user,
            AddUser::PASSWORD => $request->getParam("password")
        ]);

        return $response->withJson("User ".$user->getUsername()." registered.",201);
    }

    static function getScopes()
    {
        return [
            UserServiceScopes::USER_REGISTRATION
        ];
    }

    static function getParams()
    {
        return [
            "username",
            "email",
            "firstname",
            "lastname",
            "password",
            "recaptcha",
        ];
    }


}