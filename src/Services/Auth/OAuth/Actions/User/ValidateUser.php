<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 13.
 * Time: 15:46
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\User;


use MedevAuth\Services\Auth\OAuth\Entity\Persistables\User;
use MedevSlim\Core\Service\Exceptions\UnauthorizedException;

class ValidateUser extends GetUserData
{

    /**
     * @param $args
     * @return \MedevAuth\Services\Auth\OAuth\Entity\User
     * @throws UnauthorizedException
     * @throws \Exception
     */
    public function handleRequest($args = [])
    {
        $this->info("Validating user credentials");
        $username = $args["username"]; //Todo move to constant
        $password = $args["password"]; //Todo move to constant


        $storedData = $this->getStoredUserData(["user_id" => $username]);
        $user = User::fromAssocArray($storedData);

        if($user->isDisabled()){
            throw new UnauthorizedException("User ".$username." disabled.");
        }

        if(!$user->isVerified()){
            throw new UnauthorizedException("User ".$username." not verified.");
        }

        if(!password_verify($password,$storedData["UserPassword"])){
            throw new UnauthorizedException("Password for ".$username." is invalid");
        }

        $this->info("User credentials are valid.");

        return $user;
    }
}