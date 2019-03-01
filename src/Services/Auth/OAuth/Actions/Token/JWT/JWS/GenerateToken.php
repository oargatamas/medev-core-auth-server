<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 15.
 * Time: 11:54
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\Token\JWT\JWS;


use DateTime;
use Lcobucci\JWT\Signer\Key;
use MedevAuth\Services\Auth\OAuth\Entity\Client;
use MedevAuth\Services\Auth\OAuth\Entity\Token\JWT\Signed\OAuthJWS;
use MedevAuth\Services\Auth\OAuth\Entity\Token\OAuthToken;
use MedevAuth\Services\Auth\OAuth\Entity\User;
use MedevAuth\Utils\CryptUtils;
use MedevSlim\Core\Action\Repository\APIRepositoryAction;
use MedevSlim\Utils\UUID\UUID;

abstract class GenerateToken extends APIRepositoryAction
{
    public function handleRequest($args = [])
    {
        $tokenConfig = $this->config["authorization"]["token"];

        /** @var User $user */
        $user = $args[OAuthToken::USER]; //Todo move to constant
        /** @var Client $client */
        $client = $args[OAuthToken::CLIENT]; //Todo move to constant
        /** @var string[] $scopes */
        $scopes = $args[OAuthToken::SCOPES]; //Todo move to constant
        /** @var Key $tokenPrivateKey */
        $tokenSigningKey = CryptUtils::getKeyFromConfig($tokenConfig["private_key"]);

        $token = new OAuthJWS();

        $token->setIdentifier(UUID::v4());
        $token->setUser($user);
        $token->setClient($client);
        $token->setScopes($scopes);
        $token->setCreatedAt(new DateTime());
        $token->setIsRevoked(false);
        $token->setExpiration($tokenConfig["expiration"]["access_token"]);
        $token->setPrivateKey($tokenSigningKey);

        return $token;
    }

}