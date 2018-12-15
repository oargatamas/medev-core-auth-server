<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 14.
 * Time: 14:16
 */

namespace MedevAuth\Services\Auth\OAuth\GrantType\AuthCode;


use MedevAuth\Services\Auth\OAuth\GrantType\GrantType;
use Slim\Http\Request;
use Slim\Http\Response;

class AuthorizationCodeGrant extends GrantType
{

    public function getName()
    {
       return "authorization_code";
    }

    protected function validateRequest(Request $request)
    {
        // TODO: Implement validateRequest() method.
    }

    protected function grantAccess(Response $response, $args = [])
    {
        // TODO: Implement grantAccess() method.
    }
}