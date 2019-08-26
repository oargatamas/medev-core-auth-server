<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 08. 19.
 * Time: 15:47
 */

namespace MedevAuth\Services\Auth\User\Actions\Repository;


use MedevAuth\Services\Auth\OAuth\Entity\Persistables\User;
use MedevSlim\Core\Action\Repository\APIRepositoryAction;
use MedevSlim\Core\Service\Exceptions\InternalServerException;

class GetUserInfo extends APIRepositoryAction
{

    /**
     * @param $args
     * @return \MedevAuth\Services\Auth\OAuth\Entity\User[]
     * @throws InternalServerException
     */
    public function handleRequest($args = [])
    {
        $storedData = $this->database->select(
            User::getTableName()."(u)",
            User::getColumnNames(),
            [
                "AND" => [
                    "u.Verified" => true,
                    "u.Disabled" => false
                ],
            ]
        );

        $result = $this->database->error();
        if(!is_null($result[2])){
            throw new InternalServerException("User data can not be retrieved: ".implode(" - ",$result));
        }

        $users = [];

        foreach ($storedData as $record){
            $record["UserScopes"] = "";
            $users[] = User::fromAssocArray($record);
        }

        return $users;
    }
}