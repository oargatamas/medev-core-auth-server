<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 04. 02.
 * Time: 9:51
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\Token\JWT\JWS\IdToken;


use MedevAuth\Services\Auth\OAuth\Entity\Persistables\IdToken;
use MedevAuth\Services\Auth\OAuth\Entity\Token\JWT\Signed\OAuthJWS;
use MedevAuth\Services\Auth\OAuth\Exceptions\OAuthException;
use MedevSlim\Core\Action\Repository\APIRepositoryAction;
use MedevSlim\Core\Database\Medoo\MedooDatabase;


class PersistIdToken extends APIRepositoryAction
{

    /**
     * @param $args
     * @throws \Exception
     */
    public function handleRequest($args = [])
    {
        /** @var OAuthJWS $refreshToken */
        $refreshToken = $args["id_token"]; //Todo move to constant

        $this->database->insert(IdToken::getTableName(),
            [
                "Id" => $refreshToken->getIdentifier(),
                "UserId" => $refreshToken->getUser()->getIdentifier(),
                "ClientId" => $refreshToken->getClient()->getIdentifier(),
                "IsRevoked" => $refreshToken->isRevoked(),
                "CreatedAt" => $refreshToken->getCreatedAt()->format(MedooDatabase::DEFAULT_DATE_FORMAT),
                "ExpiresAt" => $refreshToken->getExpiresAt()->format(MedooDatabase::DEFAULT_DATE_FORMAT),
            ]
        );

        $result = $this->database->error();
        if(!is_null($result[2])){
            throw new OAuthException("Id token ".$refreshToken->getIdentifier()." can not be saved: ".implode(" - ",$result));
        }
    }
}