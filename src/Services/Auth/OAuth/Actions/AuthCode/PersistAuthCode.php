<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 13.
 * Time: 15:24
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\AuthCode;


use MedevAuth\Services\Auth\OAuth\Entity\AuthCode;
use MedevAuth\Services\Auth\OAuth\Repository\Exception\RepositoryException;
use MedevSlim\Core\Action\Repository\APIRepositoryAction;

class PersistAuthCode extends APIRepositoryAction
{

    /**
     * @param $args
     * @return void
     * @throws RepositoryException
     */
    public function handleRequest($args = [])
    {
        /** @var AuthCode $authCode */
        $authCode = $args["authcode"]; //Todo move to constant

        $this->database->insert("OAuth_AuthCodes",[
            "Id" => $authCode->getIdentifier(),
            "ClientId" => $authCode->getClient()->getIdentifier(),
            "RedirectURI" => $authCode->getRedirectUri(),
            "CreatedAt" => $authCode->getCreatedAt(),
            "Expiration" => $authCode->getExpiresAt(),
        ]);

        //Todo test is briefly
        $result = $this->database->error();
        if(!is_null($result)){
            throw new RepositoryException(implode(" - ",$result));
        }
    }
}