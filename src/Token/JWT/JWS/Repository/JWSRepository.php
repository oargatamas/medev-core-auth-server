<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 15.
 * Time: 16:02
 */

namespace MedevAuth\Token\JWT\JWS\Repository;



use Lcobucci\JWT\Token;
use MedevAuth\Services\Auth\OAuth\Entity\Client;
use MedevAuth\Services\Auth\OAuth\Entity\GenericToken;
use MedevAuth\Services\Auth\OAuth\Entity\User;
use MedevAuth\Services\Auth\OAuth\Repository\SQLRepository;
use MedevAuth\Services\Auth\OAuth\Repository\TokenRepository;
use MedevAuth\Token\JWT\JWS\SignedJWT;
use MedevAuth\Token\JWT\JWT;
use MedevSlim\Core\APIService\Exceptions\UnauthorizedException;
use MedevSlim\Utils\UUID\UUID;
use Psr\Container\ContainerInterface;


abstract class JWSRepository extends SQLRepository implements TokenRepository
{

    private $config;

    public function __construct(ContainerInterface $container)
    {
        $this->config = $container->get("ApplicationConfig")["jwt"]; //Todo init config
    }

    /**
     * @param Client $client
     * @param User $user
     * @param string[] $scopes
     * @return GenericToken|SignedJWT
     */
    public function generateToken(Client $client, User $user, $scopes)
    {
        $token = new SignedJWT();

        $token->setIdentifier(UUID::v4()); //Todo double check whether the V4 is fine.
        $token->setUser($user);
        $token->setClient($client);
        $token->setScopes($scopes);
        $token->setPrivateKey($this->config->privateKey);

        return $token;
    }


    /**
     * @param string $tokenString
     * @return Token|SignedJWT
     * @throws UnauthorizedException
     */
    public function validateSerializedToken($tokenString)
    {
        /* @var SignedJWT $token*/
        $token = $this->parseToken($tokenString);

        $token->setPrivateKey($this->config->privateKey);

        if (!$token->verifySignature($this->config->publicKey)) {
            //"Invalid token signature"
            throw new UnauthorizedException();
        }

        if ($this->isTokenBlacklisted($token)) {
            //"Token is blacklisted"
            throw new UnauthorizedException();
        }

        return $token;
    }


    /**
     * @param string $tokenString
     * @return GenericToken|JWT
     */
    public function parseToken($tokenString)
    {
        return JWT::fromString($tokenString);
    }

}