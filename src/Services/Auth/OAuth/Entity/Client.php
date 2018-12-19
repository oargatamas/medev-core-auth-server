<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 14.
 * Time: 11:59
 */

namespace MedevAuth\Services\Auth\OAuth\Entity;


class Client extends DatabaseEntity
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
}