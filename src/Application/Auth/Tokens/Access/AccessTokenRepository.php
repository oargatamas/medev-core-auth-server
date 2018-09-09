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


    protected function getPrivateClaims($args = [])
    {
        return [
            //"usr_id" => $args["user_id"],
            //"ip" => $args["ip_address"],
            //"scopes" => $args["user_scopes"]
        ];
    }

    public function isTokenBlacklisted(Token $token)
    {
        //we are not checking blacklist for AccessTokens due to it's short living.
        return false;
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
}