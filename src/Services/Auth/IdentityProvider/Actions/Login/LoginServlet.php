<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 18.
 * Time: 15:02
 */

namespace MedevAuth\Services\Auth\IdentityProvider\Actions\Login;


use MedevSlim\Core\Action\Servlet\APIServlet;
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
     */
    public function handleRequest(Request $request, Response $response, $args)
    {

    }
}