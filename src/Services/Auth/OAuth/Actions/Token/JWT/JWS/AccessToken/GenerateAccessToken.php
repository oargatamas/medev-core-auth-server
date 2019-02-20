<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 13.
 * Time: 16:00
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\Token\JWT\JWS\AccessToken;


use MedevAuth\Services\Auth\OAuth\Actions\Token\JWT\JWS\GenerateToken;
use MedevAuth\Services\Auth\OAuth\Entity\Token\JWT\Signed\OAuthJWS;

class GenerateAccessToken extends GenerateToken
{

    /**
     * @param $args
     * @return OAuthJWS
     */
    public function handleRequest($args = [])
    {
        return parent::handleRequest($args);
    }
}