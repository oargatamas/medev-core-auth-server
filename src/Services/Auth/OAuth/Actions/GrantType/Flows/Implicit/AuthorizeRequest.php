<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 25.
 * Time: 9:35
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\GrantType\Flows\Implicit;


use Dflydev\FigCookies\FigResponseCookies;
use Dflydev\FigCookies\SetCookie;
use MedevAuth\Services\Auth\OAuth\Actions\Client\ValidateClient;
use MedevAuth\Services\Auth\OAuth\Actions\GrantType\AccessGrant\GrantAccess;
use MedevAuth\Services\Auth\OAuth\Actions\GrantType\Authorization\Authorization;
use MedevAuth\Services\Auth\OAuth\Actions\Token\AccessToken\GenerateAccessToken;
use MedevAuth\Services\Auth\OAuth\Entity\Token\OAuthToken;
use Slim\Http\Request;
use Slim\Http\Response;

class AuthorizeRequest extends Authorization
{

    const COOKIE_ACCESS_TOKEN = "X-MEDEV-TOKEN";

    private $scopes;

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

        $tokens = [
            GrantAccess::ACCESS_TOKEN => $accessToken->finalizeToken(),
            GrantAccess::ACCESS_TOKEN_TYPE => "bearer",
            GrantAccess::EXPIRES_IN => $accessToken->getExpiration(),
        ];


        $accessTokenCookie = SetCookie::create(self::COOKIE_ACCESS_TOKEN)
            ->withValue($tokens[GrantAccess::ACCESS_TOKEN])
            ->withHttpOnly(true)
            ->withSecure(true)
            ->withDomain($_SERVER["HTTP_HOST"])
            ->withPath("/")
            ->rememberForever();


        $response = $response->withRedirect($this->client->getRedirectUri());

        return  FigResponseCookies::set($response,$accessTokenCookie);
    }


}