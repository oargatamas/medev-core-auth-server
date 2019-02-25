<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 25.
 * Time: 8:58
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\GrantType;


use MedevAuth\Services\Auth\OAuth\Actions\GrantType\Authorization\Authorization;
use MedevAuth\Services\Auth\OAuth\Actions\GrantType\Flows;
use MedevSlim\Core\Action\Servlet\APIServlet;
use MedevSlim\Core\Service\Exceptions\BadRequestException;
use Slim\Http\Request;
use Slim\Http\Response;

class AuthorizationHandler extends APIServlet
{
    /**
     * @inheritDoc
     */
    public function handleRequest(Request $request, Response $response, $args)
    {
        $responseType = $request->getParam("response_type");

        $handler = $this->getAuthHandler($responseType);

        return $handler($request, $response, $args);
    }


    /**
     * @param string $responseType
     * @return Authorization
     * @throws BadRequestException
     * @throws \Exception
     */
    private function getAuthHandler($responseType)
    {
        switch ($responseType) {
            case "code" : return new Flows\Implicit\AuthorizeRequest($this->service);
            case "token": return new Flows\AuthCode\AuthorizeRequest($this->service);
            default : throw new BadRequestException("Invalid/not supported response type for authorization: ". $responseType);
        }
    }

    static function getParams()
    {
        return ["response_type"];
    }


}