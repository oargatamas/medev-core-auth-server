<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 14.
 * Time: 10:46
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\Token\JWT\JWS\AccessToken;


use MedevAuth\Services\Auth\OAuth\Actions\Token\JWT\JWS\ParseToken;
use MedevAuth\Services\Auth\OAuth\Entity\Token\JWT\Signed\OAuthJWS;

class ParseAccessToken extends ParseToken
{

    public function handleRequest($args)
    {
        return parent::handleRequest($args);
    }
    /**
     * @param OAuthJWS $token
     * @return OAuthJWS
     */
    protected function withServerState(OAuthJWS $token)
    {
        //By we do not using Accesstoken blacklisting due to it's short living
        //Therefore setting the revoked state implicitly to false
        $token->setIsRevoked(false);
        return $token;
    }
}