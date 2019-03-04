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
}