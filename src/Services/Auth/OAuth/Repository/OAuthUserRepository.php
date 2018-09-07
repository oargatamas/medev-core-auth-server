<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 05.
 * Time: 9:31
 */

namespace MedevAuth\Services\Auth\OAuth\Repository;




interface OAuthUserRepository
{
    public function IsCredentialsValid($username, $password);
    public function getUserData($username);
}