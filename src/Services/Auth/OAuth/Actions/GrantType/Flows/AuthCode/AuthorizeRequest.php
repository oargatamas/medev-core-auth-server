<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 13.
 * Time: 16:15
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\GrantType\Flows\AuthCode;


use MedevAuth\Services\Auth\OAuth\Actions\AuthCode\GenerateAuthCode;
use MedevAuth\Services\Auth\OAuth\Actions\AuthCode\PersistAuthCode;
use MedevAuth\Services\Auth\OAuth\Actions\Client\ValidateClient;
use MedevAuth\Services\Auth\OAuth\Actions\GrantType\Authorization\Authorization;
use MedevAuth\Services\Auth\OAuth\Entity\AuthCode;
use Slim\Http\Request;
use Slim\Http\Response;

class AuthorizeRequest extends Authorization
{

    public function isLoginRequired(Request $request, $args)
    {
        if (isset($_SESSION["user"])) { //Todo move to constant
            $this->user = $_SESSION["user"];
            return false;
        }

        return true;
    }

    public function isPermissionRequired(Request $request, $args)
    {
        //TODO Drop a view for user in case of missing scope.
        return false;
    }

    public function verifyClient(Request $request, $args)
    {
        $validateClient = new ValidateClient($this->service);
        $validateClient->handleRequest([
            "client" => $this->client,
            "validate_secret" => false,
            "grant_type" => "authorization_code"
        ]);
    }

    public function buildSuccessResponse(Response $response, $args)
    {
        $getAuthCode = new GenerateAuthCode($this->service);
        /** @var AuthCode $authCode */
        $authCode = $getAuthCode->handleRequest(["client" => $this->client]);
        $authCode->setUser($_SESSION["user"]);

        $storeAuthCode = new PersistAuthCode($this->service);
        $storeAuthCode->handleRequest(["authcode" => $authCode]);

        $redirectUri = $authCode->getRedirectUri();

        $data = [
            "code" => $authCode->getIdentifier(),
            "state" => $this->csrfToken
        ];

        return $response->withRedirect($redirectUri."?".http_build_query($data,"","&",PHP_QUERY_RFC3986));
    }
}