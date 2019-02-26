<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 24.
 * Time: 19:42
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\GrantType\Flows\Implicit;


use MedevAuth\Services\Auth\OAuth\Actions\GrantType\GrantAccess\GrantAccess;
use MedevAuth\Services\Auth\OAuth\Entity\Token\OAuthToken;
use MedevSlim\Core\Service\Exceptions\UnauthorizedException;
use Slim\Http\Request;

class RequestAccessToken extends GrantAccess
{

    /**
     * @param Request $request
     * @param array $args
     * @return void
     * @throws UnauthorizedException
     */
    public function validateAccessRequest(Request $request, $args = [])
    {
        // TODO: Implement validateAccessRequest() method.
    }

    /**
     * @throws \Exception
     * @return OAuthToken
     */
    public function generateAccessToken()
    {
        // TODO: Implement generateAccessToken() method.
    }
}