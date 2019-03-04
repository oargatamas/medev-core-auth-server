<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 03. 04.
 * Time: 13:22
 */

namespace MedevAuth\Services\Auth\OAuth\Entity\Persistables;

use MedevAuth\Services\Auth\OAuth\Entity;

class User implements MedooPersistable
{
    /**
     * @param $storedData
     * @return Entity\User
     */
    public static function fromAssocArray($storedData)
    {
        $user = new Entity\User();

        $user->setIdentifier($storedData["Id"]);
        $user->setUsername($storedData["UserName"]);
        $user->setScopes(explode(",",$storedData["UserScopes"]));

        return $user;
    }

    /**
     * @return string
     */
    public static function getTableName()
    {
        return "OAuth_Users(u)";
    }

    /**
     * @return string[]
     */
    public static function getColumnNames()
    {
        return ["u.Id","u.FirstName","u.LastName","u.UserName","u.Email","u.Password","u.Verified","u.Disabled","u.CreatedAt","u.UpdatedAt"];
    }
}