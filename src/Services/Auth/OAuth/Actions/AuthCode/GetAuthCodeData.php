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
use Medoo\Medoo;

class GetAuthCodeData extends APIRepositoryAction
{

    /**
     * @param $args
     * @return Entity\AuthCode
     * @throws \Exception
     */
    public function handleRequest($args = [])
    {
        $authCodeId = $args[Entity\AuthCode::IDENTIFIER];


        $storedData = $this->database->get(AuthCode::getTableName()."(a)",
            [
                "[>]".Client::getTableName()."(c)" => [ "a.ClientId" => "Id"],
                "[>]".User::getTableName()."(u)" => [ "a.UserId" => "Id"],
                "[>]OAuth_ClientGrantTypes(cg)" => [ "a.ClientId" => "ClientId" ],
                "[>]OAuth_GrantTypes(g)" => ["cg.GrantId" => "Id"],
                "[>]OAuth_UserScopes(us)" => [ "a.UserId" => "UserId" ],
                "[>]OAuth_ClientScopes(cs)" => [
                        "a.UserId" => "UserId",
                        "a.ClientId" => "ClientId"
                    ]
            ],
            array_merge(
                AuthCode::getColumnNames(),
                Client::getColumnNames(),
                User::getColumnNames(),
                ["ClientGrantTypes" => Medoo::raw("GROUP_CONCAT(DISTINCT(<g.GrantName>))")],
                ["ClientScopes" => Medoo::raw("GROUP_CONCAT(DISTINCT(<cs.ScopeId>))")],
                ["UserScopes" => Medoo::raw("GROUP_CONCAT(DISTINCT(<us.ScopeId>))")]
            ),
            [
                "a.Id" => $authCodeId,
                "GROUP" => "a.Id"
            ]
        );

        $result = $this->database->error();

        $authCode = AuthCode::fromAssocArray($storedData);


        return $authCode;
    }
}