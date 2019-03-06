<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 13.
 * Time: 15:27
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\AuthCode;


use MedevAuth\Services\Auth\OAuth\Entity\Persistables\AuthCode;
use MedevAuth\Services\Auth\OAuth\Exceptions\OAuthException;
use MedevSlim\Core\Action\Repository\APIRepositoryAction;

class RevokeAuthCode extends APIRepositoryAction
{

    /**
     * @param $args
     * @return void
     * @throws OAuthException
     */
    public function handleRequest($args = [])
    {
        $authCodeId = $args["authcode_id"]; //Todo move to constant

        $result = $this->database->update(AuthCode::getTableName(),
            [
                "IsRevoked" => true
            ],
            [
                "Id" => $authCodeId
            ]);

        $error = $this->database->error();
        if(isset($error[2]) || $result->rowCount() <= 0){
            throw new OAuthException("Auth code can not be revoked: ".implode(" - ",$error));
        }
    }
}