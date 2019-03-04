<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 14.
 * Time: 11:58
 */

namespace MedevAuth\Services\Auth\OAuth\Entity;


class User extends ScopedEntity
{

    /**
     * @var string
     */
    private $username;

    /**
     * @return string
     */
    public function getUsername(){
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username){
        $this->username = $username;
    }

    /**
     * @param $storedData
     * @return User
     */
    public static function fromAssocArray($storedData)
    {
        $user = new User();

        $user->setIdentifier($storedData["u.Id"]);
        $user->setUsername($storedData["u.UserName"]);
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