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
     * @var bool
     */
    private $disabled;

    /**
     * @return bool
     */
    public function isDisabled()
    {
        return $this->disabled;
    }

    /**
     * @param bool $disabled
     */
    public function setDisabled($disabled)
    {
        $this->disabled = $disabled;
    }

    /**
     * @return bool
     */
    public function isVerified()
    {
        return $this->verified;
    }

    /**
     * @param bool $verified
     */
    public function setVerified($verified)
    {
        $this->verified = $verified;
    }
    /**
     * @var bool
     */
    private $verified;

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