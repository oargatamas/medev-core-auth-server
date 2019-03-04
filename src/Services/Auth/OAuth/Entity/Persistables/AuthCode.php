<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 03. 04.
 * Time: 13:20
 */

namespace MedevAuth\Services\Auth\OAuth\Entity\Persistables;



use DateTime;
use MedevAuth\Services\Auth\OAuth\Entity;

class AuthCode implements MedooPersistable
{
    /**
     * @param $storedData
     * @return Entity\AuthCode
     * @throws \Exception
     */
    public static function fromAssocArray($storedData)
    {
        $authCode = new Entity\AuthCode();

        $authCode->setIdentifier($storedData["a.Id"]);
        $authCode->setRedirectUri($storedData["a.RedirectURI"]);
        $authCode->setIsRevoked($storedData["a.IsRevoked"]);
        $authCode->setCreatedAt(new DateTime($storedData["a.CreatedAt"]));
        $authCode->setExpiresAt(new DateTime($storedData["a.ExpiresAt"]));
        $authCode->setUser(User::fromAssocArray($storedData));
        $authCode->setClient(Client::fromAssocArray($storedData));

        return $authCode;
    }

    /**
     * @return string
     */
    public static function getTableName()
    {
        return "OAuth_AuthCode(a)";
    }

    /**
     * @return string[]
     */
    public static function getColumnNames()
    {
        return ["a.Id","a.RedirectURI","a.IsRevoked","a.CreatedAt","a.ExpiresAt"];
    }
}