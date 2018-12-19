<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 14.
 * Time: 14:11
 */

namespace MedevAuth\Services\Auth\OAuth\Repository;






class UserRepository extends DBRepository
{

    /**
     * @param string $username
     * @param string $password
     * @return bool
     */
    public function validateUser($username, $password){

    }
}