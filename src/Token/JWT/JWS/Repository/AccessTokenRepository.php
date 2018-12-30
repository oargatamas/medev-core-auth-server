<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 12. 19.
 * Time: 14:47
 */

namespace MedevAuth\Token\JWT\JWS\Repository;


use MedevAuth\Services\Auth\OAuth\Entity\GenericToken;
use MedevAuth\Token\JWT\JWS\SignedJWT;

class AccessTokenRepository extends JWSRepository
{

    /**
     * @param string $tokenIdentifier
     * @return SignedJWT
     */
    public function getToken($tokenIdentifier)
    {
        // As we are not storing access tokens, the get token will return null
        return null;
    }

    /**
     * @param GenericToken $token
     */
    public function persistToken(GenericToken $token)
    {
        // We are not storing access tokens due to the expiration of the JWT
    }

    /**
     * @param string $tokenIdentifier
     */
    public function revokeToken($tokenIdentifier)
    {
        // Due to the expiration of the JWT, access tokens should not be revoked
    }

    /**
     * @param GenericToken $token
     * @return bool
     */
    public function isTokenBlackListed(GenericToken $token)
    {
        // Due to the expiration of the JWT, access tokens are not blacklisted at all
        return false;
    }
}