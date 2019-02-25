<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 20.
 * Time: 14:00
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\GrantType\Password;


use MedevAuth\Services\Auth\OAuth\Actions\GrantType\GrantAccess;
use MedevAuth\Services\Auth\OAuth\Actions\Token\JWT\JWS\AccessToken\GenerateAccessToken;
use MedevAuth\Services\Auth\OAuth\Actions\Token\JWT\JWS\RefreshToken\GenerateRefreshToken;
use MedevAuth\Services\Auth\OAuth\Actions\User\ValidateUser;
use MedevAuth\Services\Auth\OAuth\Entity\Token\OAuthToken;
use MedevSlim\Core\Service\Exceptions\UnauthorizedException;
use Slim\Http\Request;

/**
 * Class RequestAccessToken
 * @package MedevAuth\Services\Auth\OAuth\Actions\GrantType\Password
 */
class RequestAccessToken extends GrantAccess
{

    /**
     * @param Request $request
     * @param array $args
     * @return void
     * @throws UnauthorizedException
     * @throws \Exception
     */
    public function validateAccessRequest(Request $request, $args = [])
    {
        $userValidation = new ValidateUser($this->service);
        $userCredentials = [
            "username" => $request->getParam("username"),
            "password" => $request->getParam("password")
        ];
        $userValidation->handleRequest($userCredentials);
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

    /**
     * @return OAuthToken
     * @throws \Exception
     */
    public function generateRefreshToken()
    {
        $tokenInfo = [
            OAuthToken::USER => $this->user,
            OAuthToken::CLIENT => $this->client
        ];
        $action = new GenerateRefreshToken($this->service);
        $refreshToken = $action->handleRequest($tokenInfo);

        return $refreshToken;
    }

    /**
     * @return array|string[]
     */
    static function getParams()
    {
        return array_merge(parent::getParams(),[
            "username",
            "password"
        ]);
    }


}