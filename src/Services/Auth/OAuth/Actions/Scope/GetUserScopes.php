<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 13.
 * Time: 15:36
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\Scope;


use MedevAuth\Services\Auth\OAuth\Entity\User;
use MedevSlim\Core\Action\Repository\APIRepositoryAction;

class GetUserScopes extends APIRepositoryAction
{

    /**
     * @param $args
     * @return string[]
     */
    public function handleRequest($args)
    {
        /** @var User $user */
        $user = $args["user"]; //Todo move to constant

        $result = $this->database->select("OAuth_UserScopes",
            ["ScopeId"],
            ["UserId" => $user->getIdentifier()]
        );

        $userScopes = array_reduce($result, 'array_merge', array());;

        return $userScopes;
    }
}