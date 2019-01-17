<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 12. 19.
 * Time: 14:47
 */

namespace MedevAuth\Token\JWT\JWS\Repository;


use MedevAuth\Services\Auth\OAuth\Entity\OAuthToken;

class AccessTokenRepository extends JWSRepository
{

    public function getToken($tokenIdentifier)
    {
        // As we are not storing access tokens, the get token will return null
        return null;
    }


    public function persistToken(OAuthToken $token)
    {
        // We are not storing access tokens due to the expiration of the JWT
    }


    public function revokeToken($tokenIdentifier)
    {
        // Due to the expiration of the JWT, access tokens should not be revoked
    }


    public function isTokenBlackListed(OAuthToken $token)
    {
        // Due to the expiration of the JWT, access tokens are not blacklisted at all
        return false;
    }
}