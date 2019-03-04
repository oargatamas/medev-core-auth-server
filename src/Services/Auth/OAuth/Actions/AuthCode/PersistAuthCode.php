<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 13.
 * Time: 15:24
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\AuthCode;


use MedevAuth\Services\Auth\OAuth\Entity;
use MedevAuth\Services\Auth\OAuth\Entity\Persistables\AuthCode;
use MedevAuth\Services\Auth\OAuth\Exceptions\OAuthException;
use MedevSlim\Core\Action\Repository\APIRepositoryAction;
use MedevSlim\Core\Database\Medoo\MedooDatabase;

class PersistAuthCode extends APIRepositoryAction
{

    /**
     * @param $args
     * @return void
     * @throws OAuthException
     */
    public function handleRequest($args = [])
    {
        /** @var Entity\AuthCode $authCode */
        $authCode = $args["authcode"];
        //Todo move to constant

        $this->database->insert(AuthCode::getTableName(),[
            "a.Id" => $authCode->getIdentifier(),
            "a.UserId" => $authCode->getUser()->getIdentifier(),
            "a.ClientId" => $authCode->getClient()->getIdentifier(),
            "a.RedirectURI" => $authCode->getRedirectUri(),
            "a.IsRevoked" => $authCode->isRevoked(),
            "a.CreatedAt" => $authCode->getCreatedAt()->format(MedooDatabase::DEFAULT_DATE_FORMAT),
            "a.ExpiresAt" => $authCode->getExpiresAt()->format(MedooDatabase::DEFAULT_DATE_FORMAT)
        ]);

        $result = $this->database->error();
        if(!is_null($result[2])){
            throw new OAuthException("Auth code can not be saved: ".implode(" - ",$result));
        }
    }
}