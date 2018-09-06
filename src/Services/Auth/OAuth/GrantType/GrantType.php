<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 02.
 * Time: 19:57
 */

namespace MedevAuth\Services\Auth\OAuth\GrantType;



use MedevSlim\Core\APIAction\APIAction;
use MedevSuite\Application\Auth\OAuth\Token\TokenRepository;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

abstract class GrantType extends APIAction
{

    /**
     * @var TokenRepository
     */
    protected $accessTokenRepository;


    public function __construct(ContainerInterface $container)
    {
        $this->accessTokenRepository = $container->get("OauthAccessTokenRepository");
        parent::__construct($container,[]);
    }


    public abstract function getName();

    protected function onPermissionGranted(Request $request, Response $response, $args)
    {
        $result = $this->validateCredentials($request);
        if($result){
            return $this->grantAccess($response,$result);
        }
    }


    protected abstract function validateCredentials(Request $request);

    protected abstract function grantAccess(Response $response,$args = []);


    public function setAccessTokenRepository(TokenRepository $tokenRepository)
    {
        $this->accessTokenRepository = $tokenRepository;
    }



}