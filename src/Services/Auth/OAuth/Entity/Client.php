<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 14.
 * Time: 11:59
 */

namespace MedevAuth\Services\Auth\OAuth\Entity;



/**
 * Class Client
 * @package MedevAuth\Services\Auth\OAuth\Entity
 */
class Client extends ScopedEntity implements \JsonSerializable
{
    const TOKEN_AS_BODY = "req-body";
    const TOKEN_AS_COOKIE = "cookie";
    const TOKEN_AS_URL = "url";

    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $secret;
    /**
     * @var string
     */
    private $redirectUri;
    /**
     * @var string[]
     */
    private $grantTypes;

    /**
     * @var string[]
     */
    private $loginTypes;

    /**
     * @var string
     */
    private $tokenPlace;

    /**
     * @return string
     */
    public function getName(){
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name){
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSecret(){
        return $this->secret;
    }

    /**
     * @param string $secret
     */
    public function setSecret($secret){
        $this->secret = $secret;
    }

    /**
     * @return string
     */
    public function getRedirectUri(){
        return $this->redirectUri;
    }

    /**
     * @param string $redirect_uri
     */
    public function setRedirectUri($redirect_uri){
        $this->redirectUri = $redirect_uri;
    }

    /**
     * @param string[] $grantTypes
     */
    public function setGrantTypes($grantTypes)
    {
        $this->grantTypes = $grantTypes;
    }


    /**
     * @param string $grantType
     * @return bool
     */
    public function hasGrantType($grantType){
        return in_array($grantType,$this->grantTypes);
    }

    /**
     * @param string[] $loginTypes
     */
    public function setLoginTypes($loginTypes)
    {
        $this->loginTypes = $loginTypes;
    }

    /**
     * @return string[]
     */
    public function getLoginTypes(): array
    {
        return $this->loginTypes;
    }


    /**
     * @param string $loginType
     * @return bool
     */
    public function hasLoginType($loginType){
        return in_array($loginType,$this->loginTypes);
    }

    /**
     * @return string
     */
    public function getTokenPlace()
    {
        return $this->tokenPlace;
    }

    /**
     * @param string $tokenPlace
     */
    public function setTokenPlace(string $tokenPlace)
    {
        $this->tokenPlace = $tokenPlace;
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
            "name" => $this->getName(),
            "redirectUri" => $this->getRedirectUri(),
        ];
    }
}