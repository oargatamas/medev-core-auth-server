<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 18.
 * Time: 15:02
 */

namespace MedevAuth\Services\Auth\IdentityProvider\Actions\Login\Type\Password;


use MedevAuth\Services\Auth\IdentityProvider\AuthCodeLoginService;
use MedevAuth\Services\Auth\IdentityProvider\PasswordLoginService;
use MedevAuth\Services\Auth\IdentityProvider\PasswordRecoveryService;
use MedevSlim\Core\Action\Servlet\Twig\APITwigServlet;
use Slim\Http\Request;
use Slim\Http\Response;

class RenderPasswordLogin extends APITwigServlet
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
            "authCodeLoginUrl" => $urlBase.$this->router->pathFor(AuthCodeLoginService::ROUTE_LOGIN_VIEW),
            "forgotUrl" => $urlBase.$this->router->pathFor(PasswordRecoveryService::ROUTE_FORGOT_PASSWORD_VIEW),
            "loginUrl" => $urlBase.$this->router->pathFor(PasswordLoginService::ROUTE_LOGIN),
            "errorMsg" => $request->getParam("error")
        ];

        return $this->render($response,"PasswordLoginScreen.twig",$data);
    }
}