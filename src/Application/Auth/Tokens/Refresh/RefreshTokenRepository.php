<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 06.
 * Time: 11:02
 */

namespace MedevAuth\Application\Auth\Tokens\Refresh;


use Lcobucci\JWT\Token;
use MedevAuth\Token\JWT\JWS\JWSRepository;
use Medoo\Medoo;
use Psr\Container\ContainerInterface;

class RefreshTokenRepository extends JWSRepository
{
    /**
     * @var Medoo
     */
    private $database;

    public function __construct(ContainerInterface $container)
    {
        $this->database = $container->get("database");
        $config = $container->get("OauthRefreshTokenConfig");
        parent::__construct($config);
    }


    protected function getPrivateClaims($args = [])
    {
        return [
            //"usr_id" => $args["user_id"],
            //"ip" => $args["ip_address"],
            //"scopes" => "access_token"
        ];
    }

    public function isTokenBlacklisted(Token $token)
    {
        $foundTokens = $this->database->select(
            "oauth_refresh_tokens",
            [
                "id",
                "enabled"
            ],
            [
                "id[=]" => $token->getHeader("jti")
            ]
        );

        $isBlackListed = true;

        foreach ($foundTokens as $foundToken) {
            $isBlackListed = $foundToken["enabled"];
        }

        return $isBlackListed;
    }

    public function persistToken(Token $token)
    {
        $this->database->insert(
            "oauth_refresh_tokens",
            [
                "id" => $token->getHeader("jti"),
                "issuedBy" => $token->getClaim("iss"),
                "createdAt"=> time(),
                "ipAddress" => $token->getClaim("ip","0.0.0.0"),
                "enabled" => true
            ]
        );
    }

    public function revokeToken($tokenId)
    {
        $this->database->update(
            "oauth_refresh_tokens",
            [
                "enabled" => false
            ],
            [
                "id[=]" => $tokenId
            ]
        );
    }
}