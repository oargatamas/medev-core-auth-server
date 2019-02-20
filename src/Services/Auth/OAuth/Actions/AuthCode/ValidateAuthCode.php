<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 13.
 * Time: 15:28
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\AuthCode;


use MedevAuth\Services\Auth\OAuth\Entity\AuthCode;
use MedevAuth\Services\Auth\OAuth\Repository\Exception\RepositoryException;
use MedevSlim\Core\Action\Repository\APIRepositoryAction;

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
        $authCode = $args["authcode"]; //Todo move to constant

        $result = $this->database->has("OAuth_AuthCodes",
            [
                "Id" => $authCode->getIdentifier(),
                "IsRevoked" => false,
                "ExpiresAt[>]" => date('Y\-m\-d\ h:i:s')
            ]);
        //Todo add info to log
        if(!$result){
            throw new RepositoryException("Authcode ".$authCode->getIdentifier()." not valid.");
        }
    }
}