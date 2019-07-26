<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 12. 19.
 * Time: 14:48
 */

namespace MedevAuth\Token\JWT\JWS\Repository;



use MedevAuth\Services\Auth\OAuth\Entity\OAuthToken;
use MedevAuth\Services\Auth\OAuth\Repository\Exception\RepositoryException;


class RefreshTokenRepository extends JWSRepository
{

    public function persistToken(OAuthToken $token)
    {
        $this->db->insert("OAuth_RefreshTokens",
                [
                    "Id" => $token->getIdentifier(),
                    "UserId" => $token->getUser()->getIdentifier(),
                    "ClientId" => $token->getClient()->getIdentifier(),
                    "IsRevoked" => false,
                    "CreatedAt" => $token->getCreatedAt()->getTimestamp() ,
                    "Expiration" => $token->getCreatedAt()->getTimestamp() + $token->getExpiration(),
                ]
            );

        //Todo test is briefly
        $result = $this->db->error();
        if(!is_null($result)){
            throw new RepositoryException(implode(" - ",$result));
        }
    }


    public function revokeToken($tokenIdentifier)
    {
        $this->db->update("OAuth_RefreshTokens",
            [
                "IsRevoked" => true
            ],
            [
                "Id" => $tokenIdentifier
            ]);

        //Todo test is briefly
        $result = $this->db->error();
        if(!is_null($result)){
            throw new RepositoryException(implode(" - ",$result));
        }
    }


    public function isTokenBlackListed(OAuthToken $token)
    {
        $isBlackListed = $this->db->has(
            "RefreshTokens",
            [
                "AND" => [
                    "Id" => $token->getIdentifier(),
                    "IsBlackListed" => true
                ]
            ]
        );

        return $isBlackListed;
    }
}