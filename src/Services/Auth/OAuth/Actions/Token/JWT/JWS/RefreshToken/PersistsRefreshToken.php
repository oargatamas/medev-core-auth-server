<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 03. 01.
 * Time: 16:41
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\Token\JWT\JWS\RefreshToken;


use MedevAuth\Services\Auth\OAuth\Entity\Persistables\RefreshToken;
use MedevAuth\Services\Auth\OAuth\Entity\Token\JWT\Signed\OAuthJWS;
use MedevAuth\Services\Auth\OAuth\Exceptions\OAuthException;
use MedevSlim\Core\Action\Repository\APIRepositoryAction;
use MedevSlim\Core\Database\Medoo\MedooDatabase;

class PersistsRefreshToken extends APIRepositoryAction
{

    /**
     * @param $args
     * @return void
     * @throws \Exception
     */
    public function handleRequest($args = [])
    {
        /** @var OAuthJWS $refreshToken */
        $refreshToken = $args["refresh_token"]; //Todo move to constant

        $this->database->insert(RefreshToken::getTableName(),
            [
                "rt.Id" => $refreshToken->getIdentifier(),
                "rt.UserId" => $refreshToken->getUser()->getIdentifier(),
                "rt.ClientId" => $refreshToken->getClient()->getIdentifier(),
                "rt.IsRevoked" => $refreshToken->isRevoked(),
                "rt.CreatedAt" => $refreshToken->getCreatedAt()->format(MedooDatabase::DEFAULT_DATE_FORMAT),
                "rt.ExpiresAt" => $refreshToken->getExpiresAt()->format(MedooDatabase::DEFAULT_DATE_FORMAT),
            ]
        );

        $result = $this->database->error();
        if(!is_null($result[2])){
            throw new OAuthException("Refresh token ".$refreshToken->getIdentifier()." can not be saved: ".implode(" - ",$result));
        }
    }
}