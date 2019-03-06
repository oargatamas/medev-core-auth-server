<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 13.
 * Time: 15:46
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\User;


use MedevAuth\Services\Auth\OAuth\Entity\Persistables\User;
use MedevSlim\Core\Action\Repository\APIRepositoryAction;
use MedevSlim\Core\Service\Exceptions\UnauthorizedException;

class ValidateUser extends APIRepositoryAction
{

    /**
     * @param $args
     * @return int
     * @throws UnauthorizedException
     */
    public function handleRequest($args = [])
    {
        $this->info("Validating user credentials");
        $username = $args["username"]; //Todo move to constant
        $password = $args["password"]; //Todo move to constant

        $storedData = $this->database->get(User::getTableName()."(u)",
            User::getColumnNames(),
            [
                "AND" => [
                    "OR" =>[
                        "u.UserName" => $username,
                        "u.Email" => $username
                    ],
                    "u.Verified" => 1,
                    "u.Disabled" => 0
                ]
            ]
        );

        if(!$storedData || empty($storedData) || is_null($storedData)){
            throw new UnauthorizedException("User ".$username." not registered or disabled.");
        }

        if(!password_verify($password,$storedData["UserPassword"])){
            throw new UnauthorizedException("Password for ".$username." is invalid");
        }

        $this->info("User credentials are valid.");

        return $storedData["UserId"];
    }
}