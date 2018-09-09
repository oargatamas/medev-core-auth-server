<?php

use Medoo\Medoo;

/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 07.
 * Time: 10:50
 */

namespace MedevAuth\Application\Auth\Users;


use MedevAuth\Services\Auth\OAuth\Repository\OAuthUserRepository;
use Psr\Container\ContainerInterface;

class UserRepository implements OAuthUserRepository
{

    /* @var Medoo */
    private $database;

    /**
     * UserRepository constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->database = $container->get("database");
    }


    public function IsCredentialsValid($username, $password)
    {
        $user = $this->database->get("oauth_users", [
                "password"
            ], [
                "OR" => [
                    "email[=]" => $username,
                    "username[=]" => $username,
                    "enabled" => true
                ]
            ]);

        if(isset($user["password"]) && password_verify($password,$user["password"])){
            return true;
        }else{
            return false;
        }


    }

    public function getUserData($username)
    {
        $user = $this->database->get("oauth_users", [
            "password"
        ], [
            "OR" => [
                "email[=]" => $username,
                "username[=]" => $username,
                "enabled" => true
            ]
        ]);

        return $user;
    }
}