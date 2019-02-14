<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 13.
 * Time: 15:41
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\Client;


use MedevAuth\Services\Auth\OAuth\Entity\Client;
use MedevAuth\Services\Auth\OAuth\Repository\Exception\RepositoryException;
use MedevSlim\Core\Action\Repository\APIRepositoryAction;

class GetClientData extends APIRepositoryAction
{

    /**
     * @param $args
     * @return Client
     * @throws RepositoryException
     */
    public function handleRequest($args)
    {
        $clientIdentifier = $args["client_id"]; //Todo move to constant

        $storedData = $this->db->get("OAuth_Clients",
            [
                "Id","Name","Secret","RedirectURI","Status"
            ],
            [
                "Id" => $clientIdentifier
            ]
        );

        //Todo test it briefly
        if(empty($storedData) || is_null($storedData)){
            throw new RepositoryException("Client ".$clientIdentifier." not existing in the database.");
        }

        $clientEntity = new Client();
        $clientEntity->setIdentifier($storedData["Id"]);
        $clientEntity->setName($storedData["Name"]);
        $clientEntity->setRedirectUri($storedData["RedirectURI"]);
        $clientEntity->setSecret($storedData["Secret"]);

        return $clientEntity;
    }
}