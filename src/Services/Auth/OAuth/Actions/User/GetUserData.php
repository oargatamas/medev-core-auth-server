<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 14.
 * Time: 12:06
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\User;


use MedevAuth\Services\Auth\OAuth\Entity;
use MedevAuth\Services\Auth\OAuth\Entity\Persistables\User;
use MedevSlim\Core\Action\Repository\APIRepositoryAction;
use MedevSlim\Core\Service\Exceptions\UnauthorizedException;
use Medoo\Medoo;

class GetUserData extends APIRepositoryAction
{

    /**
     * @param array $args
     * @return Entity\User
     * @throws UnauthorizedException
     */
    public function handleRequest($args = [])
    {
        return User::fromAssocArray($this->getStoredUserData($args));
    }

    /**
     * @param array $args
     * @return array
     * @throws UnauthorizedException
     */
    protected function getStoredUserData($args)
    {
        $userId = $args["user_id"]; //Todo move to constant

        $storedData = $this->database->get(User::getTableName() . "(u)",
            [
                "[>]OAuth_UserScopes(us)" => ["u.Id" => "UserId"]
            ]
            ,
            array_merge(
                User::getColumnNames(),
                ["UserScopes" => Medoo::raw("GROUP_CONCAT(<us.ScopeId>)")]
            ),
            [
                "OR" => [
                    "u.Id" => $userId,
                    "u.UserName" => $userId,
                    "u.Email" => $userId
                ],
                "GROUP" => "u.Id"
            ]);

        if (empty($storedData)) {
            $error = $this->database->error();
            $this->error(implode(". ", $error));
            throw new UnauthorizedException("User with id " . $userId . " can not be found in the database.");
        }

        return $storedData;
    }
}