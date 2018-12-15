<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 14.
 * Time: 14:11
 */

namespace MedevAuth\Services\Auth\OAuth\Repository;





use MedevAuth\Services\Auth\OAuth\Entity\UserEntityInterface;

interface UserRepositoryInterface
{
    /**
     * @param string $username
     * @param string $password
     * @return UserEntityInterface
     */
    public function validateUser($username, $password);
}