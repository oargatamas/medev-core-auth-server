<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 13.
 * Time: 15:39
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\Scope;


use MedevSlim\Core\Action\Repository\APIRepositoryAction;

class GetRefreshTokenScopes extends APIRepositoryAction
{

    /**
     * @param $args
     * @return string[]
     */
    public function handleRequest($args)
    {
        return ["get:access_token"]; //Todo move to constant
    }
}