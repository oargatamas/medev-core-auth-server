<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 12. 19.
 * Time: 14:47
 */

namespace MedevAuth\Token\JWT\JWS\Repository;


use MedevAuth\Services\Auth\OAuth\Entity\GenericToken;

class AccessTokenRepository extends JWSRepository
{

    /**
     * @param string $tokenIdentifier
     */
    public function getToken($tokenIdentifier)
    {
        // TODO: Implement getToken() method.
    }

    /**
     * @param GenericToken $token
     */
    public function persistToken(GenericToken $token)
    {
        // TODO: Implement persistToken() method.
    }

    /**
     * @param string $tokenIdentifier
     */
    public function revokeToken($tokenIdentifier)
    {
        // TODO: Implement revokeToken() method.
    }

    /**
     * @param GenericToken $token
     * @return bool
     */
    public function isTokenBlackListed(GenericToken $token)
    {
        // TODO: Implement isTokenBlackListed() method.
    }
}