<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 15.
 * Time: 11:54
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\Token\JWT\JWS;


use DateTime;
use MedevAuth\Services\Auth\OAuth\Entity\Client;
use MedevAuth\Services\Auth\OAuth\Entity\Token\JWT\Signed\OAuthJWS;
use MedevAuth\Services\Auth\OAuth\Entity\Token\OAuthToken;
use MedevAuth\Services\Auth\OAuth\Entity\User;
use MedevAuth\Utils\CryptUtils;
use MedevSlim\Core\Action\Repository\APIRepositoryAction;
use MedevSlim\Utils\UUID\UUID;
use phpseclib\Crypt\RSA;

abstract class GenerateToken extends APIRepositoryAction
{
    /**
     * @param array $args
     * @return OAuthJWS
     * @throws \Exception
     */
    public function handleRequest($args = [])
    {
        $tokenConfig = $this->config["authorization"]["token"];

        /** @var User $user */
        $user = $args[OAuthToken::USER];
        /** @var Client $client */
        $client = $args[OAuthToken::CLIENT];
        /** @var string[] $scopes */
        $scopes = $args[OAuthToken::SCOPES];
        /** @var RSA $tokenSigningKey */
        $tokenSigningKey = CryptUtils::getRSAKeyFromConfig($tokenConfig["private_key"]);
        /** @var OAuthJWS $token */
        $token = new OAuthJWS();

        $expiration = $args[OAuthToken::EXPIRATION];

        $token->setIdentifier(UUID::v4());
        $token->setUser($user);
        $token->setClient($client);
        $token->setScopes($scopes);
        $token->setCreatedAt(new DateTime());
        $token->setExpiration($expiration);
        $token->setIsRevoked(false);
        $token->setPrivateKey($tokenSigningKey);

        return $token;
    }

}