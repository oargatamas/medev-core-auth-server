<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 06. 28.
 * Time: 10:15
 */

namespace MedevAuth\Services\Auth\IdentityProvider\Actions\PasswordRecovery;


use MedevAuth\Services\Auth\IdentityProvider\IdentityService;
use MedevSlim\Core\Action\Servlet\Twig\APITwigServlet;
use Slim\Http\Request;
use Slim\Http\Response;

class RenderChangePassword extends APITwigServlet
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

        $params = [
            "service" => $this->service->getServiceName(),
            "changeUrl" => $urlBase.$this->router->pathFor(IdentityService::ROUTE_PASSWORD_RECOVERY),
            "loginUrl" => $urlBase.$this->router->pathFor(IdentityService::ROUTE_LOGIN),
            "forgotUrl" => $urlBase.$this->router->pathFor(IdentityService::ROUTE_FORGOT_PASSWORD),
            "token" => $request->getParam("token")
        ];
        return $this->render($response,"ChangePassword.twig",$params);
    }

    static function getParams()
    {
        return ["token"];
    }


}