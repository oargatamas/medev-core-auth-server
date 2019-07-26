<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 13.
 * Time: 16:00
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\Token\AccessToken;


use MedevAuth\Services\Auth\OAuth\Actions\Token\GenerateToken;
use MedevAuth\Services\Auth\OAuth\Entity\Client;
use MedevAuth\Services\Auth\OAuth\Entity\Token\JWT\Signed\OAuthJWS;
use MedevAuth\Services\Auth\OAuth\Entity\Token\OAuthToken;
use MedevAuth\Services\Auth\OAuth\Entity\User;

class GenerateAccessToken extends GenerateToken
{

    /**
     * @param $args
     * @return OAuthJWS
     * @throws \Exception
     */
    public function handleRequest($args = [])
    {
        $tokenConfig = $this->config["authorization"]["token"];

        /** @var Client $client */
        $client = $args[OAuthToken::CLIENT];
        /** @var User $user */
        $user = $args[OAuthToken::USER];
        $args[OAuthToken::EXPIRATION] = $args[OAuthToken::EXPIRATION] ?? $tokenConfig["expiration"]["access_token"];
        $args[OAuthToken::SCOPES] = $args[OAuthToken::SCOPES] ?? array_intersect($user->getScopes(), $client->getScopes());

        return parent::handleRequest($args);
    }
}