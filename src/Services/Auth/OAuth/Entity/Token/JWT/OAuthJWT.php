<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 14.
 * Time: 17:04
 */

namespace MedevAuth\Services\Auth\OAuth\Entity\Token\JWT;


use JOSE_JWT;
use MedevAuth\Services\Auth\OAuth\Entity\Token\OAuthToken;

class OAuthJWT extends OAuthToken
{

    /**
     * @return array
     */
    protected function mapPropsToClaims(){
        return [
            "jti" => $this->identifier,
            "sub" => $this->user->getIdentifier(),
            "aud" => $this->client->getIdentifier(),
            "iat" => $this->createdAt->getTimestamp(),
            "nbf" => $this->createdAt->getTimestamp(),
            "exp" => $this->expiresAt->getTimestamp(),
            "usr" => $this->user->getIdentifier(),
            "cli" => $this->client->getIdentifier(),
            "scopes" => $this->scopes
        ];
    }

    /**
     * @return string
     */
    public function finalizeToken()
    {
        $token = new JOSE_JWT($this->mapPropsToClaims());

        return $token->toString();
    }


}