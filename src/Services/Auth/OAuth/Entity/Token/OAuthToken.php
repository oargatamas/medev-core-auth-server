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
use MedevAuth\Services\Auth\OAuth\Entity\DatabaseEntity;
use MedevAuth\Services\Auth\OAuth\Entity\User;

class OAuthToken extends DatabaseEntity
{
    const USER = "issuer_user";
    const CLIENT = "issuer_client";
    const SCOPES = "scopes";

    /**
     * @var DateTime
     */
    protected $createdAt;

    /**
     * @var int
     */
    protected $expiration;

    /**
     * @var string[]
     */
    protected $scopes;

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
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return int
     */
    public function getExpiration(){
        return $this->expiration;
    }

    /**
     * @param int $expiration
     */
    public function setExpiration($expiration){
        $this->expiration = $expiration;
    }


    /**
     * @return string[]
     */
    public function getScopes(){
        return $this->scopes;
    }

    /**
     * @param string[] $scopes
     */
    public function setScopes($scopes){
        $this->scopes = $scopes;
    }

    /**
     * @param string $scope
     */
    public function addScope($scope){
        array_push($this->scopes,$scope);
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