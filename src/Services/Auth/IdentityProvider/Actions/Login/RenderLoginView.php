<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 18.
 * Time: 15:02
 */

namespace MedevAuth\Services\Auth\IdentityProvider\Actions\Login;


use MedevSlim\Core\Action\Servlet\Twig\APITwigServlet;
use Slim\Http\Request;
use Slim\Http\Response;

class RenderLoginView extends APITwigServlet
{

    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function handleRequest(Request $request, Response $response, $args)
    {

        $data = [
            "login_url" => "/idp/login",
            "session_id" => session_id(),
            "error_msg" => $request->getParam("error")
        ];

        return $this->render($response,"LoginScreen.twig",$data);
    }
}