<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 15.
 * Time: 11:54
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\Token\JWT\JWS;


use Lcobucci\JWT\Signer\Key;
use MedevAuth\Services\Auth\OAuth\Entity\Client;
use MedevAuth\Services\Auth\OAuth\Entity\Token\JWT\Signed\OAuthJWS;
use MedevAuth\Services\Auth\OAuth\Entity\User;
use MedevAuth\Utils\CryptUtils;
use MedevSlim\Core\Action\Repository\APIRepositoryAction;
use MedevSlim\Utils\UUID\UUID;

abstract class GenerateToken extends APIRepositoryAction
{
    public function handleRequest($args)
    {
        /** @var User $user */
        $user = $args["user"]; //Todo move to constant
        /** @var Client $client */
        $client = $args["client"]; //Todo move to constant
        /** @var string[] $scopes */
        $scopes = $args["scopes"]; //Todo move to constant
        /** @var Key $tokenPrivateKey */
        $tokenSigningKey = CryptUtils::getKeyFromConfig($this->config["auth"]["token"]["private_key"]);

        $token = new OAuthJWS();

        $token->setIdentifier(UUID::v4());
        $token->setUser($user);
        $token->setClient($client);
        $token->setScopes($scopes);
        $token->setPrivateKey($tokenSigningKey);

        return $token;
    }

}