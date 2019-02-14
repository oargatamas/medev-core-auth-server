<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 13.
 * Time: 16:20
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\Token\JWT\JWS\RefreshToken;



use Lcobucci\JWT\Signer\Key;
use MedevAuth\Services\Auth\OAuth\Actions\Scope\GetRefreshTokenScopes;
use MedevAuth\Services\Auth\OAuth\Entity\Client;
use MedevAuth\Services\Auth\OAuth\Entity\Token\JWT\Signed\OAuthJWS;
use MedevAuth\Services\Auth\OAuth\Entity\User;
use MedevAuth\Utils\CryptUtils;
use MedevSlim\Core\Action\Repository\APIRepositoryAction;
use MedevSlim\Utils\UUID\UUID;

class GenerateRefreshToken extends APIRepositoryAction
{

    /**
     * @param $args
     * @return OAuthJWS
     * @throws \Exception
     */
    public function handleRequest($args)
    {
        /** @var User $user */
        $user = $args["user"]; //Todo move to constant
        /** @var Client $client */
        $client = $args["client"]; //Todo move to constant
        /** @var string[] $scopes */
        $scopes = (new GetRefreshTokenScopes($this->service))->handleRequest($args);
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