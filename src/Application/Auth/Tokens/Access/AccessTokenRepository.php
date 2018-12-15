<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 06.
 * Time: 10:05
 */

namespace MedevAuth\Application\Auth\Tokens\Access;


use Lcobucci\JWT\Token;
use MedevAuth\Token\JWT\JWS\JWSRepository;
use Medoo\Medoo;
use Psr\Container\ContainerInterface;


class AccessTokenRepository extends JWSRepository
{



    public function __construct(ContainerInterface $container)
    {
        $config = $container->get("OauthAccessTokenConfig");
        parent::__construct($config);
    }




    public function persistToken(Token $token)
    {
        //we are not persisting AccessTokens due to it's short living.
    }

    public function revokeToken($tokenId)
    {
        //we are not using any blacklisting for AccessTokens due to it's short living.
        //Therefore the revoking is also not defined.
    }

    public function isTokenBlackListed($tokenIdentifier)
    {
        //we are not using any blacklisting for AccessTokens due to it's short living.
        return false;
    }
}