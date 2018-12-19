<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 14.
 * Time: 11:58
 */

namespace MedevAuth\Services\Auth\OAuth\Entity;


abstract class GenericToken extends DatabaseEntity
{
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