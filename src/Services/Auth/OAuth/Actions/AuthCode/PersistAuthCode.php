<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 13.
 * Time: 15:24
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\AuthCode;


use MedevAuth\Services\Auth\OAuth\Entity\AuthCode;
use MedevAuth\Services\Auth\OAuth\Exceptions\OAuthException;
use MedevAuth\Services\Auth\OAuth\Repository\Exception\RepositoryException;
use MedevSlim\Core\Action\Repository\APIRepositoryAction;

class PersistAuthCode extends APIRepositoryAction
{

    /**
     * @param $args
     * @return void
     * @throws OAuthException
     */
    public function handleRequest($args = [])
    {
        /** @var AuthCode $authCode */
        $authCode = $args["authcode"]; //Todo move to constant

        $this->database->insert("OAuth_AuthCodes",[
            "Id" => $authCode->getIdentifier(),
            "UserId" => $authCode->getUser()->getIdentifier(),
            "ClientId" => $authCode->getClient()->getIdentifier(),
            "RedirectURI" => $authCode->getRedirectUri(),
            "IsRevoked" => $authCode->isRevoked(),
            "CreatedAt" => $authCode->getCreatedAt(),
            "Expiration" => $authCode->getExpiresAt(),
        ]);

        //Todo test is briefly
        $result = $this->database->error();
        if(is_null($result)){
            throw new OAuthException("Auth code can not be saved: ".implode(" - ",$result));
        }
    }
}