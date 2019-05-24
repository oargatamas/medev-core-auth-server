<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 20.
 * Time: 14:00
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\GrantType\Flows\Password;


use MedevAuth\Services\Auth\OAuth\Actions\GrantType\AccessGrant\GrantAccess;
use MedevAuth\Services\Auth\OAuth\Actions\Token\JWT\JWS\AccessToken\GenerateAccessToken;
use MedevAuth\Services\Auth\OAuth\Actions\Token\JWT\JWS\RefreshToken\GenerateRefreshToken;
use MedevAuth\Services\Auth\OAuth\Actions\Token\JWT\JWS\RefreshToken\PersistsRefreshToken;
use MedevAuth\Services\Auth\OAuth\Actions\User\ValidateUser;
use MedevAuth\Services\Auth\OAuth\Entity\Token\OAuthToken;
use Slim\Http\Request;

/**
 * Class RequestAccessToken
 * @package MedevAuth\Services\Auth\OAuth\Actions\GrantType\Password
 */
class RequestAccessToken extends GrantAccess
{
    /**
     * @inheritDoc
     */
    public function validateAccessRequest(Request $request, $args = [])
    {
        parent::validateAccessRequest($request, $args);

        $username = $request->getParam("username");
        $password = $request->getParam("password");

        $userValidation = new ValidateUser($this->service);
        $userCredentials = [
            "username" => $username,
            "password" => $password
        ];
        $this->user = $userValidation->handleRequest($userCredentials);
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
        $this->info("Generating access token.");
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
        $this->info("Generating refresh token.");
        $action = new GenerateRefreshToken($this->service);
        $refreshToken = $action->handleRequest($tokenInfo);

        $this->info("Persisting refresh token.");
        $saveToken = new PersistsRefreshToken($this->service);
        $saveToken->handleRequest(["refresh_token" => $refreshToken]);

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