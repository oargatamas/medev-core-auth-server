<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 06.
 * Time: 10:05
 */

namespace MedevAuth\TokenRepositories\Application;


use Lcobucci\JWT\Token;
use MedevAuth\Token\JWT\JWS\JWSConfiguration;
use MedevAuth\Token\TokenEntity;
use MedevSuite\Application\Auth\OAuth\Token\JWT\JWS\JWSRepository;
use Medoo\Medoo;
use Psr\Container\ContainerInterface;
use Slim\Container;

class AccessTokenRepository extends JWSRepository
{

    /**
     * @var Medoo
     */
    private $database;


    public function __construct(Container $container)
    {
        $this->database = $container->get("database");
        $config = $container->get("OauthAccessTokenConfig");
        parent::__construct($container, $config);
    }


    protected function getPrivateClaims($args = [])
    {
        return [
            "usr_id" => $args["user_id"],
            "ip" => $args["ip_address"],
            "scopes" => $args["user_scopes"]
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