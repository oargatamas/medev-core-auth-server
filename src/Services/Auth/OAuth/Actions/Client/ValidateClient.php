<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 13.
 * Time: 15:42
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\Client;


use MedevAuth\Services\Auth\OAuth\Entity\Client;
use MedevSlim\Core\Action\Repository\APIRepositoryAction;
use MedevSlim\Core\Service\Exceptions\UnauthorizedException;

class ValidateClient extends APIRepositoryAction
{

    /**
     * @param $args
     * @return void
     * @throws UnauthorizedException
     */
    public function handleRequest($args = [])
    {
        /** @var Client $client */
        $client = $args["client"]; //Todo move to constant;
        $validateSecret = $args["validate_secret"] ?? true; //Todo move to constant
        $grantType = $args["grant_type"]; //Todo move to constant

        $storedData = $this->database->get("OAuth_Clients",
            ["Secret"],
            ["Id" => $client->getIdentifier()]
        );

        if(!$storedData || empty($storedData) || is_null($storedData)){
            throw new UnauthorizedException("Client not registered");
        }

        if(!$client->hasGrantType($grantType)){
            throw new UnauthorizedException($grantType." grant type not registered for Client ".$client->getName().".");
        }

        if($validateSecret && !password_verify($client->getSecret(),$storedData["Secret"])){
            throw new UnauthorizedException("Provided secret is invalid for Client.");
        }
    }
}