<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 14.
 * Time: 11:58
 */

namespace MedevAuth\Services\Auth\OAuth\Entity;


abstract class Token extends DatabaseEntity
{
    /**
     * @var int
     */
    private $expiration;
    /**
     * @var string[]
     */
    private $scopes;
    /**
     * @var Client
     */
    private $client;
    /**
     * @var User
     */
    private $user;


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
     * @return string
     */
    public abstract function finalizeToken();
}