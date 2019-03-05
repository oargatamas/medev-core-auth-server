<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 24.
 * Time: 19:42
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\GrantType\Flows\ClientCredentials;


use MedevAuth\Services\Auth\OAuth\Actions\GrantType\AccessGrant\GrantAccess;
use MedevAuth\Services\Auth\OAuth\Actions\Token\JWT\JWS\AccessToken\GenerateAccessToken;
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
        parent::validateAccessRequest($request, $args);
    }

    /**
     * @throws \Exception
     * @return OAuthToken
     */
    public function generateAccessToken()
    {
        $tokenInfo = [
            OAuthToken::USER => $this->user,
            OAuthToken::CLIENT => $this->client,
            OAuthToken::SCOPES => $this->scopes
        ];
        $action = new GenerateAccessToken($this->service);
        $accessToken = $action->handleRequest($tokenInfo);

        return $accessToken;
    }
}