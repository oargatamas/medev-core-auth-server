<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 06. 28.
 * Time: 9:23
 */

namespace MedevAuth\Services\Auth\IdentityProvider\Actions\PasswordRecovery;


use MedevSlim\Core\Action\Repository\APIRepositoryAction;

class ValidatePasswords extends APIRepositoryAction
{

    /**
     * @param $args
     * @return string[]
     */
    public function handleRequest($args = [])
    {
        //Todo implement localization/language support.
        $newPassword = $args["newPassword"];
        $newPasswordAgain = $args["newPasswordAgain"];

        $errors = [];

        if($newPassword != $newPasswordAgain){
            $errors[] = "Passwords did not match.";
        }

        if(strlen($newPassword) < 8){
            $errors[] = "Password length must be at least 8 chars.";
        }

        if(!preg_match("#[0-9]+#", $newPassword)){
            $errors[] = "Password must contain at least one number.";
        }

        if(!preg_match("#[a-zA-Z]+#", $newPassword)){
            $errors[] = "Password must contain at least one letter.";
        }

        return [
            "PasswordValid" => count($errors) == 0,
            "Errors" => $errors
        ];
    }
}