<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 18.
 * Time: 20:04
 */

namespace MedevAuth\Services\Auth\OAuth\Repository;




use MedevAuth\Services\Auth\OAuth\Entity\Client;
use MedevAuth\Services\Auth\OAuth\Entity\User;

interface ScopeRepository
{

    /**
     * @param User $user
     * @return string[]
     */
    public function getUserScopes(User $user);


    /**
     * @param Client $client
     * @return string[]
     */
    public function getClientScopes(Client $client);

    /**
     * @return string[]
     */
    public function getRefreshTokenScopes();
}