<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 13.
 * Time: 15:46
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\User;


use MedevSlim\Core\Action\Repository\APIRepositoryAction;
use MedevSlim\Core\Service\Exceptions\UnauthorizedException;

class ValidateUser extends APIRepositoryAction
{

    /**
     * @param $args
     * @return void
     * @throws UnauthorizedException
     */
    public function handleRequest($args = [])
    {
        $this->info("Validating user credentials");
        $username = $args["username"]; //Todo move to constant
        $password = $args["password"]; //Todo move to constant

        $storedData = $this->database->get("OAuth_Users",
            ["Password"],
            [
                "AND" => [
                    "OR" =>[
                        "UserName" => $username,
                        "Email" => $username
                    ],
                    "Verified" => 1,
                    "Disabled" => 0
                ]
            ]
        );

        if(!$storedData || empty($storedData) || is_null($storedData)){
            throw new UnauthorizedException("User ".$username." not registered or disabled.");
        }

        if(!password_verify($password,$storedData["Password"])){
            throw new UnauthorizedException("Password for ".$username." is invalid");
        }

        $this->info("User credentials are valid.");
    }
}