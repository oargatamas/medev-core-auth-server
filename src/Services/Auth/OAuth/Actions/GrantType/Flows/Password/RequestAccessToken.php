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
use MedevAuth\Services\Auth\OAuth\Actions\User\ValidateUser;
use MedevAuth\Services\Auth\OAuth\Entity\Token\OAuthToken;
use MedevAuth\Services\Auth\OAuth\Entity\User;
use MedevSlim\Core\Service\Exceptions\UnauthorizedException;
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
        $userId = $userValidation->handleRequest($userCredentials);


        $this->user = new User();
        $this->user->setIdentifier($userId);
        $this->user->setUsername($username);
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