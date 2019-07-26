<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 13.
 * Time: 15:20
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\AuthCode;


use DateTime;
use MedevAuth\Services\Auth\OAuth\Entity\AuthCode;
use MedevAuth\Services\Auth\OAuth\Entity\Client;
use MedevAuth\Services\Auth\OAuth\Entity\User;
use MedevSlim\Core\Action\Repository\APIRepositoryAction;
use MedevSlim\Utils\RandomString;

class GenerateAuthCode extends APIRepositoryAction
{

    /**
     * @param $args
     * @return AuthCode
     * @throws \Exception
     */
    public function handleRequest($args = [])
    {
        /** @var Client $client */
        $client = $args[AuthCode::CLIENT];
        /** @var User $user */
        $user = $args[AuthCode::USER];
        $redirectUri = $args[AuthCode::REDIRECT_URI] ?? $client->getRedirectUri();
        $expiration = $args[AuthCode::EXPIRATION] ?? 300; //Default to 5 minutes

        $authCode = new AuthCode();

        $authCode->setClient($client);
        $authCode->setUser($user);
        $authCode->setIdentifier(RandomString::generate(20));
        $authCode->setCreatedAt(new DateTime());
        $authCode->setExpiresAt(new DateTime("+".$expiration." seconds"));
        $authCode->setRedirectUri($redirectUri);
        $authCode->setIsRevoked(false);

        return $authCode;
    }
}