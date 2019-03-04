<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 03. 04.
 * Time: 11:20
 */

namespace MedevAuth\Services\Auth\OAuth\Entity\Persistables;


use DateTime;
use MedevAuth\Services\Auth\OAuth\Entity\Token\JWT\Signed\OAuthJWS;

class RefreshToken implements MedooPersistable
{

    /**
     * @param $storedData
     * @return OAuthJWS
     * @throws \Exception
     */
    public static function fromAssocArray($storedData)
    {
        $token = new OAuthJWS();

        $token->setIdentifier($storedData["rt.Id"]);
        $token->setCreatedAt(new DateTime($storedData["rt.CreatedAt"]));
        $token->setExpiresAt(new DateTime($storedData["rt.ExpiresAt"]));
        $token->setIsRevoked($storedData["rt.IsRevoked"]);
        $token->setClient(Client::fromAssocArray($storedData));
        $token->setUser(User::fromAssocArray($storedData));

        return $token;
    }

    /**
     * @return string
     */
    public static function getTableName()
    {
        return "OAuth_RefreshTokens(rt)";
    }

    /**
     * @return string[]
     */
    public static function getColumnNames()
    {
        return ["rt.Id","rt.UserId","rt.ClientId","rt.IsRevoked","rt.ExpiresAt","rt.CreatedAt"];
    }
}