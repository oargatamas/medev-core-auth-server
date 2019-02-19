<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 19.
 * Time: 10:59
 */

namespace MedevAuth\Services\Auth\IdentityProvider\Actions\Register;


use MedevSlim\Core\Action\Servlet\APIServletAction;
use Slim\Http\Request;
use Slim\Http\Response;

class RegisterServlet extends APIServletAction
{

    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return Response
     */
    public function handleRequest(Request $request, Response $response, $args)
    {
        return $response;
    }
}