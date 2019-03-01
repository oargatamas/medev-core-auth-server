<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 20.
 * Time: 16:32
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\AuthCode;


use DateTime;
use MedevAuth\Services\Auth\OAuth\Actions\Client\GetClientData;
use MedevAuth\Services\Auth\OAuth\Actions\User\GetUserData;
use MedevAuth\Services\Auth\OAuth\Entity\AuthCode;
use MedevSlim\Core\Action\Repository\APIRepositoryAction;

class GetAuthCodeData extends APIRepositoryAction
{

    /**
     * @param $args
     * @return AuthCode
     * @throws \Exception
     */
    public function handleRequest($args = [])
    {
        $authCodeId = $args["auth_code_id"];

        $storedData = $this->database->get("OAuth_AuthCodes",
            ["Id","UserId","ClientId","RedirectURI","IsRevoked","CreatedAt","ExpiresAt"],
            ["Id" => $authCodeId]
        );

        $getUserData = new GetUserData($this->service);
        $getClientData = new GetClientData($this->service);

        $authCode = new AuthCode();
        $authCode->setIdentifier($storedData["Id"]);
        $authCode->setRedirectUri($storedData["RedirectURI"]);
        $authCode->setCreatedAt(new DateTime($storedData["CreatedAt"]));
        $authCode->setExpiresAt(new DateTime($storedData["ExpiresAt"]));
        $authCode->setIsRevoked($storedData["IsRevoked"]);
        $authCode->setUser($getUserData->handleRequest(["user_id" => $storedData["UserId"]]));
        $authCode->setClient($getClientData->handleRequest(["client_id" => $storedData["ClientId"]]));

        return $authCode;
    }
}