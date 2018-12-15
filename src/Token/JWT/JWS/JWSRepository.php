<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 15.
 * Time: 16:02
 */

namespace MedevAuth\Token\JWT\JWS;


use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Keychain;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Lcobucci\JWT\Token;
use MedevAuth\Services\Auth\OAuth\Entity\ClientEntityInterface;
use MedevAuth\Services\Auth\OAuth\Entity\UserEntityInterface;
use MedevAuth\Services\Auth\OAuth\GrantType\Password\PasswordGrant;
use MedevAuth\Services\Auth\OAuth\Entity\TokenEntityInterface;
use MedevAuth\Services\Auth\OAuth\Repository\TokenRepositoryInterface;
use MedevAuth\Token\JWT\JWT;
use MedevSlim\Core\APIService\Exceptions\UnauthorizedException;
use MedevSlim\Utils\UUID\UUID;
use Psr\Container\ContainerInterface;


abstract class JWSRepository implements TokenRepositoryInterface
{

    private $config;

    public function __construct(ContainerInterface $container)
    {
        $this->config = $container->get("ApplicationConfig")["jwt"]; //Todo init config
    }

    /**
     * @param ClientEntityInterface $client
     * @param UserEntityInterface $user
     * @param array $scopes
     * @return TokenEntityInterface|SignedJWT
     */
    public function generateToken(ClientEntityInterface $client, UserEntityInterface $user, array $scopes)
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
     * @return TokenEntityInterface|SignedJWT
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
     * @return TokenEntityInterface|JWT
     */
    public function parseToken($tokenString)
    {
        return JWT::fromString($tokenString);
    }

}