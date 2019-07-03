<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 18.
 * Time: 15:03
 */

namespace MedevAuth\Services\Auth\IdentityProvider\Actions\Logout;


use MedevSlim\Core\Action\Servlet\APIServlet;
use Slim\Http\Request;
use Slim\Http\Response;

class Logout extends APIServlet
{

    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return Response
     */
    public function handleRequest(Request $request, Response $response, $args)
    {
        session_destroy();

        //Todo implement functionality which invalidates the access and refresh tokens for the related user

        return $response;
    }


}