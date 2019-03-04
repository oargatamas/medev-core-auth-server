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
class Client extends ScopedEntity
{

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
}