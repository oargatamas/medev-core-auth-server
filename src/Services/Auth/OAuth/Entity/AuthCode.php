<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 14.
 * Time: 15:03
 */

namespace MedevAuth\Services\Auth\OAuth\Entity;


use DateTime;
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;

/**
 * Class AuthCode
 * @package MedevAuth\Services\Auth\OAuth\Entity
 */
class AuthCode extends DatabaseEntity
{
    const IDENTIFIER = "auth_code_id";
    const USER = "issuer_user";
    const CLIENT = "issuer_client";
    const REDIRECT_URI = "redirect_uri";
    const EXPIRATION = "expiration";

    /**
     * @var Client
     */
    private $client;
    /**
     * @var User
     */
    private $user;
    /**
     * @var string
     */
    private $redirectUri;
    /**
     * @var DateTime
     */
    private $createdAt;
    /**
     * @var DateTime
     */
    private $expiresAt;
    /**
     * @var boolean
     */
    private $isRevoked;

    /**
     * @return Client
     */
    public function getClient(){
        return $this->client;
    }

    /**
     * @param Client $client
     */
    public function setClient(Client $client){
        $this->client = $client;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return DateTime
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    /**
     * @param DateTime $expiresAt
     */
    public function setExpiresAt(DateTime $expiresAt)
    {
        $this->expiresAt = $expiresAt;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getRedirectUri(): string
    {
        if($this->redirectUri){
            return $this->client->getRedirectUri();
        }else{
            return $this->redirectUri;
        }

    }

    /**
     * @param string $redirectUri
     */
    public function setRedirectUri(string $redirectUri)
    {
        $this->redirectUri = $redirectUri;
    }

    /**
     * @return string
     */
    public function finalizeAuthCode(){
        return $this->getIdentifier();
    }

    /**
     * @return bool
     */
    public function isRevoked()
    {
        return $this->isRevoked;
    }

    /**
     * @param bool $isRevoked
     */
    public function setIsRevoked(bool $isRevoked)
    {
        $this->isRevoked = $isRevoked;
    }
}