<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 15.
 * Time: 13:56
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\GrantType\Flows\AuthCode;

use MedevAuth\Services\Auth\OAuth\Actions\AuthCode\GetAuthCodeData;
use MedevAuth\Services\Auth\OAuth\Actions\AuthCode\RevokeAuthCode;
use MedevAuth\Services\Auth\OAuth\Actions\AuthCode\ValidateAuthCode;
use MedevAuth\Services\Auth\OAuth\Actions\GrantType\AccessGrant\GrantAccess;
use MedevAuth\Services\Auth\OAuth\Actions\Token\JWT\JWS\AccessToken\GenerateAccessToken;
use MedevAuth\Services\Auth\OAuth\Actions\Token\JWT\JWS\RefreshToken\GenerateRefreshToken;
use MedevAuth\Services\Auth\OAuth\Entity\AuthCode;
use MedevAuth\Services\Auth\OAuth\Entity\Token\OAuthToken;
use MedevSlim\Core\Service\Exceptions\UnauthorizedException;
use Slim\Http\Request;


class RequestAccessToken extends GrantAccess
{

    /**
     * @var AuthCode
     */
    private $authCode;

    /**
     * @param Request $request
     * @param array $args
     * @return void
     * @throws UnauthorizedException
     */
    public function validateAccessRequest(Request $request, $args = [])
    {
        parent::validateAccessRequest($request,$args);

        $getAuthCodeData = new GetAuthCodeData($this->service);
        $this->authCode = $getAuthCodeData->handleRequest(["auth_code_id" => $request->getParam("code")]);

        $this->user = $this->authCode->getUser();

        $validateAuthCode = new ValidateAuthCode($this->service);
        $validateAuthCode->handleRequest(["authcode" => $this->authCode]);
    }

    /**
     * @throws \Exception
     * @return OAuthToken
     */
    public function generateAccessToken()
    {
        $this->info("Generating access token.");
        $tokenInfo = [
            OAuthToken::USER => $this->user,
            OAuthToken::CLIENT => $this->client,
            OAuthToken::SCOPES => $this->scopes
        ];
        $action = new GenerateAccessToken($this->service);
        $accessToken = $action->handleRequest($tokenInfo);
        return  $accessToken;
    }

    /**
     * @return OAuthToken
     * @throws \Exception
     */
    public function generateRefreshToken()
    {
        $this->info("Generating refresh token.");
        $tokenInfo = [
            OAuthToken::USER => $this->user,
            OAuthToken::CLIENT => $this->client
        ];
        $action = new GenerateRefreshToken($this->service);
        $refreshToken = $action->handleRequest($tokenInfo);
        return  $refreshToken;
    }

    public function invalidateAuthData()
    {
        $this->info("Revoking authorization code to prevent multiple usage.");
        $action = new RevokeAuthCode($this->service);
        $action->handleRequest(["authcode_id" => $this->authCode->getIdentifier()]);
    }


    /**
     * @return array|string[]
     */
    static function getParams()
    {
        return array_merge(parent::getParams(),[
            "code",
            "redirect_uri",
            "client_secret"
        ]);
    }
}