<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 06. 28.
 * Time: 9:22
 */

namespace MedevAuth\Services\Auth\IdentityProvider\Actions\PasswordRecovery;


use MedevAuth\Services\Auth\OAuth\Entity;
use MedevAuth\Services\Auth\OAuth\Entity\Persistables;
use MedevSlim\Core\Action\Repository\APIRepositoryAction;
use MedevSlim\Core\Service\Exceptions\APIException;

class ChangePassword extends APIRepositoryAction
{

    /**
     * @param $args
     * @throws APIException
     */
    public function handleRequest($args = [])
    {
        /** @var Entity\User $user */
        $user = $args["user"];
        $newPassword = $args["newPassword"];

        $passwordHash = password_hash($newPassword,PASSWORD_BCRYPT,["cost" => 12]);

        $result = $this->database->update(Persistables\User::getTableName(),
            [
                "Password" => $passwordHash
            ],
            [
                "Id" => $user->getIdentifier()
            ]
        );

        $error = $this->database->error();
        if(isset($error[2]) || $result->rowCount() <= 0){
            throw new APIException("Password can not be updated in database: ".implode(" - ",$error));
        }
    }
}