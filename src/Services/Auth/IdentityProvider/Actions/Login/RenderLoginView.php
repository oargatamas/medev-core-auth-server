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
        $urlBase = $request->getServerParam("REQUEST_SCHEME")."://".$request->getServerParam("SERVER_NAME");

        $data = [
            "service" => $this->service->getServiceName(),
            "passwordLogin" => Login::PASSWORD,
            "codeLogin" => Login::AUTHCODE,
            "loginUrl" => $this->router->pathFor(IdentityService::ROUTE_LOGIN),
            "forgotUrl" => $urlBase.$this->router->pathFor(IdentityService::ROUTE_FORGOT_PASSWORD),
            "codeUrl" => $urlBase.$this->router->pathFor(IdentityService::ROUTE_LOGIN_CODE),
            "openedAt" => $request->getParam("opened_at",Login::PASSWORD),
            "notification" => $request->getParam("message"),
            "errorMsg" => $request->getParam("error")
        ];

        return $this->render($response,"LoginScreen.twig",$data);
    }
}