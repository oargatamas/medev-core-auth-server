<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 13.
 * Time: 15:41
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\Client;


use MedevAuth\Services\Auth\OAuth\Entity;
use MedevAuth\Services\Auth\OAuth\Entity\Persistables\Client;
use MedevSlim\Core\Action\Repository\APIRepositoryAction;
use MedevSlim\Core\Service\Exceptions\UnauthorizedException;
use Medoo\Medoo;

class GetClientData extends APIRepositoryAction
{

    /**
     * @param $args
     * @return Entity\Client
     * @throws UnauthorizedException
     */
    public function handleRequest($args = [])
    {
        $clientId = $args["client_id"]; //Todo move to constant

        $storedData = $this->database->get("OAuth_Clients(c)",
            [
                "[>]OAuth_ClientScopes(cs)" => ["c.Id" => "ClientId"],
                "[>]OAuth_ClientGrantTypes(cg)" => [ "c.Id" => "ClientId" ],
                "[>]OAuth_GrantTypes(g)" => [ "cg.GrantId" => "Id" ],
                "[>]OAuth_Client_LoginTypes(cl)" => [ "c.Id" => "ClientId" ],
                "[>]OAuth_LoginTypes(l)" => [ "cl.LoginId" => "Id" ],
            ],
            array_merge(
                Client::getColumnNames(),
                ["ClientScopes" => Medoo::raw("GROUP_CONCAT(Distinct(<cs.ScopeId>))")],
                ["ClientGrantTypes" => Medoo::raw("GROUP_CONCAT(Distinct(<g.GrantName>))")],
                ["ClientLoginTypes" => Medoo::raw("GROUP_CONCAT(Distinct(<l.LoginName>))")]
            ),
            [
                "c.Id" => $clientId,
                "GROUP" => "c.Id"
            ]
        );


        if(empty($storedData) || is_null($storedData)){
            $result = $this->database->error();
            $this->error(json_encode($result));
            throw new UnauthorizedException("Client ".$clientId." not existing in the database.");
        }

        return Client::fromAssocArray($storedData);
    }


}