<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 02.
 * Time: 20:30
 */

namespace MedevAuth\Services\Auth\OAuth\Action;



use MedevAuth\Services\Auth\OAuth\OAuthService;
use MedevSlim\Core\APIAction\APIAction;
use MedevSlim\Core\APIService\Exceptions\ForbiddenException;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class GrantAccess extends APIAction
{
    private $authService;

    public function __construct(ContainerInterface $container,OAuthService $authService)
    {
        $this->authService = $authService;
        parent::__construct($container, []);
    }


    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return mixed
     * @throws \MedevSlim\Core\APIService\Exceptions\ForbiddenException
     */
    protected function onPermissionGranted(Request $request, Response $response, $args)
    {
        $body = $request->getParsedBody();

        if(isset($body["grant_type"]) && $this->authService->hasGrantType($body["grant_type"])){

            $handler = $this->authService->getGrantType($body["grant_type"]);
            return $handler($request,$response,$args);
        }else{

            throw new ForbiddenException();
        }
    }
}