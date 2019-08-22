<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 14.
 * Time: 11:58
 */

namespace MedevAuth\Services\Auth\OAuth\Entity;


class User extends ScopedEntity implements \JsonSerializable
{

    /**
     * @var string
     */
    private $username;
    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;
    /**
     * @var bool
     */
    private $disabled;
    /**
     * @var bool
     */
    private $verified;

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
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }



    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            "id" => $this->getIdentifier(),
            "firstName" => $this->getFirstName(),
            "lastName" => $this->getLastName(),
            "username" => $this->getUsername(),
            "email" => $this->getEmail()
        ];
    }
}