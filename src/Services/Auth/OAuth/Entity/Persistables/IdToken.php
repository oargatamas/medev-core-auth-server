<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 04. 02.
 * Time: 9:55
 */

namespace MedevAuth\Services\Auth\OAuth\Entity\Persistables;


use DateTime;
use MedevAuth\Services\Auth\OAuth\Entity\DatabaseEntity;
use MedevAuth\Services\Auth\OAuth\Entity\Token\JWT\Signed\OAuthJWS;
use Medoo\Medoo;

class IdToken implements MedooPersistable
{

    /**
     * @param $storedData
     * @return DatabaseEntity
     * @throws \Exception
     */
    public static function fromAssocArray($storedData)
    {
        $token = new OAuthJWS();

        $token->setIdentifier($storedData["IdTokenId"]);
        $token->setCreatedAt(new DateTime($storedData["IdTokenCreated"]));
        $token->setExpiresAt(new DateTime($storedData["IdTokenExpires"]));
        $token->setIsRevoked($storedData["IdTokenIsRevoked"]);
        $token->setClient(Client::fromAssocArray($storedData));
        $token->setUser(User::fromAssocArray($storedData));

        return $token;
    }

    /**
     * @return string
     */
    public static function getTableName()
    {
        return "OAuth_IdTokens";
    }

    /**
     * @return string[]
     */
    public static function getColumnNames()
    {
        return [
            "IdTokenId" => Medoo::raw("<rt.Id>"),
            "IdTokenUserId" => Medoo::raw("<rt.UserId>"),
            "IdTokenClientId" => Medoo::raw("<rt.ClientId>"),
            "IdTokenIsRevoked" => Medoo::raw("<rt.IsRevoked>"),
            "IdTokenExpires" => Medoo::raw("<rt.ExpiresAt>"),
            "IdTokenCreated" => Medoo::raw("<rt.CreatedAt>")
        ];
    }
}