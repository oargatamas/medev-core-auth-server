<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 18.
 * Time: 15:02
 */

namespace MedevAuth\Services\Auth\IdentityProvider\Actions\Login;


use MedevAuth\Services\Auth\IdentityProvider\Actions\Login\Type\AuthCode\LoginWithCode;
use MedevAuth\Services\Auth\IdentityProvider\Actions\Login\Type\Password\LoginWithPassword;
use MedevSlim\Core\Action\Servlet\APIServlet;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class Login extends APIServlet
{

    const PASSWORD = "password";
    const AUTHCODE = "authcode";

    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return ResponseInterface
     * @throws \Exception
     */
    public function handleRequest(Request $request, Response $response, $args)
    {
        $loginType = $request->getParam("type", self::PASSWORD);

        $handler = null;
        switch ($loginType) {
            case self::AUTHCODE:
                return (new LoginWithCode($this->service))->handleRequest($request,$response,$args);
            default :
                return (new LoginWithPassword($this->service))->handleRequest($request,$response,$args);
        }
    }

    /**
     * @inheritDoc
     */
    static function getParams()
    {
        return [
            //Todo add state for csrf protection
        ];
    }


}