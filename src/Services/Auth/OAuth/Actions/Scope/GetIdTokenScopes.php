<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 04. 02.
 * Time: 9:41
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\Scope;


use MedevSlim\Core\Action\Repository\APIRepositoryAction;

class GetIdTokenScopes extends APIRepositoryAction
{

    /**
     * @param $args
     * @return mixed
     */
    public function handleRequest($args = [])
    {
        return ["get:auth_code"]; //Todo move to constant
    }
}