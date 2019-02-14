<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 13.
 * Time: 15:41
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\Client;


use MedevAuth\Services\Auth\OAuth\Entity\Client;
use MedevSlim\Core\Action\Repository\APIRepositoryAction;
use MedevSlim\Core\Service\Exceptions\UnauthorizedException;

class GetClientData extends APIRepositoryAction
{

    /**
     * @param $args
     * @return Client
     * @throws UnauthorizedException
     */
    public function handleRequest($args)
    {
        $clientId = $args["client_id"]; //Todo move to constant

        $storedData = $this->database->get("OAuth_Clients",
            ["Id","Name","Secret","RedirectURI","Status"],
            ["Id" => $clientId]
        );

        $grantTypes = $this->database->select("OAuth_ClientGrantTypes", //From Table
            ["[>]OAuth_GrantTypes" => ["GrantId" => "Id"]],     //Table Join section
            ["GrantName"],                                      //Select column list
            ["ClientId" => $clientId]                           //Where condition
        );


        if(empty($storedData) || is_null($storedData)){
            throw new UnauthorizedException("Client ".$clientId." not existing in the database.");
        }

        $clientEntity = new Client();
        $clientEntity->setIdentifier($storedData["Id"]);
        $clientEntity->setName($storedData["Name"]);
        $clientEntity->setRedirectUri($storedData["RedirectURI"]);
        $clientEntity->setSecret($storedData["Secret"]);
        $clientEntity->setGrantTypes($grantTypes);

        return $clientEntity;
    }
}