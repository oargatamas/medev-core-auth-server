<?php
/**
 * Created by PhpStorm.
 * User: OargaTamas
 * Date: 2019. 02. 13.
 * Time: 16:03
 */

namespace MedevAuth\Services\Auth\OAuth\Actions\Token\JWT\JWS;


use Lcobucci\JWT\Parser;
use MedevAuth\Token\JWT\JWS\OAuthJWS;
use MedevSlim\Core\Action\Repository\APIRepositoryAction;

class ParseToken extends APIRepositoryAction
{

    /**
     * @param $args
     * @return OAuthJWS
     */
    public function handleRequest($args)
    {
        $jwt = (new Parser())->parse($args["token"]);

        $token = new OAuthJWS();
        $token->setJwt($jwt);

        $token->setIdentifier($jwt->getHeader("jti"));
        $token->setExpiration($jwt->getClaim("exp"));
        $token->setScopes($jwt->getClaim("scopes"));
        //Todo add Client, User and PrivateKey data here via actions or from config

        return $token;
    }
}