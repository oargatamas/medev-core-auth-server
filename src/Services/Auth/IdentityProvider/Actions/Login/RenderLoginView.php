<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 18.
 * Time: 15:02
 */

namespace MedevAuth\Services\Auth\IdentityProvider\Actions\Login;


use MedevAuth\Services\Auth\IdentityProvider\IdentityService;
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
            "service" => $this->service->getServiceName(),
            "loginUrl" => $this->router->pathFor(IdentityService::ROUTE_LOGIN),
            "forgotUrl" => "https://auth.medev.hu".$this->router->pathFor(IdentityService::ROUTE_FORGOT_PASSWORD),
            "sessionId" => session_id(),
            "errorMsg" => $request->getParam("error")
        ];

        return $this->render($response,"LoginScreen.twig",$data);
    }
}