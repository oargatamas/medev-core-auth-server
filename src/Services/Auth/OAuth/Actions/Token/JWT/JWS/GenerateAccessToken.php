<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 13.
 * Time: 16:00
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\Token\JWT\JWS;


use MedevAuth\Services\Auth\OAuth\Entity\Client;
use MedevAuth\Services\Auth\OAuth\Entity\User;
use MedevAuth\Token\JWT\JWS\OAuthJWS;
use MedevSlim\Core\Action\Repository\APIRepositoryAction;
use MedevSlim\Utils\UUID\UUID;

class GenerateAccessToken extends APIRepositoryAction
{

    /**
     * @param $args
     * @return OAuthJWS
     */
    public function handleRequest($args)
    {
        /** @var User $user */
        $user = $args["user"]; //Todo move to constant
        /** @var Client $client */
        $client = $args["client"]; //Todo move to constant
        /** @var string[] $scopes */
        $scopes = $args["scopes"]; //Todo move to constant


        $token = new OAuthJWS();

        $token->setIdentifier(UUID::v4()); //Todo double check whether the V4 is fine.
        $token->setUser($user);
        $token->setClient($client);
        $token->setScopes($scopes);
        $token->setPrivateKey($this->config->privateKey); //Todo solve it

        return $token;
    }
}