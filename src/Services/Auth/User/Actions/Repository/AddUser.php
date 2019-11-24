<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 09. 20.
 * Time: 15:46
 */

namespace MedevAuth\Services\Auth\User\Actions\Repository;


use DateTime;
use MedevAuth\Services\Auth\OAuth\Entity;
use MedevAuth\Services\Auth\OAuth\Entity\Persistables\User;
use MedevSlim\Core\Action\Repository\APIRepositoryAction;
use MedevSlim\Core\Database\Medoo\MedooDatabase;
use MedevSlim\Core\Service\Exceptions\InternalServerException;

class AddUser extends APIRepositoryAction
{
    const USER_INFO = "userInfo";
    const PASSWORD = "password";

    /**
     * @param $args
     * @return mixed
     * @throws InternalServerException
     * @throws \Exception
     */
    public function handleRequest($args = [])
    {
        /** @var Entity\User $user */
        $user = $args[self::USER_INFO];
        $password = $args[self::PASSWORD];
        $now = new DateTime();

        $this->database->insert(User::getTableName(),[
            "UserName" => $user->getUsername(),
            "FirstName" => $user->getFirstName(),
            "LastName" => $user->getLastName(),
            "Email" => $user->getEmail(),
            "Password" => password_hash($password,PASSWORD_BCRYPT,["cost" => 12]),
            "Verified" => $user->isVerified(),
            "Disabled" => $user->isDisabled(),
            "Created" => $now->format(MedooDatabase::DEFAULT_DATE_FORMAT),
            "Updated" => $now->format(MedooDatabase::DEFAULT_DATE_FORMAT)
        ]);

        $result = $this->database->error();
        if(!is_null($result[2])){
            throw new InternalServerException("User data can not be saved: ".implode(" - ",$result));
        }
    }
}