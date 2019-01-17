<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 08. 15.
 * Time: 16:02
 */

namespace MedevAuth\Token\JWT\JWS\Repository;



use Lcobucci\JWT\Parser;
use MedevAuth\Services\Auth\OAuth\Entity\Client;
use MedevAuth\Services\Auth\OAuth\Entity\User;
use MedevAuth\Services\Auth\OAuth\Repository\Exception\RepositoryException;
use MedevAuth\Services\Auth\OAuth\Repository\TokenRepository;
use MedevAuth\Token\JWT\JWS\OAuthJWS;
use MedevSlim\Core\Database\SQL\SQLRepository;
use MedevSlim\Utils\UUID\UUID;
use Medoo\Medoo;


abstract class JWSRepository extends SQLRepository implements TokenRepository
{

    private $config;

    public function __construct(Medoo $db)
    {
        parent::__construct($db);
    }


    public function generateToken(Client $client, User $user, $scopes)
    {
        $token = new OAuthJWS();

        $token->setIdentifier(UUID::v4()); //Todo double check whether the V4 is fine.
        $token->setUser($user);
        $token->setClient($client);
        $token->setScopes($scopes);
        $token->setPrivateKey($this->config->privateKey);

        return $token;
    }


    public function validateSerializedToken($tokenString)
    {
        $token = $this->parseToken($tokenString);

        $token->setPrivateKey($this->config->privateKey);

        if (!$token->verifySignature($this->config->publicKey)) {
            throw new RepositoryException("Invalid token signature.");
        }

        if ($this->isTokenBlacklisted($token)) {
            throw new RepositoryException("Token blacklisted.");
        }
    }


    public function parseToken($tokenString)
    {
        $jwt = (new Parser())->parse($tokenString);

        $token = new OAuthJWS();
        $token->setJwt($jwt);

        $token->setIdentifier($jwt->getHeader("jti"));
        $token->setExpiration($jwt->getClaim("exp"));
        $token->setScopes($jwt->getClaim("scopes"));
        //Todo find out how can we add Client, User and Privatekey content from here

        return $token;
    }

}