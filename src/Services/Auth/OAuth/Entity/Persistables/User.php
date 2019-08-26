<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 03. 04.
 * Time: 13:22
 */

namespace MedevAuth\Services\Auth\OAuth\Entity\Persistables;

use MedevAuth\Services\Auth\OAuth\Entity;
use Medoo\Medoo;

class User implements MedooPersistable
{
    /**
     * @param $storedData
     * @return Entity\User
     */
    public static function fromAssocArray($storedData)
    {
        $user = new Entity\User();

        $user->setIdentifier($storedData["UserId"]);
        $user->setUsername($storedData["UserName"]);
        $user->setEmail($storedData["UserEmail"]);
        $user->setFirstName($storedData["UserFirstName"]);
        $user->setLastName($storedData["UserLastName"]);
        $user->setDisabled($storedData["UserDisabled"]);
        $user->setVerified($storedData["UserVerified"]);
        $user->setScopes(explode(",",$storedData["UserScopes"]));

        return $user;
    }

    /**
     * @return string
     */
    public static function getTableName()
    {
        return "OAuth_Users";
    }

    /**
     * @return string[]
     */
    public static function getColumnNames()
    {
        return [
            "UserId" => Medoo::raw("<u.Id>"),
			"UserFirstName" => Medoo::raw("<u.FirstName>"),
			"UserLastName" => Medoo::raw("<u.LastName>"),
			"UserName" => Medoo::raw("<u.UserName>"),
			"UserEmail" => Medoo::raw("<u.Email>"),
			"UserPassword" => Medoo::raw("<u.Password>"),
			"UserVerified" => Medoo::raw("<u.Verified>"),
			"UserDisabled" => Medoo::raw("<u.Disabled>"),
			"UserCreated" => Medoo::raw("<u.CreatedAt>"),
			"UserUpdated" => Medoo::raw("<u.UpdatedAt>")
		];
    }
}