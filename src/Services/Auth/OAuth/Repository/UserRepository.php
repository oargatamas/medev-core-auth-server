<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 14.
 * Time: 14:11
 */

namespace MedevAuth\Services\Auth\OAuth\Repository;






use MedevAuth\Services\Auth\OAuth\Repository\Exception\RepositoryException;

interface UserRepository
{

    /**
     * @param string $username
     * @param string $password
     * @throws RepositoryException
     */
    public function validateUser($username, $password);
}