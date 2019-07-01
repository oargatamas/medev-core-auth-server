<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 06. 28.
 * Time: 9:23
 */

namespace MedevAuth\Services\Auth\IdentityProvider\Actions\PasswordRecovery;


use MedevSlim\Core\Action\Repository\APIRepositoryAction;
use MedevSlim\Core\Service\Exceptions\BadRequestException;

class ValidatePasswords extends APIRepositoryAction
{

    /**
     * @param $args
     * @return mixed
     * @throws BadRequestException
     */
    public function handleRequest($args = [])
    {
        //Todo implement localization/language support.
        $newPassword = $args["newPassword"];
        $newPasswordAgain = $args["newPasswordAgain"];

        if($newPassword != $newPasswordAgain){
            throw new BadRequestException("Passwords did not match.",true);
        }

        if(strlen($newPassword) < 8){
            throw new BadRequestException("Password length must be at least 8 chars.",true);
        }

        if(!preg_match("#[0-9]+#", $newPassword)){
            throw new BadRequestException("Password must contain at least one number.",true);
        }

        if(!preg_match("#[a-zA-Z]+#", $newPassword)){
            throw new BadRequestException("Password must contain at least one letter.",true);
        }
    }
}