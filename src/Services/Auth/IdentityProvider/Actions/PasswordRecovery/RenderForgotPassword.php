<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 06. 28.
 * Time: 10:15
 */

namespace MedevAuth\Services\Auth\IdentityProvider\Actions\PasswordRecovery;


use MedevAuth\Services\Auth\IdentityProvider\PasswordLoginService;
use MedevAuth\Services\Auth\IdentityProvider\PasswordRecoveryService;
use MedevSlim\Core\Action\Servlet\Twig\APITwigServlet;
use Slim\Http\Request;
use Slim\Http\Response;

class RenderForgotPassword extends APITwigServlet
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
            "loginUrl" => $this->router->pathFor(PasswordLoginService::ROUTE_LOGIN_VIEW),
            "forgotUrl" => $this->router->pathFor(PasswordRecoveryService::ROUTE_FORGOT_PASSWORD_VIEW)
        ];
        return $this->render($response,"ForgotPassword.twig",$data);
    }
}