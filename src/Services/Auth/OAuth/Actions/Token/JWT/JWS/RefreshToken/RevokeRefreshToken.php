<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 13.
 * Time: 16:19
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\Token\JWT\JWS\RefreshToken;


use MedevSlim\Core\Action\Repository\APIRepositoryAction;
use MedevSlim\Core\Service\Exceptions\UnauthorizedException;
use PDOStatement;

class RevokeRefreshToken extends APIRepositoryAction
{

    /**
     * @param $args
     * @return integer
     * @throws UnauthorizedException
     */
    public function handleRequest($args = [])
    {
        $tokenIdentifier = $args["token_id"]; //Todo move to constant

        /** @var PDOStatement $result */
        $result = $this->database->update("OAuth_RefreshTokens",
            [
                "IsRevoked" => true
            ],
            [
                "Id" => $tokenIdentifier
            ]);

        $errors = $this->database->error();
        if(!is_null($errors)){
            $this->error("Refresh token can not be saved to database. Interrupting access grant.");
            throw new UnauthorizedException(implode(" - ",$errors));
        }

        return $result->rowCount();
    }
}