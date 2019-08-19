<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 08. 19.
 * Time: 15:46
 */

namespace MedevAuth\Services\Auth\User\Actions\Api;


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

        $getUsers = new GetUserInfo($this->service);

        $data = $getUsers->handleRequest();

        return $response->withJson($data,200);
    }
}