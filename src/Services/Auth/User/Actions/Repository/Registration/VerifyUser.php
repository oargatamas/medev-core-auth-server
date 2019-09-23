<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 09. 23.
 * Time: 13:55
 */

namespace MedevAuth\Services\Auth\User\Actions\Repository\Registration;

use MedevAuth\Services\Auth\OAuth\Entity;
use MedevAuth\Services\Auth\OAuth\Entity\Persistables\User;
use MedevSlim\Core\Action\Repository\APIRepositoryAction;
use MedevSlim\Core\Service\Exceptions\InternalServerException;

class VerifyUser extends APIRepositoryAction
{
    const USER_INFO = "userInfo";

    /**
     * @param $args
     * @throws InternalServerException
     */
    public function handleRequest($args = [])
    {
        /** @var Entity\User $user */
        $user = $args[self::USER_INFO];

        $result = $this->database->update(User::getTableName(),
            [
                "Disabled" => false,
                "Verified" => true,
            ],
            ["UserName" => $user->getUsername()]
        );

        $error = $this->database->error();
        if($result->rowCount() === 0 || !is_null($error[2])){
            throw new InternalServerException("User data can not be updated: ".implode(" - ",$error));
        }
    }
}