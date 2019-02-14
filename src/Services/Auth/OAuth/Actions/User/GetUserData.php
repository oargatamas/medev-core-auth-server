<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 14.
 * Time: 12:06
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\User;


use MedevAuth\Services\Auth\OAuth\Entity\User;
use MedevSlim\Core\Action\Repository\APIRepositoryAction;
use MedevSlim\Core\Service\Exceptions\UnauthorizedException;

class GetUserData extends APIRepositoryAction
{

    /**
     * @param $args
     * @return User
     * @throws UnauthorizedException
     */
    public function handleRequest($args)
    {
        $userId = $args["user_id"]; //Todo move to constant

        $storedData = $this->database->get("OAuth_Users",
            ["Id","FirstName","LastName","UserName","Email","Password","Salt","CreatedAt","UpdatedAT","Verified","Disabled"],
            [
                "AND" => [
                    "Id" => $userId,
                    "Verified" => 1,
                    "Disabled" => 0
                ]
            ]);

        if(empty($storedData)){
            throw new UnauthorizedException("User with id ".$userId." can not be found in the database");
        }

        $user = new User();
        $user->setIdentifier($storedData["Id"]);
        $user->setUsername($storedData["UserName"]);
        //Todo improve to use the rest of the fields from Query.

        return $user;
    }
}