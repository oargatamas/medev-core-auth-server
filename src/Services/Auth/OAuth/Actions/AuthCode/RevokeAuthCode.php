<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 13.
 * Time: 15:27
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\AuthCode;


use MedevAuth\Services\Auth\OAuth\Repository\Exception\RepositoryException;
use MedevSlim\Core\Action\Repository\APIRepositoryAction;

class RevokeAuthCode extends APIRepositoryAction
{

    /**
     * @param $args
     * @return void
     * @throws RepositoryException
     */
    public function handleRequest($args)
    {
        $codeIdentifier = $args["authcode_id"]; //Todo move to constant

        $this->database->update("OAuth_AuthCodes",
            [
                "IsRevoked" => true
            ],
            [
                "Id" => $codeIdentifier
            ]);

        //Todo test is briefly
        $result = $this->database->error();
        if(!is_null($result)){
            throw new RepositoryException(implode(" - ",$result));
        }
    }
}