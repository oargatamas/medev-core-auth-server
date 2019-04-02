<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 04. 02.
 * Time: 9:13
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\Token\JWT\JWS\IdToken;


use MedevAuth\Services\Auth\OAuth\Actions\Scope\GetIdTokenScopes;
use MedevAuth\Services\Auth\OAuth\Actions\Token\JWT\JWS\GenerateToken;
use MedevAuth\Services\Auth\OAuth\Entity\Token\JWT\Signed\OAuthJWS;
use MedevAuth\Services\Auth\OAuth\Entity\Token\OAuthToken;

class GenerateIdToken extends GenerateToken
{
    /**
     * @param $args
     * @return OAuthJWS
     * @throws \Exception
     */
    public function handleRequest($args = [])
    {
        $tokenConfig = $this->config["authorization"]["token"];

        $args[OAuthToken::EXPIRATION] = $tokenConfig["expiration"]["access_token"];
        $args[OAuthToken::SCOPES] = (new GetIdTokenScopes($this->service))->handleRequest();
        return parent::handleRequest($args);
    }
}