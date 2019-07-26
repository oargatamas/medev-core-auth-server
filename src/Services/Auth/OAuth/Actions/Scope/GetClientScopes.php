<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 13.
 * Time: 15:38
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\Scope;


use MedevAuth\Services\Auth\OAuth\Entity\Client;
use MedevSlim\Core\Action\Repository\APIRepositoryAction;

class GetClientScopes extends APIRepositoryAction
{

    /**
     * @param $args
     * @return string[]
     */
    public function handleRequest($args = [])
    {
        /** @var Client $client */
        $client = $args["client"]; //Todo move to constant

        $result = $this->database->select("OAuth_ClientScopes",
            ["ScopeId"],
            ["ClientId" => $client->getIdentifier()]
        );

        $clientScopes = array_reduce($result, 'array_merge', array());;

        return $clientScopes;
    }
}