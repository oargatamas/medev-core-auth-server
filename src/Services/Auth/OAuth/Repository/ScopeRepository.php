<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 18.
 * Time: 20:04
 */

namespace MedevAuth\Services\Auth\OAuth\Repository;


use MedevAuth\Services\Auth\OAuth\Entity\ClientEntityInterface;
use MedevAuth\Services\Auth\OAuth\Entity\UserEntityInterface;

interface ScopeRepository
{
    /**
     * @param UserEntityInterface $user
     * @return string[]
     */
    public function getUserScopes(UserEntityInterface $user);

    /**
     * @param ClientEntityInterface $client
     * @return string[]
     */
    public function getClientScopes(ClientEntityInterface $client);

    /**
     * @return string[]
     */
    public function getRefreshTokenScopes();
}