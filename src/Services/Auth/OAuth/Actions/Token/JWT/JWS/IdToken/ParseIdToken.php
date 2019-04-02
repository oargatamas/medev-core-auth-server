<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 04. 02.
 * Time: 9:14
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\Token\JWT\JWS\IdToken;


use MedevAuth\Services\Auth\OAuth\Actions\Token\JWT\JWS\ParseToken;
use MedevAuth\Services\Auth\OAuth\Entity\Persistables\IdToken;
use MedevAuth\Services\Auth\OAuth\Entity\Token\JWT\Signed\OAuthJWS;
use MedevSlim\Core\Service\Exceptions\UnauthorizedException;

class ParseIdToken extends ParseToken
{

    /**
     * @param OAuthJWS $token
     * @return OAuthJWS
     * @throws UnauthorizedException
     */
    protected function withServerState(OAuthJWS $token)
    {
        $storedData = $this->database->get(
            IdToken::getTableName()."(it)",
            IdToken::getColumnNames(),
            ["it.Id" => $token->getIdentifier()]
        );

        if(is_null($storedData)){
            throw new UnauthorizedException("Id not existing with the following id: ".$token->getIdentifier());
        }

        $token->setIsRevoked($storedData["IsRevoked"]);
        return $token;
    }
}