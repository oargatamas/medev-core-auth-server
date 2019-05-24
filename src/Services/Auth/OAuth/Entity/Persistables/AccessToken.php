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

class AccessToken implements MedooPersistable
{

    /**
     * @param $storedData
     * @return OAuthJWS
     * @throws \Exception
     */
    public static function fromAssocArray($storedData)
    {
        return null;
    }

    /**
     * @return string
     */
    public static function getTableName()
    {
        return "OAuth_AccessTokens";
    }

    /**
     * @return string[]
     */
    public static function getColumnNames()
    {
        return ["at.Id","at.UserId","at.ClientId","at.ExpiresAt","at.CreatedAt"];
    }
}