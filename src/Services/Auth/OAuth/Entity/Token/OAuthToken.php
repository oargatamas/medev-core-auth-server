<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 14.
 * Time: 11:58
 */

namespace MedevAuth\Services\Auth\OAuth\Entity\Token;


use DateTime;
use MedevAuth\Services\Auth\OAuth\Entity\Client;
use MedevAuth\Services\Auth\OAuth\Entity\ScopedEntity;
use MedevAuth\Services\Auth\OAuth\Entity\User;

class OAuthToken extends ScopedEntity
{
    const USER = "issuer_user";
    const CLIENT = "issuer_client";
    const SCOPES = "scopes";
    const TOKEN = "token_base";
    const EXPIRATION = "expiration";

    /**
     * @var DateTime
     */
    protected $createdAt;

    /**
     * @var DateTime
     */
    protected $expiresAt;
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var bool
     */
    protected $isRevoked;

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return DateTime
     * @throws \Exception
     */
    public function getExpiresAt(){
        return $this->expiresAt;
    }

    /**
     * @return int
     */
    public function getExpiration(){
        $expiry = $this->expiresAt->getTimestamp();
        $create = $this->createdAt->getTimestamp();
        return $expiry - $create;
    }

    /**
     * @param int $seconds
     * @throws \Exception
     */
    public function setExpiration($seconds){
        $expiration = new DateTime();
        $expiration->setTimestamp($this->createdAt->getTimestamp());
        $expiration->modify("+".$seconds." second");
        $this->expiresAt = $expiration;
    }

    /**
     * @param DateTime $expiresAt
     * @return void
     */
    public function setExpiresAt(Datetime $expiresAt){
        $this->expiresAt = $expiresAt;
    }


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
     * @return User
     */
    public function getUser(){
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user){
        $this->user = $user;
    }

    /**
     * @return bool
     */
    public function isRevoked(): bool
    {
        return $this->isRevoked;
    }

    /**
     * @param bool $isRevoked
     */
    public function setIsRevoked(bool $isRevoked): void
    {
        $this->isRevoked = $isRevoked;
    }

    /**
     * @return string
     */
    public function finalizeToken()
    {
        return $this->identifier;
    }
}