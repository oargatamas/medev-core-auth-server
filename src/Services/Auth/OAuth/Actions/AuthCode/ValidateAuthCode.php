<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 13.
 * Time: 15:28
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\AuthCode;


use DateTime;
use MedevAuth\Services\Auth\OAuth\Entity\AuthCode;
use MedevAuth\Services\Auth\OAuth\Repository\Exception\RepositoryException;
use MedevSlim\Core\Action\Repository\APIRepositoryAction;
use MedevSlim\Core\Service\Exceptions\UnauthorizedException;

class ValidateAuthCode extends APIRepositoryAction
{

    /**
     * @param $args
     * @return void
     * @throws \Exception
     */
    public function handleRequest($args = [])
    {
        /** @var AuthCode $authCode */
        $authCode = $args["authCode"]; //Todo move to constant

        if($authCode->isRevoked()){
            throw new UnauthorizedException("Auth code ".$authCode->getIdentifier()." revoked already.");
        }

        if($authCode->getExpiresAt() < new DateTime()){
            throw new UnauthorizedException("Auth code".$authCode->getIdentifier()." expired.");
        }
    }
}