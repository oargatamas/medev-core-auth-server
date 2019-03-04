<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 03. 04.
 * Time: 11:20
 */

namespace MedevAuth\Services\Auth\OAuth\Entity\Token\JWT\Signed;



use DateTime;
use MedevAuth\Services\Auth\OAuth\Entity\Client;
use MedevAuth\Services\Auth\OAuth\Entity\User;

class AccessToken extends OAuthJWS
{

    /**
     * @param $storedData
     * @return AccessToken
     * @throws \Exception
     */
    public static function fromAssocArray($storedData)
    {
        $token = new AccessToken();

        $token->setIdentifier($storedData["at.Id"]);
        $token->setCreatedAt(new DateTime($storedData["at.CreatedAt"]));
        $token->setExpiresAt(new DateTime($storedData["at.ExpiresAt"]));
        $token->setIsRevoked($storedData["at.IsRevoked"]);
        $token->setClient(Client::fromAssocArray($storedData));
        $token->setUser(User::fromAssocArray($storedData));

        return $token;
    }

    /**
     * @return string
     */
    public static function getTableName()
    {
        return "OAuth_AccessTokens(at)";
    }

    /**
     * @return string[]
     */
    public static function getColumnNames()
    {
        return ["at.Id","at.UserId","at.ClientId","at.ExpiresAt","at.CreatedAt"];
    }
}