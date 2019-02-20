<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 13.
 * Time: 16:20
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\Token\JWT\JWS\RefreshToken;



use MedevAuth\Services\Auth\OAuth\Actions\Scope\GetRefreshTokenScopes;
use MedevAuth\Services\Auth\OAuth\Actions\Token\JWT\JWS\GenerateToken;
use MedevAuth\Services\Auth\OAuth\Entity\Token\JWT\Signed\OAuthJWS;

class GenerateRefreshToken extends GenerateToken
{

    /**
     * @param $args
     * @return OAuthJWS
     * @throws \Exception
     */
    public function handleRequest($args = [])
    {
        $args["scopes"] = (new GetRefreshTokenScopes($this->service))->handleRequest();
        return parent::handleRequest($args);
    }
}