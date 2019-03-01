<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 13.
 * Time: 16:48
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\Token\JWT\JWS\AccessToken;


use MedevSlim\Core\Action\Repository\APIRepositoryAction;

class RevokeAccessToken extends APIRepositoryAction
{


    /**
     * @param $args
     * @return boolean
     */
    public function handleRequest($args = [])
    {
        // We do not need to revoke access tokens due to their short living
        // If yes, then the DB Update should be performed here...
        return true;
    }
}