<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 02.
 * Time: 19:57
 */

namespace MedevAuth\Services\Auth\OAuth\GrantType;



use MedevSuite\Application\Auth\OAuth\Token\TokenRepository;
use Slim\Http\Request;
use Slim\Http\Response;

abstract class GrantType
{

    /**
     * @var TokenRepository
     */
    protected $accessTokenRepository;


    public abstract function getName();


    public function __invoke(Request $request, Response $response, $args)
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