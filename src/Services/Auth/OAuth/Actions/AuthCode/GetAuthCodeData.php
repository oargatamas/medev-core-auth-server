<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 20.
 * Time: 16:32
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\AuthCode;



use MedevAuth\Services\Auth\OAuth\Entity;
use MedevAuth\Services\Auth\OAuth\Entity\Persistables\AuthCode;
use MedevAuth\Services\Auth\OAuth\Entity\Persistables\Client;
use MedevAuth\Services\Auth\OAuth\Entity\Persistables\User;
use MedevSlim\Core\Action\Repository\APIRepositoryAction;

class GetAuthCodeData extends APIRepositoryAction
{

    /**
     * @param $args
     * @return Entity\AuthCode
     * @throws \Exception
     */
    public function handleRequest($args = [])
    {
        $authCodeId = $args["auth_code_id"];


        $storedData = $this->database->get(AuthCode::getTableName(),
            [
                "[>]".Client::getTableName() => [ "a.ClientId" => "c.Id"],
                "[>]".User::getTableName() => [ "a.UserId" => "u.Id"],
                "[>]OAuth_UserScopes(us)" => [ "a.UserId" => "us.UserId" ],
                "[>]OAuth_ClientScopes(cs)" => [
                    "AND" => [
                        "a.UserId" => "cs.UserId",
                        "a.ClientId" => "cs.ClientId"
                    ]
                ]
            ],
            [
                AuthCode::getColumnNames(),
                Client::getColumnNames(),
                User::getColumnNames(),
                "GROUP_CONCAT(cs.ScopeId) as ClientScopes",
                "GROUP_CONCAT(us.ScopeId) as UserScopes"
            ],
            ["a.Id" => $authCodeId]
        );


        $authCode = AuthCode::fromAssocArray($storedData);


        return $authCode;
    }
}