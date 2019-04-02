<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 04. 02.
 * Time: 9:15
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\Token\JWT\JWS\IdToken;


use MedevAuth\Services\Auth\OAuth\Entity\Persistables\IdToken;
use MedevSlim\Core\Action\Repository\APIRepositoryAction;
use MedevSlim\Core\Service\Exceptions\UnauthorizedException;
use PDOStatement;

class RevokeIdToken extends APIRepositoryAction
{

    /**
     * @param $args
     * @return boolean
     * @throws UnauthorizedException
     */
    public function handleRequest($args = [])
    {
        $tokenIdentifier = $args["token_id"]; //Todo move to constant

        /** @var PDOStatement $result */
        $result = $this->database->update(IdToken::getTableName(),
            [
                "IsRevoked" => true
            ],
            [
                "Id" => $tokenIdentifier
            ]);

        $errors = $this->database->error();
        if(isset($errors[2]) || $result->rowCount() <= 0){
            $this->error("id token can not be updated to database. Interrupting access grant.");
            throw new UnauthorizedException(implode(" - ",$errors));
        }

        return $result->rowCount() > 0;
    }
}