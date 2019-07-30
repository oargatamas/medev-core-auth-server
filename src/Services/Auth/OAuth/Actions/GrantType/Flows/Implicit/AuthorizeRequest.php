<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 25.
 * Time: 9:35
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\GrantType\Flows\Implicit;


use MedevAuth\Services\Auth\OAuth\Actions\Client\ValidateClient;
use MedevAuth\Services\Auth\OAuth\Actions\GrantType\AccessGrant\GrantAccess;
use MedevAuth\Services\Auth\OAuth\Actions\GrantType\Authorization\Authorization;
use MedevAuth\Services\Auth\OAuth\Actions\Token\AccessToken\GenerateAccessToken;
use MedevAuth\Services\Auth\OAuth\Entity\Client;
use MedevAuth\Services\Auth\OAuth\Entity\Token\OAuthToken;
use MedevAuth\Services\Auth\OAuth\OAuthService;
use MedevSlim\Core\Service\Exceptions\InternalServerException;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class AuthorizeRequest extends Authorization
{
    protected $scopes;

    public function isLoginRequired(Request $request, $args)
    {
        if (isset($_SESSION["user"])) {
            $this->user = $_SESSION["user"];
            return false;
        }

        return true;
    }

    public function isPermissionRequired(Request $request, $args)
    {
        // TODO: Implement isPermissionRequired() method.
        return false;
    }

    public function verifyClient(Request $request, $args)
    {
        $this->scopes = $request->getParam("scopes");

        $validateClient = new ValidateClient($this->service);
        $validateClient->handleRequest([
            "client" => $this->client,
            "validate_secret" => false,
            "grant_type" => "implicit"
        ]);
    }

    /**
     * @param Response $response
     * @param $args
     * @return ResponseInterface|Response
     * @throws InternalServerException
     */
    public function buildSuccessResponse(Response $response, $args)
    {
        $this->info("Generating access token.");
        $tokenInfo = [
            OAuthToken::USER => $this->user,
            OAuthToken::CLIENT => $this->client,
            OAuthToken::SCOPES => $this->scopes
        ];
        $action = new GenerateAccessToken($this->service);
        $accessToken = $action->handleRequest($tokenInfo);

        $accessToken->setExpiration(600);

        $data = [
            GrantAccess::ACCESS_TOKEN => $accessToken->finalizeToken(),
            GrantAccess::ACCESS_TOKEN_TYPE => "bearer",
            GrantAccess::EXPIRES_IN => $accessToken->getExpiration(),
            OAuthService::CSRF_TOKEN => "" //Todo implement logic behind
        ];


        switch ($this->client->getTokenPlace()){
            case Client::TOKEN_AS_COOKIE : return $this->mapTokensToCookie($response,$data);
            case Client::TOKEN_AS_URL : return $this->mapTokensToUrl($response,$data);
            default : throw new InternalServerException("Token type '". $this->client->getTokenPlace() ."' not implemented for implicit grant.");
        }
    }

}