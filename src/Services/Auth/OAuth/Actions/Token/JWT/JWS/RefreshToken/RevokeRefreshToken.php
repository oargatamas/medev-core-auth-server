<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 13.
 * Time: 16:19
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\Token\JWT\JWS\RefreshToken;


use MedevAuth\Services\Auth\OAuth\Entity\Persistables\RefreshToken;
use MedevSlim\Core\Action\Repository\APIRepositoryAction;
use MedevSlim\Core\Service\Exceptions\UnauthorizedException;
use PDOStatement;

class RevokeRefreshToken extends APIRepositoryAction
{

    /**
     * @param $args
     * @return boolean
     * @throws UnauthorizedException
     */
    public function handleRequest($args = [])
    {
        //Todo add log entries
        $tokenIdentifier = $args["token_id"]; //Todo move to constant

        /** @var PDOStatement $result */
        $result = $this->database->update(RefreshToken::getTableName(),
            [
                "IsRevoked" => true
            ],
            [
                "Id" => $tokenIdentifier
            ]);

        $errors = $this->database->error();
        if(isset($errors[2]) || $result->rowCount() <= 0){
            $this->error("Refresh token can not be updated to database. Interrupting access grant.");
            throw new UnauthorizedException(implode(" - ",$errors));
        }

        return $result->rowCount() > 0;
    }
}