<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 13.
 * Time: 16:15
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\GrantType\Flows\AuthCode;


use MedevAuth\Services\Auth\OAuth\Actions\AuthCode\GenerateAuthCode;
use MedevAuth\Services\Auth\OAuth\Actions\Client\ValidateClient;
use MedevAuth\Services\Auth\OAuth\Actions\GrantType\Authorization\Authorization;
use MedevAuth\Services\Auth\OAuth\Entity\AuthCode;
use Slim\Http\Request;
use Slim\Http\Response;

class AuthorizeRequest extends Authorization
{

    public function isLoginRequired(Request $request, $args)
    {
        if (isset($_SESSION["user"])) {
            $this->user = $_SESSION["user"];
            return false;
        }

        return true;
    }

    public function verifyClient(Request $request, $args)
    {
        $validateClient = new ValidateClient($this->service);
        $validateClient->handleRequest([
            "client" => $this->client,
            "validate_secret" => true,
        ]);
    }

    public function buildSuccessResponse(Response $response, $args)
    {
        $getAuthCode = new GenerateAuthCode($this->service);
        /** @var AuthCode $authCode */
        $authCode = $getAuthCode->handleRequest(["client" => $this->client]);


        $data = [
            "code" => $authCode->getIdentifier(),
            "state" => $this->csrfToken
        ];

        return $response->withJson($data, 200);
    }

    static function getParams()
    {
        return array_merge(parent::getParams(), ["client_secret"]);
    }


}