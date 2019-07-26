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
use Medoo\Medoo;

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

        $authCode->setIdentifier($storedData["AuthCodeId"]);
        $authCode->setRedirectUri($storedData["AuthCodeRedirectURI"]);
        $authCode->setIsRevoked($storedData["AuthCodeRevoked"]);
        $authCode->setCreatedAt(new DateTime($storedData["AuthCodeCreatedAt"]));
        $authCode->setExpiresAt(new DateTime($storedData["AuthCodeExpiresAt"]));
        $authCode->setUser(User::fromAssocArray($storedData));
        $authCode->setClient(Client::fromAssocArray($storedData));

        return $authCode;
    }

    /**
     * @return string
     */
    public static function getTableName()
    {
        return "OAuth_AuthCodes";
    }

    /**
     * @return string[]
     */
    public static function getColumnNames()
    {
        return [
            "AuthCodeId" => Medoo::raw("<a.Id>"),
            "AuthCodeRedirectURI" => Medoo::raw("<a.RedirectURI>"),
            "AuthCodeRevoked" => Medoo::raw("<a.IsRevoked>"),
            "AuthCodeCreatedAt" => Medoo::raw("<a.CreatedAt>"),
            "AuthCodeExpiresAt" => Medoo::raw("<a.ExpiresAt>")
        ];
    }
}