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
use MedevSlim\Core\Service\Exceptions\UnauthorizedException;

class ParseRefreshToken extends ParseToken
{
    public function handleRequest($args = [])
    {
        return parent::handleRequest($args);
    }


    /**
     * @param OAuthJWS $token
     * @return OAuthJWS
     * @throws UnauthorizedException
     */
    protected function withServerState(OAuthJWS $token)
    {
        $storedData = $this->database->get(
            RefreshToken::getTableName()."(rt)",
            RefreshToken::getColumnNames(),
            ["rt.Id" => $token->getIdentifier()]
        );

        if(is_null($storedData)){
            throw new UnauthorizedException("Refreshtoken not existing with the following id: ".$token->getIdentifier());
        }

        $token->setIsRevoked($storedData["IsRevoked"]);
        return $token;
    }
}