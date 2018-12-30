<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 12. 19.
 * Time: 14:48
 */

namespace MedevAuth\Token\JWT\JWS\Repository;


use MedevAuth\Services\Auth\OAuth\Entity\GenericToken;

class RefreshTokenRepository extends JWSRepository
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
        $isBlackListed = $this->db->has(
            "RefreshTokens",
            [
                "AND" => [
                    "Id" => $token->getIdentifier(),
                    "IsBlackListed" => 1
                ]
            ]
        );

        return $isBlackListed;
    }
}