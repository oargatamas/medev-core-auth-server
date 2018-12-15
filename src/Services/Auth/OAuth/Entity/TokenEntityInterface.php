<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 14.
 * Time: 11:58
 */

namespace MedevAuth\Services\Auth\OAuth\Entity;


interface TokenEntityInterface extends EntityInterface
{
    public function getExpiration();

    public function setExpiration($expiration);

    public function getScopes();

    public function setScopes($scopes);

    public function addScope($scope);

    public function getClient();

    public function setClient(ClientEntityInterface $client);

    public function getUser();

    public function setUser(UserEntityInterface $user);

    public function finalizeToken();
}