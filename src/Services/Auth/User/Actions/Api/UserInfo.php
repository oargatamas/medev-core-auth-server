<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 08. 19.
 * Time: 15:46
 */

namespace MedevAuth\Services\Auth\User\Actions\Api;


use MedevAuth\Services\Auth\OAuth\Entity\Token\OAuthToken;
use MedevAuth\Services\Auth\OAuth\OAuthService;
use MedevAuth\Services\Auth\User\Actions\Repository\GetUserInfo;
use MedevSlim\Core\Action\Servlet\APIServlet;
use Slim\Http\Request;
use Slim\Http\Response;

class UserInfo extends APIServlet
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
        $getUsers = new GetUserInfo($this->service);

        $data = $getUsers->handleRequest();

        foreach ($data as $user){
            $user->setLoggedIn($user->getIdentifier() === $authToken->getUser()->getIdentifier());
        }

        return $response->withJson($data,200);
    }
}