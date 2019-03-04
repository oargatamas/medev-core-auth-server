<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 14.
 * Time: 10:44
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\Token\JWT\JWS\RefreshToken;


use MedevAuth\Services\Auth\OAuth\Actions\Token\JWT\JWS\ParseToken;
use MedevAuth\Services\Auth\OAuth\Entity\Persistables\RefreshToken;
use MedevAuth\Services\Auth\OAuth\Entity\Token\JWT\Signed\OAuthJWS;

class ParseRefreshToken extends ParseToken
{
    public function handleRequest($args = [])
    {
        return parent::handleRequest($args);
    }


    /**
     * @param OAuthJWS $token
     * @return OAuthJWS
     */
    protected function withServerState(OAuthJWS $token)
    {
        $isBlackListed = $this->database->has(
            RefreshToken::getTableName(),
            [
                "AND" => [
                    "rt.Id" => $token->getIdentifier(),
                    "rt.IsRevoked" => false
                ]
            ]
        );

        $token->setIsRevoked($isBlackListed);
        return $token;
    }
}